<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\RiwayatStatusUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    /**
     * Menampilkan daftar inventaris unit perangkat telekomunikasi (FR-010).
     */
    public function index(Request $request)
    {
        $query = Unit::query();

        // 1. Filter Pencarian Teks
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('nama_unit', 'like', "%{$search}%")
                  ->orWhere('kode_unit', 'like', "%{$search}%")
                  ->orWhere('merk', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // 2. Filter Kategori (Semua, Repeater, Radio Base, Radio HT, Radio HF SSB)
        if ($request->filled('kategori') && $request->kategori !== 'Semua') {
            $query->where('kategori', $request->kategori);
        }

        // 3. Filter Status Unit
        if ($request->filled('status_unit')) {
            $query->where('status_unit', $request->status_unit);
        }

        // 4. Filter Tipe Unit (Sewa, Jual Lepas, Jual Kredit)
        if ($request->filled('tipe_unit')) {
            $query->where('tipe_unit', $request->tipe_unit);
        }

        // Summary Metric Cards 
        $totalUnit    = Unit::count();
        $unitTersedia = Unit::where('status_unit', 'Tersedia')->count();
        $unitDisewa   = Unit::where('status_unit', 'Disewa')->count();
        $unitTerjual  = Unit::whereIn('status_unit', ['Terjual', 'Terjual Kredit', 'Lunas Kredit'])->count();

        $persenTersedia = $totalUnit > 0 ? round(($unitTersedia / $totalUnit) * 100) : 0;
        $persenDisewa   = $totalUnit > 0 ? round(($unitDisewa / $totalUnit) * 100) : 0;

        // 5. Pagination & Sorting
        $units = $query->orderBy('id_unit', 'desc')->paginate(10)->withQueryString();

        // Kategori terdaftar untuk tab filter
        $kategoriList = ['Semua', 'Repeater', 'Radio Base', 'Radio HT', 'Radio HF SSB'];

        return view('admin.units.index', compact(
            'units',
            'totalUnit',
            'unitTersedia',
            'unitDisewa',
            'unitTerjual',
            'persenTersedia',
            'persenDisewa',
            'kategoriList'
        ));
    }

    /**
     * Menyimpan data unit baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_unit'   => 'required|string|max:20|unique:unit,kode_unit',
            'nama_unit'   => 'required|string|max:100',
            'merk'        => 'required|string|max:50',
            'kategori'    => 'required|string|max:50',
            'tipe_unit'   => 'required|string|in:Sewa,Jual Lepas,Jual Kredit',
            'harga_sewa'  => 'required|numeric|min:0',
            'harga_jual'  => 'nullable|numeric|min:0',
            'status_unit' => 'required|string|in:Tersedia,Disewa,Terjual,Terjual Kredit,Lunas Kredit',
            'deskripsi'   => 'nullable|string|max:1000',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
        ], [
            'kode_unit.unique' => 'Kode unit sudah digunakan, silakan gunakan kode lain.',
            'gambar.image'     => 'Berkas harus berupa gambar yang valid (JPEG, PNG, WEBP, SVG).',
            'gambar.max'       => 'Ukuran gambar maksimal adalah 4MB.',
        ]);

        $data = $validated;
        $data['harga_jual'] = $data['harga_jual'] ?? 0;

        // Handle upload foto perangkat
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('units', 'public');
            $data['gambar'] = $path;
        }

        $unit = Unit::create($data);

        return redirect()->route('admin.units.index')
            ->with('success', "Unit \"{$unit->nama_unit}\" ({$unit->kode_unit}) berhasil ditambahkan!");
    }

    /**
     * Memperbarui informasi data unit dan foto (Use Case 6).
     */
    public function update(Request $request, $id)
    {
        $unit = Unit::findOrFail($id);

        $validated = $request->validate([
            'kode_unit'        => "required|string|max:20|unique:unit,kode_unit,{$unit->id_unit},id_unit",
            'nama_unit'        => 'required|string|max:100',
            'merk'             => 'required|string|max:50',
            'kategori'         => 'required|string|max:50',
            'tipe_unit'        => 'required|string|in:Sewa,Jual Lepas,Jual Kredit',
            'harga_sewa'       => 'required|numeric|min:0',
            'harga_jual'       => 'nullable|numeric|min:0',
            'status_unit'      => 'required|string|in:Tersedia,Disewa,Terjual,Terjual Kredit,Lunas Kredit',
            'deskripsi'        => 'nullable|string|max:1000',
            'gambar'           => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'keterangan_status'=> 'nullable|string|max:255',
        ], [
            'kode_unit.unique' => 'Kode unit sudah digunakan oleh perangkat lain.',
            'gambar.image'     => 'Berkas harus berupa gambar valid.',
        ]);

        $data = $validated;
        $data['harga_jual'] = $data['harga_jual'] ?? 0;

        // Handle upload penggantian foto
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada di storage public
            if ($unit->gambar && Storage::disk('public')->exists($unit->gambar)) {
                Storage::disk('public')->delete($unit->gambar);
            }
            $path = $request->file('gambar')->store('units', 'public');
            $data['gambar'] = $path;
        }

        $unit->update($data);

        return redirect()->route('admin.units.index')
            ->with('success', "Data unit \"{$unit->nama_unit}\" berhasil diperbarui!");
    }

    /**
     * Menghapus data unit (Use Case 6).
     */
    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $nama = $unit->nama_unit;
        $kode = $unit->kode_unit;

        // Hapus file gambar dari disk
        if ($unit->gambar && Storage::disk('public')->exists($unit->gambar)) {
            Storage::disk('public')->delete($unit->gambar);
        }

        $unit->delete();

        return redirect()->route('admin.units.index')
            ->with('success', "Unit \"{$nama}\" ({$kode}) berhasil dihapus dari sistem.");
    }

    /**
     * Memperbarui status unit secara cepat (FR-015 & Use Case 10 Kelola Status Unit).
     */
    public function updateStatus(Request $request, $id)
    {
        $unit = Unit::findOrFail($id);

        $request->validate([
            'status_unit' => 'required|string|in:Tersedia,Disewa,Terjual,Terjual Kredit,Lunas Kredit',
            'keterangan'  => 'nullable|string|max:255',
        ]);

        $statusLama = $unit->status_unit;
        $statusBaru = $request->status_unit;

        $unit->status_unit = $statusBaru;
        $unit->save();

        return redirect()->route('admin.units.index')
            ->with('success', "Status unit {$unit->kode_unit} diubah menjadi {$statusBaru}.");
    }

    /**
     * Mengambil data unit dan riwayat status dalam format JSON untuk modal detail.
     */
    public function show($id)
    {
        $unit = Unit::with(['riwayatStatus.admin'])->findOrFail($id);

        return response()->json([
            'unit'         => $unit,
            'gambar_url'   => $unit->gambar_url,
            'harga_sewa_fmt' => $unit->formatted_harga_sewa,
            'harga_jual_fmt' => $unit->formatted_harga_jual,
            'riwayat'      => $unit->riwayatStatus->map(function ($r) {
                return [
                    'id_status'         => $r->id_status,
                    'status_lama'       => $r->status_lama ?? 'Awal',
                    'status_baru'       => $r->status_baru,
                    'tanggal'           => $r->tanggal_perubahan ? $r->tanggal_perubahan->format('d M Y, H:i') : '-',
                    'admin'             => $r->admin ? ($r->admin->nama ?: $r->admin->username) : 'System Admin',
                    'keterangan'        => $r->keterangan,
                ];
            }),
        ]);
    }
}
