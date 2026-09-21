<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class Unit extends Model
{
    use HasFactory;

   
    protected $table = 'unit';

    /**
     * Primary key tabel unit.
     */
    protected $primaryKey = 'id_unit';

    /**
     * Kolom yang dapat diisi secara mass-assignment.
     */
    protected $fillable = [
        'kode_unit',
        'nama_unit',
        'merk',
        'kategori',
        'tipe_unit',
        'harga_sewa',
        'harga_jual',
        'status_unit',
        'lokasi',
        'klien_aktif',
        'info_tambahan',
        'tgl_kembali',
        'deskripsi',
        'gambar',
    ];

    /**
     * Casting tipe data kolom.
     */
    protected $casts = [
        'harga_sewa' => 'float',
        'harga_jual' => 'float',
        'tgl_kembali' => 'date',
    ];

    /**
     * Boot model untuk mencatat otomatis riwayat status (Implementasi Trg_log_status_unit).
     */
    protected static function booted()
    {
        static::created(function ($unit) {
            RiwayatStatusUnit::create([
                'id_unit'           => $unit->id_unit,
                'status_lama'       => null,
                'status_baru'       => $unit->status_unit,
                'tanggal_perubahan' => now(),
                'id_admin'          => Auth::id(),
                'keterangan'        => 'Unit baru ditambahkan ke sistem inventaris',
            ]);
        });

        static::updating(function ($unit) {
            if ($unit->isDirty('status_unit')) {
                $statusLama = $unit->getOriginal('status_unit');
                $statusBaru = $unit->status_unit;

                RiwayatStatusUnit::create([
                    'id_unit'           => $unit->id_unit,
                    'status_lama'       => $statusLama,
                    'status_baru'       => $statusBaru,
                    'tanggal_perubahan' => now(),
                    'id_admin'          => Auth::id(),
                    'keterangan'        => request()->input('keterangan_status') ?? "Status unit diubah dari {$statusLama} ke {$statusBaru}",
                ]);
            }
        });
    }

    /**
     * Relasi ke riwayat status unit (Tabel 8 SDD).
     */
    public function riwayatStatus()
    {
        return $this->hasMany(RiwayatStatusUnit::class, 'id_unit', 'id_unit')
            ->orderBy('tanggal_perubahan', 'desc');
    }

    /**
     * Accessor untuk URL Gambar Unit.
     */
    public function getGambarUrlAttribute(): string
    {
        if ($this->gambar) {
            if (str_starts_with($this->gambar, 'http://') || str_starts_with($this->gambar, 'https://')) {
                return $this->gambar;
            }
            if (Storage::disk('public')->exists($this->gambar)) {
                return asset('storage/' . $this->gambar);
            }
            if (file_exists(public_path($this->gambar))) {
                return asset($this->gambar);
            }
        }

        // SVG fallback placeholder jika unit belum memiliki gambar
        $inisial = urlencode(strtoupper(substr($this->nama_unit ?? 'U', 0, 2)));
        return "https://ui-avatars.com/api/?name={$inisial}&background=e2e8f0&color=475569&size=200&bold=true&format=svg";
    }

    /**
     * Format harga sewa rupiah.
     */
    public function getFormattedHargaSewaAttribute(): string
    {
        return 'Rp ' . number_format($this->harga_sewa, 0, ',', '.');
    }

    /**
     * Format harga jual rupiah.
     */
    public function getFormattedHargaJualAttribute(): string
    {
        return 'Rp ' . number_format($this->harga_jual, 0, ',', '.');
    }
}
