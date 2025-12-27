<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembelianHeader extends Model
{
    protected $primaryKey = 'pembelian_id';
    public $timestamps = false;

    protected $fillable = [
        'tanggal',
        'total',
        'user_id',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'total' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function details()
    {
        return $this->hasMany(PembelianDetail::class, 'pembelian_id', 'pembelian_id');
    }

    // Helper methods
    public function hitungTotal(): void
    {
        $this->total = $this->details->sum('subtotal');
        $this->save();
    }

    public function selesaikan(): void
    {
        $this->status = 'selesai';
        $this->save();
    }
}
