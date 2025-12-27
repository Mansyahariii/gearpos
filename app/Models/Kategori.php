<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $primaryKey = 'kategori_id';
    public $timestamps = false;

    protected $fillable = [
        'nama_kategori',
    ];

    // Relationships
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'kategori_id', 'kategori_id');
    }
}
