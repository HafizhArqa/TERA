<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan data lama 
        DB::table('riwayat_status_unit')->delete();
        DB::table('unit')->delete();

        $units = [
            [
                'kode_unit'     => 'RADIO-HT-001',
                'nama_unit'     => 'Radio Base-Motorola',
                'merk'          => 'Motorola',
                'kategori'      => 'HT Radios',
                'tipe_unit'     => 'Sewa',
                'harga_sewa'    => 375000,
                'harga_jual'    => 12500000,
                'status_unit'   => 'Tersedia',
                'lokasi'        => 'Rak A-1 HQ',
                'klien_aktif'   => null,
                'info_tambahan' => 'Last Service: 12 Oct 2023',
                'tgl_kembali'   => null,
                'deskripsi'     => 'Radio mobile base station Motorola frekuensi UHF 350-400 MHz dengan keandalan tinggi dan audio jernih.',
                'gambar'        => 'units/radio_base_m8628.jpg',
            ],
            [
                'kode_unit'     => 'MWL-ERI-042',
                'nama_unit'     => 'Radio Base-Motorola',
                'merk'          => 'Motorola',
                'kategori'      => 'Microwave Links',
                'tipe_unit'     => 'Sewa',
                'harga_sewa'    => 1250000,
                'harga_jual'    => 28000000,
                'status_unit'   => 'Disewa',
                'lokasi'        => 'Site Menara Cilegon',
                'klien_aktif'   => 'PT. Tech Solutions',
                'info_tambahan' => 'Current Client: PT. Tech Solutions',
                'tgl_kembali'   => '2026-11-15',
                'deskripsi'     => 'Perangkat microwave link transmission untuk transmisi data point-to-point kapasitas tinggi.',
                'gambar'        => 'units/radio_base_m8628.jpg',
            ],
            [
                'kode_unit'     => 'VSAT-KAI-009',
                'nama_unit'     => 'Radio HT-Motorola-CP1660',
                'merk'          => 'Motorola',
                'kategori'      => 'VSAT Terminals',
                'tipe_unit'     => 'Sewa',
                'harga_sewa'    => 175000,
                'harga_jual'    => 3200000,
                'status_unit'   => 'Tersedia',
                'lokasi'        => 'Storage Room B',
                'klien_aktif'   => null,
                'info_tambahan' => 'Battery Level: 98% Charged',
                'tgl_kembali'   => null,
                'deskripsi'     => 'Handy Talky komersial handal dengan keypad alphanumeric dan ketahanan baterai hingga 14 jam.',
                'gambar'        => 'units/ht_motorola.jpg',
            ],
            [
                'kode_unit'     => 'REP-SLR-9000',
                'nama_unit'     => 'Barret-4050',
                'merk'          => 'Barret',
                'kategori'      => 'HT Radios',
                'tipe_unit'     => 'Sewa',
                'harga_sewa'    => 30000000,
                'harga_jual'    => 285000000,
                'status_unit'   => 'Disewa',
                'lokasi'        => 'Mining Site B',
                'klien_aktif'   => 'PT Kalimantan Energi Prima',
                'info_tambahan' => 'Deployment Area: Mining Site B',
                'tgl_kembali'   => '2026-12-30',
                'deskripsi'     => 'Transceiver taktis HF generasi terbaru untuk komunikasi data dan suara jarak sangat jauh antar pulau.',
                'gambar'        => 'units/barret_4050.jpg',
            ],
            [
                'kode_unit'     => 'PWR-CUBE-01',
                'nama_unit'     => 'Barret-4050',
                'merk'          => 'Barret',
                'kategori'      => 'Power Systems',
                'tipe_unit'     => 'Sewa',
                'harga_sewa'    => 2500000,
                'harga_jual'    => 35000000,
                'status_unit'   => 'Tersedia',
                'lokasi'        => 'Warehouse A-4',
                'klien_aktif'   => null,
                'info_tambahan' => 'Storage Loc: Warehouse A-4',
                'tgl_kembali'   => null,
                'deskripsi'     => 'Power system backup unit dan solar inverter generator untuk perangkat pemancar radio remote area.',
                'gambar'        => 'units/barret_4050.jpg',
            ],
            [
                'kode_unit'     => 'BAT-RYN-012',
                'nama_unit'     => 'Barret-4050',
                'merk'          => 'Barret',
                'kategori'      => 'Power Systems',
                'tipe_unit'     => 'Sewa',
                'harga_sewa'    => 1800000,
                'harga_jual'    => 24000000,
                'status_unit'   => 'Disewa',
                'lokasi'        => 'Offshore Platform Delta',
                'klien_aktif'   => 'PT Nusantara Gas',
                'info_tambahan' => 'Return Due: 22 Nov 2026',
                'tgl_kembali'   => '2026-11-22',
                'deskripsi'     => 'Heavy duty battery bank 24V 200Ah kompatibel dengan transceiver Barret dan stasiun radio pangkalan.',
                'gambar'        => 'units/barret_4050.jpg',
            ],
            [
                'kode_unit'     => 'TERA-REP-5300',
                'nama_unit'     => 'Repeater - Motorola SLR 5300',
                'merk'          => 'Motorola',
                'kategori'      => 'Repeater',
                'tipe_unit'     => 'Sewa',
                'harga_sewa'    => 2000000,
                'harga_jual'    => 45000000,
                'status_unit'   => 'Tersedia',
                'lokasi'        => 'Server Rack 02 HQ',
                'klien_aktif'   => null,
                'info_tambahan' => 'Last Calibration: 05 Jan 2026',
                'tgl_kembali'   => null,
                'deskripsi'     => 'Repeater MOTOTRBO performa tinggi generasi baru mendukung mode digital DMR dan analog.',
                'gambar'        => 'units/repeater_slr5300.jpg',
            ],
            [
                'kode_unit'     => 'TERA-HT-2620',
                'nama_unit'     => 'Radio HT - Motorola XiR C2620',
                'merk'          => 'Motorola',
                'kategori'      => 'HT Radios',
                'tipe_unit'     => 'Jual Kredit',
                'harga_sewa'    => 175000,
                'harga_jual'    => 4100000,
                'status_unit'   => 'Terjual Kredit',
                'lokasi'        => 'Customer Care Unit',
                'klien_aktif'   => 'CV Logistik Sentosa',
                'info_tambahan' => 'Kredit Tenor: 6 Bulan',
                'tgl_kembali'   => null,
                'deskripsi'     => 'HT digital DMR dengan fitur dual direct mode dan privasi komunikasi tingkat tinggi.',
                'gambar'        => 'units/ht_motorola.jpg',
            ],
            [
                'kode_unit'     => 'TERA-HT-8660',
                'nama_unit'     => 'Radio HT - Motorola XiR P8660i',
                'merk'          => 'Motorola',
                'kategori'      => 'HT Radios',
                'tipe_unit'     => 'Jual Lepas',
                'harga_sewa'    => 340000,
                'harga_jual'    => 9500000,
                'status_unit'   => 'Terjual',
                'lokasi'        => 'Archived Depot',
                'klien_aktif'   => 'PT Waskita Karya',
                'info_tambahan' => 'Terjual Tunai / Lepas',
                'tgl_kembali'   => null,
                'deskripsi'     => 'Flagship digital portable radio dengan Bluetooth 4.0, accelerometer terintegrasi (Man Down), dan GPS.',
                'gambar'        => 'units/ht_motorola.jpg',
            ],
        ];

        $admin = \App\Models\User::where('role', 'Admin')->first();
        $adminId = $admin ? $admin->id_user : null;

        foreach ($units as $item) {
            $unit = Unit::create($item);

            // audit history jika unit dalam status Disewa, Terjual, dll.
            if ($unit->status_unit === 'Disewa') {
                \App\Models\RiwayatStatusUnit::create([
                    'id_unit'           => $unit->id_unit,
                    'status_lama'       => 'Tersedia',
                    'status_baru'       => 'Disewa',
                    'tanggal_perubahan' => now()->subDays(rand(2, 20)),
                    'id_admin'          => $adminId,
                    'keterangan'        => "Disewa oleh {$unit->klien_aktif} untuk keperluan operasional site.",
                ]);
            } elseif ($unit->status_unit === 'Terjual') {
                \App\Models\RiwayatStatusUnit::create([
                    'id_unit'           => $unit->id_unit,
                    'status_lama'       => 'Tersedia',
                    'status_baru'       => 'Terjual',
                    'tanggal_perubahan' => now()->subDays(5),
                    'id_admin'          => $adminId,
                    'keterangan'        => "Transaksi jual lepas lunas kepada {$unit->klien_aktif}.",
                ]);
            } elseif ($unit->status_unit === 'Terjual Kredit') {
                \App\Models\RiwayatStatusUnit::create([
                    'id_unit'           => $unit->id_unit,
                    'status_lama'       => 'Tersedia',
                    'status_baru'       => 'Terjual Kredit',
                    'tanggal_perubahan' => now()->subDays(12),
                    'id_admin'          => $adminId,
                    'keterangan'        => "Pengajuan kredit disetujui. DP dibayar oleh {$unit->klien_aktif}.",
                ]);
            }
        }
    }
}
