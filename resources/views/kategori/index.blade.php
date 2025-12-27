@extends('layouts.app')

@section('title', 'Data Kategori')
@section('page-title', 'Data Kategori')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-tags me-2"></i>Daftar Kategori
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Nama Kategori</th>
                            <th>Jumlah Barang</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoris as $kategori)
                        <tr>
                            <td><strong>{{ $kategori->nama_kategori }}</strong></td>
                            <td>
                                <span class="badge bg-secondary">{{ $kategori->barangs_count }} barang</span>
                            </td>
                            <td>
                                <a href="{{ route('kategori.edit', $kategori->kategori_id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('kategori.destroy', $kategori->kategori_id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" {{ $kategori->barangs_count > 0 ? 'disabled' : '' }}>
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">
                                Belum ada kategori
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-plus-circle me-2"></i>Tambah Kategori
            </div>
            <div class="card-body">
                <form action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" 
                               id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori') }}" required>
                        @error('nama_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save me-1"></i>Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
