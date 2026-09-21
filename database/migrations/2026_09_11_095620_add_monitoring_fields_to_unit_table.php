<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('unit', function (Blueprint $table) {
            $table->string('lokasi', 100)->nullable()->after('status_unit');
            $table->string('klien_aktif', 150)->nullable()->after('lokasi');
            $table->string('info_tambahan', 150)->nullable()->after('klien_aktif');
            $table->date('tgl_kembali')->nullable()->after('info_tambahan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unit', function (Blueprint $table) {
            $table->dropColumn(['lokasi', 'klien_aktif', 'info_tambahan', 'tgl_kembali']);
        });
    }
};
