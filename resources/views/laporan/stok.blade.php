@extends('layouts.app')

@section('title', 'Laporan Stok')
@section('page-title', 'Laporan Stok Barang')

@section('content')
<!-- Summary -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-value">{{ $summary['total_jenis'] }}</div>
            <div class="stats-label">Jenis Barang</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-value">{{ number_format($summary['total_unit']) }}</div>
            <div class="stats-label">Total Unit</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-value">Rp {{ number_format($summary['nilai_stok'], 0, ',', '.') }}</div>
            <div class="stats-label">Nilai Stok</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-value text-warning">{{ $summary['stok_rendah'] }}</div>
            <div class="stats-label">Stok Rendah</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-box-seam me-2"></i>Data Stok Barang</span>
        <div>
            <a href="{{ route('laporan.stok', ['stok_rendah' => 1]) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-exclamation-triangle me-1"></i>Stok Rendah
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th class="text-end">Harga Beli</th>
                        <th class="text-end">Harga Jual</th>
                        <th class="text-center">Stok</th>
                        <th>Lokasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangs as $barang)
                    <tr>
                        <td><strong>{{ $barang->nama_barang }}</strong></td>
                        <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                        <td class="text-end">Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <span class="badge {{ $barang->stok == 0 ? 'bg-danger' : ($barang->stok < 10 ? 'bg-warning' : 'bg-success') }}">
                                {{ $barang->stok }} {{ $barang->satuan }}
                            </span>
                        </td>
                        <td>{{ $barang->lokasi_rak ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
