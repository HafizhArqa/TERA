<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tabel Unit 
        if (!Schema::hasTable('unit')) {
            Schema::create('unit', function (Blueprint $table) {
                $table->id('id_unit');
                $table->string('kode_unit', 20)->unique();
                $table->string('nama_unit', 100);
                $table->string('merk', 50);
                $table->string('kategori', 50)->default('Radio HT');
                $table->string('tipe_unit', 20)->default('Sewa'); // Sewa, Jual Lepas, Jual Kredit
                $table->decimal('harga_sewa', 15, 2)->default(0);
                $table->decimal('harga_jual', 15, 2)->default(0);
                $table->string('status_unit', 20)->default('Tersedia'); // Tersedia, Disewa, Terjual, Terjual Kredit, Lunas Kredit
                $table->text('deskripsi')->nullable();
                $table->string('gambar', 255)->nullable();
                $table->timestamps();
            });
        }

        // 2. Tabel Riwayat_Status_Unit 
        if (!Schema::hasTable('riwayat_status_unit')) {
            Schema::create('riwayat_status_unit', function (Blueprint $table) {
                $table->id('id_status');
                $table->unsignedBigInteger('id_unit');
                $table->string('status_lama', 50)->nullable();
                $table->string('status_baru', 50);
                $table->dateTime('tanggal_perubahan')->useCurrent();
                $table->unsignedBigInteger('id_admin')->nullable();
                $table->string('keterangan', 255)->nullable();
                $table->timestamps();

                $table->foreign('id_unit')->references('id_unit')->on('unit')->onDelete('cascade');
                $table->foreign('id_admin')->references('id_user')->on('users')->onDelete('set null');
            });
        }

        // 3. View v_unit_tersedia 
        try {
            DB::statement("
                CREATE OR REPLACE VIEW v_unit_tersedia AS
                SELECT id_unit, kode_unit, nama_unit, merk, kategori, tipe_unit, harga_sewa, harga_jual, status_unit, gambar, deskripsi, created_at
                FROM unit
                WHERE status_unit = 'Tersedia'
            ");
        } catch (\Throwable $e) {
            // Ignore if view creation fails on non-MySQL environments
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            DB::statement("DROP VIEW IF EXISTS v_unit_tersedia");
        } catch (\Throwable $e) {}

        Schema::dropIfExists('riwayat_status_unit');
        Schema::dropIfExists('unit');
    }
};
