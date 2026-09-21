<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatStatusUnit extends Model
{
    use HasFactory;


    protected $table = 'riwayat_status_unit';

    /**
     * Primary key.
     */
    protected $primaryKey = 'id_status';

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'id_unit',
        'status_lama',
        'status_baru',
        'tanggal_perubahan',
        'id_admin',
        'keterangan',
    ];

    /**
     * Casts.
     */
    protected $casts = [
        'tanggal_perubahan' => 'datetime',
    ];

    /**
     * Relasi ke model Unit.
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'id_unit', 'id_unit');
    }

    /**
     * Relasi ke admin pembuat perubahan.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin', 'id_user');
    }
}
