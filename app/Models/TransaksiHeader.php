<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiHeader extends Model
{
    protected $primaryKey = 'transaksi_id';
    public $timestamps = false;

    protected $fillable = [
        'tanggal',
        'total_harga',
        'metode_pembayaran',
        'status',
        'kasir_id',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'total_harga' => 'decimal:2',
    ];

    // Relationships
    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id', 'user_id');
    }

    public function details()
    {
        return $this->hasMany(TransaksiDetail::class, 'transaksi_id', 'transaksi_id');
    }

    // Helper methods
    public function hitungTotal(): void
    {
        $this->total_harga = $this->details->sum('subtotal');
        $this->save();
    }

    public function selesaikan(): void
    {
        $this->status = 'selesai';
        $this->save();
    }

    public function batalkan(): void
    {
        $this->status = 'batal';
        $this->save();
    }
}
