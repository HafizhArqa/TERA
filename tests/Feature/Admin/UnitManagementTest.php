<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Unit;
use App\Models\RiwayatStatusUnit;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UnitManagementTest extends TestCase
{
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::firstOrCreate(
            ['email' => 'admin_unit_test@tera.com'],
            [
                'username' => 'adminunittest',
                'nama'     => 'Admin Unit Tester',
                'password' => bcrypt('password'),
                'role'     => 'Admin',
            ]
        );
    }

    public function test_guest_cannot_access_unit_management(): void
    {
        $response = $this->get('/admin/units');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_view_unit_management_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/units');
        $response->assertStatus(200);
        $response->assertSee('Kelola Data Unit');
        $response->assertSee('TOTAL UNIT');
        $response->assertSee('Daftar Unit Inventaris');
    }

    public function test_admin_can_create_new_unit_with_image(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('ht_test.png', 100, 'image/png');

        $testCode = 'TERA-TST-' . rand(100, 999);
        $data = [
            'kode_unit'   => $testCode,
            'nama_unit'   => 'Radio HT Unit Test Baru',
            'merk'        => 'Motorola',
            'kategori'    => 'Radio HT',
            'tipe_unit'   => 'Sewa',
            'harga_sewa'  => 185000,
            'harga_jual'  => 3500000,
            'status_unit' => 'Tersedia',
            'deskripsi'   => 'Frekuensi UHF 350-400 MHz untuk testing upload',
            'gambar'      => $file,
        ];

        $response = $this->actingAs($this->admin)->post('/admin/units', $data);
        $response->assertRedirect('/admin/units');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('unit', [
            'kode_unit' => $testCode,
            'nama_unit' => 'Radio HT Unit Test Baru',
        ]);

        $unit = Unit::where('kode_unit', $testCode)->first();
        $this->assertNotNull($unit->gambar);
        Storage::disk('public')->assertExists($unit->gambar);

        // Verifikasi audit log status otomatis (SDD Tabel 8)
        $this->assertDatabaseHas('riwayat_status_unit', [
            'id_unit'     => $unit->id_unit,
            'status_baru' => 'Tersedia',
        ]);
    }

    public function test_admin_can_update_unit(): void
    {
        $unit = Unit::create([
            'kode_unit'   => 'TERA-UPD-' . rand(100, 999),
            'nama_unit'   => 'Unit Sebelum Diubah',
            'merk'        => 'Motorola',
            'kategori'    => 'Radio HT',
            'tipe_unit'   => 'Sewa',
            'harga_sewa'  => 150000,
            'harga_jual'  => 2000000,
            'status_unit' => 'Tersedia',
        ]);

        $updateData = [
            'kode_unit'   => $unit->kode_unit,
            'nama_unit'   => 'Radio HT Berhasil Diubah',
            'merk'        => 'HYTERA',
            'kategori'    => 'Radio HT',
            'tipe_unit'   => 'Sewa',
            'harga_sewa'  => 220000,
            'harga_jual'  => 4000000,
            'status_unit' => 'Disewa',
            'deskripsi'   => 'Updated deskripsi unit',
        ];

        $response = $this->actingAs($this->admin)->put("/admin/units/{$unit->id_unit}", $updateData);
        $response->assertRedirect('/admin/units');

        $this->assertDatabaseHas('unit', [
            'id_unit'     => $unit->id_unit,
            'nama_unit'   => 'Radio HT Berhasil Diubah',
            'status_unit' => 'Disewa',
        ]);
    }

    public function test_admin_can_view_unit_detail_json(): void
    {
        $unit = Unit::first();
        $response = $this->actingAs($this->admin)->getJson("/admin/units/{$unit->id_unit}");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'unit',
            'gambar_url',
            'harga_sewa_fmt',
            'harga_jual_fmt',
            'riwayat',
        ]);
    }

    public function test_admin_can_delete_unit(): void
    {
        $unit = Unit::create([
            'kode_unit'   => 'TERA-DEL-' . rand(100, 999),
            'nama_unit'   => 'Unit Khusus Test Hapus',
            'merk'        => 'Alinco',
            'kategori'    => 'Radio HT',
            'tipe_unit'   => 'Sewa',
            'harga_sewa'  => 100000,
            'harga_jual'  => 1000000,
            'status_unit' => 'Tersedia',
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/units/{$unit->id_unit}");
        $response->assertRedirect('/admin/units');

        $this->assertDatabaseMissing('unit', [
            'id_unit' => $unit->id_unit,
        ]);
    }
}
