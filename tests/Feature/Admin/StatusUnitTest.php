<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Unit;
use App\Models\RiwayatStatusUnit;
use Tests\TestCase;

class StatusUnitTest extends TestCase
{
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::firstOrCreate(
            ['email' => 'admin_status_test@tera.com'],
            [
                'username' => 'adminstatustest',
                'nama'     => 'Admin Status Tester',
                'password' => bcrypt('password'),
                'role'     => 'Admin',
            ]
        );
    }

    public function test_guest_cannot_access_status_unit_page(): void
    {
        $response = $this->get('/admin/status-unit');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_view_status_unit_grid_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/status-unit');
        $response->assertStatus(200);
        $response->assertSee('Equipment Inventory Status');
        $response->assertSee('TOTAL UNITS');
        $response->assertSee('AVAILABLE');
        $response->assertSee('RENTED');
        $response->assertSee('Grid View');
        $response->assertSee('List View');
        $response->assertSee('Register New Unit');
        $response->assertSee('Add Unit');
    }

    public function test_admin_can_view_status_unit_list_mode(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/status-unit?view=list');
        $response->assertStatus(200);
        $response->assertSee('KODE UNIT');
        $response->assertSee('STATUS TERKINI');
        $response->assertSee('TARIF SEWA');
    }

    public function test_admin_can_update_status_unit_and_creates_audit_log(): void
    {
        $unit = Unit::first();
        $this->assertNotNull($unit, 'Seeder must have at least one unit');

        $response = $this->actingAs($this->admin)->patch("/admin/status-unit/{$unit->id_unit}", [
            'status_unit'   => 'Disewa',
            'klien_aktif'   => 'PT Telekomunikasi Seluler',
            'lokasi'        => 'Site BTS Merdeka',
            'info_tambahan' => 'Current Client: PT Telekomunikasi Seluler',
            'tgl_kembali'   => '2026-10-15',
            'keterangan'    => 'Pengalihan operasional sewa untuk project audit',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Verifikasi tabel unit
        $this->assertDatabaseHas('unit', [
            'id_unit'     => $unit->id_unit,
            'status_unit' => 'Disewa',
            'klien_aktif' => 'PT Telekomunikasi Seluler',
            'lokasi'      => 'Site BTS Merdeka',
        ]);

        // Verifikasi audit log di riwayat_status_unit (Tabel 8 SDD)
        $this->assertDatabaseHas('riwayat_status_unit', [
            'id_unit'     => $unit->id_unit,
            'status_baru' => 'Disewa',
            'keterangan'  => 'Pengalihan operasional sewa untuk project audit',
        ]);
    }

    public function test_admin_can_fetch_unit_status_history_json(): void
    {
        $unit = Unit::first();
        $response = $this->actingAs($this->admin)->getJson("/admin/status-unit/{$unit->id_unit}/history");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'unit' => [
                'id_unit',
                'kode_unit',
                'nama_unit',
                'status_unit',
            ],
            'riwayat' => [
                '*' => [
                    'id_status',
                    'status_lama',
                    'status_baru',
                    'tanggal',
                    'admin',
                    'keterangan',
                ]
            ]
        ]);
    }
}
