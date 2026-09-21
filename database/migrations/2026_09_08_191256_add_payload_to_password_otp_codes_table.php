<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('password_otp_codes', function (Blueprint $table) {
            // type: 'password_reset' atau 'register'
            $table->string('type')->default('password_reset')->after('email');
            // payload: data register (JSON) untuk tipe register, null untuk reset password
            $table->text('payload')->nullable()->after('type');
        });
    }

    public function down(): void
    {
        Schema::table('password_otp_codes', function (Blueprint $table) {
            $table->dropColumn(['type', 'payload']);
        });
    }
};
