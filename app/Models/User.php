<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'nama',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin.
     * Role ENUM  'Admin' / 'Pelanggan'
     */
    public function isAdmin(): bool
    {
        return strtolower($this->role) === 'admin';
    }

    /**
     * Check if user is pelanggan.
     */
    public function isPelanggan(): bool
    {
        return strtolower($this->role) === 'pelanggan';
    }

    
    public function getDisplayNameAttribute(): string
    {
        return $this->nama ?: $this->username ?: 'Pengguna';
    }

    /**
     * Compatibility accessor for default 'id' property.
     */
    public function getIdAttribute()
    {
        return $this->attributes['id_user'] ?? $this->getKey();
    }
}
