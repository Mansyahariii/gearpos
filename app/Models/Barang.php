<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $primaryKey = 'barang_id';
    public $timestamps = false;

    protected $fillable = [
        'nama_barang',
        'kategori_id',
        'harga_beli',
        'harga_jual',
        'stok',
        'satuan',
        'lokasi_rak',
    ];

    protected $casts = [
        'harga_beli' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'last_update' => 'datetime',
    ];

    // Relationships
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'kategori_id');
    }

    public function transaksiDetails()
    {
        return $this->hasMany(TransaksiDetail::class, 'barang_id', 'barang_id');
    }

    public function pembelianDetails()
    {
        return $this->hasMany(PembelianDetail::class, 'barang_id', 'barang_id');
    }

    // Helper methods
    public function tambahStok(int $jumlah): void
    {
        $this->stok += $jumlah;
        $this->last_update = now();
        $this->save();
    }

    public function kurangiStok(int $jumlah): void
    {
        $this->stok -= $jumlah;
        $this->last_update = now();
        $this->save();
    }

    public function isStokCukup(int $jumlah): bool
    {
        return $this->stok >= $jumlah;
    }
}
