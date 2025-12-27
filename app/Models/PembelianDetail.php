<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    protected $primaryKey = 'detail_id';
    public $timestamps = false;

    protected $fillable = [
        'pembelian_id',
        'barang_id',
        'jumlah',
        'harga_beli',
        'subtotal',
    ];

    protected $casts = [
        'harga_beli' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relationships
    public function pembelianHeader()
    {
        return $this->belongsTo(PembelianHeader::class, 'pembelian_id', 'pembelian_id');
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
            $model->subtotal = $model->jumlah * $model->harga_beli;
        });
    }
}
