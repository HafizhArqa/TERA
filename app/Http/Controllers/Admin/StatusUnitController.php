<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\RiwayatStatusUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StatusUnitController extends Controller
{
    /**
     * Menampilkan antarmuka stok Status 
     */
    public function index(Request $request)
    {
        $query = Unit::query();

        // 1. Pencarian Teks
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('kode_unit', 'like', "%{$search}%")
                  ->orWhere('nama_unit', 'like', "%{$search}%")
                  ->orWhere('merk', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhere('klien_aktif', 'like', "%{$search}%")
                  ->orWhere('info_tambahan', 'like', "%{$search}%");
            });
        }

        // 2. Filter Kategori (All Categories, HT Radios, Microwave Links, VSAT Terminals, Power Systems, Repeater)
        if ($request->filled('kategori') && $request->kategori !== 'All Categories') {
            $query->where('kategori', $request->kategori);
        }

        // 3. Filter Status Unit (Tersedia, Disewa, Terjual, Terjual Kredit, Lunas Kredit)
        if ($request->filled('status_unit') && $request->status_unit !== 'All') {
            $query->where('status_unit', $request->status_unit);
        }

        // Summary Metric Cards 
        $totalUnit    = Unit::count();
        $unitTersedia = Unit::where('status_unit', 'Tersedia')->count();
        $unitDisewa   = Unit::where('status_unit', 'Disewa')->count();

        // Daftar kategori untuk filter pills
        $categories = [
            'All Categories',
            'HT Radios',
            'Microwave Links',
            'VSAT Terminals',
            'Power Systems',
            'Repeater',
        ];

        // Mode tampilan: grid / list 
        $viewMode = $request->get('view', 'grid');

        // Paginate (8 per page agar pas dengan grid kartu + Add Unit card)
        $units = $query->orderBy('id_unit', 'asc')->paginate(8)->withQueryString();

        return view('admin.status-unit.index', compact(
            'units',
            'totalUnit',
            'unitTersedia',
            'unitDisewa',
            'categories',
            'viewMode'
        ));
    }

    /**
     * Memperbarui status unit (FR-015, Use Case 10: Kelola Status Unit, Sequence Diagram 10).
     */
    public function updateStatus(Request $request, $id)
    {
        $unit = Unit::findOrFail($id);

        $validated = $request->validate([
            'status_unit'   => 'required|string|in:Tersedia,Disewa,Terjual,Terjual Kredit,Lunas Kredit',
            'keterangan'    => 'nullable|string|max:255',
            'klien_aktif'   => 'nullable|string|max:150',
            'lokasi'        => 'nullable|string|max:100',
            'info_tambahan' => 'nullable|string|max:150',
            'tgl_kembali'   => 'nullable|date',
        ]);

        $statusLama = $unit->status_unit;
        $statusBaru = $validated['status_unit'];

        $unit->status_unit   = $statusBaru;
        if ($request->has('lokasi')) {
            $unit->lokasi = $validated['lokasi'];
        }
        if ($request->has('klien_aktif')) {
            $unit->klien_aktif = $validated['klien_aktif'];
        }
        if ($request->has('info_tambahan')) {
            $unit->info_tambahan = $validated['info_tambahan'];
        }
        if ($request->has('tgl_kembali')) {
            $unit->tgl_kembali = $validated['tgl_kembali'];
        }

        // Catat ke riwayat perubahan status (Tabel 8 SDD) jika ada perubahan atau catatan
        $keterangan = $validated['keterangan'] ?? "Perubahan status unit dari {$statusLama} menjadi {$statusBaru}";
        
        $unit->save();

        RiwayatStatusUnit::create([
            'id_unit'           => $unit->id_unit,
            'status_lama'       => $statusLama,
            'status_baru'       => $statusBaru,
            'tanggal_perubahan' => now(),
            'id_admin'          => Auth::id(),
            'keterangan'        => $keterangan,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Status perangkat {$unit->kode_unit} berhasil diubah menjadi {$statusBaru}.",
                'unit'    => $unit,
            ]);
        }

        return redirect()->back()->with('success', "Status perangkat {$unit->kode_unit} berhasil diperbarui menjadi {$statusBaru}.");
    }

    /**
     * Mengambil riwayat perubahan status perangkat untuk modal audit trail (Tabel 8 SDD).
     */
    public function history($id)
    {
        $unit = Unit::with(['riwayatStatus.admin'])->findOrFail($id);

        $riwayat = $unit->riwayatStatus->map(function ($r) {
            return [
                'id_status'   => $r->id_status,
                'status_lama' => $r->status_lama ?? 'Awal',
                'status_baru' => $r->status_baru,
                'tanggal'     => $r->tanggal_perubahan ? $r->tanggal_perubahan->format('d M Y, H:i') : '-',
                'admin'       => $r->admin ? ($r->admin->nama ?: $r->admin->username) : 'System Administrator',
                'keterangan'  => $r->keterangan ?? '-',
            ];
        });

        return response()->json([
            'unit'    => [
                'id_unit'     => $unit->id_unit,
                'kode_unit'   => $unit->kode_unit,
                'nama_unit'   => $unit->nama_unit,
                'status_unit' => $unit->status_unit,
                'lokasi'      => $unit->lokasi,
                'klien_aktif' => $unit->klien_aktif,
            ],
            'riwayat' => $riwayat,
        ]);
    }

    /**
     * Mendaftarkan unit baru secara cepat dari halaman Status Unit (Tombol + Register New Unit).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_unit'     => 'required|string|max:20|unique:unit,kode_unit',
            'nama_unit'     => 'required|string|max:100',
            'merk'          => 'required|string|max:50',
            'kategori'      => 'required|string|max:50',
            'tipe_unit'     => 'required|string|in:Sewa,Jual Lepas,Jual Kredit',
            'harga_sewa'    => 'required|numeric|min:0',
            'harga_jual'    => 'nullable|numeric|min:0',
            'status_unit'   => 'required|string|in:Tersedia,Disewa,Terjual,Terjual Kredit,Lunas Kredit',
            'lokasi'        => 'nullable|string|max:100',
            'klien_aktif'   => 'nullable|string|max:150',
            'info_tambahan' => 'nullable|string|max:150',
            'deskripsi'     => 'nullable|string|max:1000',
            'gambar'        => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
        ]);

        $data = $validated;
        $data['harga_jual'] = $data['harga_jual'] ?? 0;

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('units', 'public');
        }

        $unit = Unit::create($data);

        return redirect()->route('admin.status-unit.index')
            ->with('success', "Unit \"{$unit->nama_unit}\" ({$unit->kode_unit}) berhasil didaftarkan ke sistem!");
    }
}
