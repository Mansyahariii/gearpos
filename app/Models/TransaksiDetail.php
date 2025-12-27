<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    protected $primaryKey = 'detail_id';
    public $timestamps = false;

    protected $fillable = [
        'transaksi_id',
        'barang_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relationships
    public function transaksiHeader()
    {
        return $this->belongsTo(TransaksiHeader::class, 'transaksi_id', 'transaksi_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'barang_id');
    }

    // Auto-calculate subtotal
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->subtotal = $model->jumlah * $model->harga_satuan;
        });
    }
}
