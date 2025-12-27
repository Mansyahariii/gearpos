<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    protected $primaryKey = 'keuangan_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'tanggal',
        'jenis',
        'keterangan',
        'nominal',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'nominal' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Scopes
    public function scopePemasukan($query)
    {
        return $query->where('jenis', 'pemasukan');
    }

    public function scopePengeluaran($query)
    {
        return $query->where('jenis', 'pengeluaran');
    }

    // Helper
    public function isPemasukan(): bool
    {
        return $this->jenis === 'pemasukan';
    }
}
