<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'nama',
        'username',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Check role methods
    public function isKasir(): bool
    {
        return $this->role === 'kasir';
    }

    public function isManajer(): bool
    {
        return $this->role === 'manajer';
    }

    public function isStafGudang(): bool
    {
        return $this->role === 'staf_gudang';
    }

    public function isPemilik(): bool
    {
        return $this->role === 'pemilik';
    }

    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }

    // Relationships
    public function transaksiHeaders()
    {
        return $this->hasMany(TransaksiHeader::class, 'kasir_id', 'user_id');
    }

    public function pembelianHeaders()
    {
        return $this->hasMany(PembelianHeader::class, 'user_id', 'user_id');
    }

    public function keuangans()
    {
        return $this->hasMany(Keuangan::class, 'user_id', 'user_id');
    }
}
