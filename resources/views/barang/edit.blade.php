@extends('layouts.app')

@section('title', 'Edit Barang')
@section('page-title', 'Edit Barang')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-pencil me-2"></i>Form Edit Barang
    </div>
    <div class="card-body">
        <form action="{{ route('barang.update', $barang->barang_id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" 
                           id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                    @error('nama_barang')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="kategori_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                    <select class="form-select @error('kategori_id') is-invalid @enderror" 
                            id="kategori_id" name="kategori_id" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->kategori_id }}" {{ old('kategori_id', $barang->kategori_id) == $kategori->kategori_id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="harga_beli" class="form-label">Harga Beli <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control @error('harga_beli') is-invalid @enderror" 
                               id="harga_beli" name="harga_beli" value="{{ old('harga_beli', $barang->harga_beli) }}" min="0" required>
                    </div>
                    @error('harga_beli')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="harga_jual" class="form-label">Harga Jual <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control @error('harga_jual') is-invalid @enderror" 
                               id="harga_jual" name="harga_jual" value="{{ old('harga_jual', $barang->harga_jual) }}" min="0" required>
                    </div>
                    @error('harga_jual')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                           id="stok" name="stok" value="{{ old('stok', $barang->stok) }}" min="0" required>
                    @error('stok')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="satuan" class="form-label">Satuan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('satuan') is-invalid @enderror" 
                           id="satuan" name="satuan" value="{{ old('satuan', $barang->satuan) }}" required>
                    @error('satuan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="lokasi_rak" class="form-label">Lokasi Rak</label>
                    <input type="text" class="form-control @error('lokasi_rak') is-invalid @enderror" 
                           id="lokasi_rak" name="lokasi_rak" value="{{ old('lokasi_rak', $barang->lokasi_rak) }}">
                    @error('lokasi_rak')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Update
                </button>
                <a href="{{ route('barang.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
