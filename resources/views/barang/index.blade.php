@extends('layouts.app')

@section('title', 'Data Barang')
@section('page-title', 'Data Barang')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-box-seam me-2"></i>Daftar Barang</span>
        <a href="{{ route('barang.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus me-1"></i>Tambah Barang
        </a>
    </div>
    <div class="card-body">
        <!-- Filter -->
        <form action="{{ route('barang.index') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari barang..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->kategori_id }}" {{ request('kategori') == $kategori->kategori_id ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="bi bi-search me-1"></i>Filter
                </button>
            </div>
        </form>
        
        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Lokasi</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangs as $barang)
                    <tr>
                        <td>
                            <strong>{{ $barang->nama_barang }}</strong>
                        </td>
                        <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                        <td>Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $barang->stok == 0 ? 'bg-danger' : ($barang->stok < 10 ? 'bg-warning' : 'bg-success') }}">
                                {{ $barang->stok }} {{ $barang->satuan }}
                            </span>
                        </td>
                        <td>{{ $barang->lokasi_rak ?? '-' }}</td>
                        <td>
                            <a href="{{ route('barang.edit', $barang->barang_id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('barang.destroy', $barang->barang_id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox display-6 d-block mb-2"></i>
                            Belum ada data barang
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $barangs->links() }}
        </div>
    </div>
</div>
@endsection
