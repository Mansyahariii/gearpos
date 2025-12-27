@extends('layouts.app')

@section('title', 'Laporan Penjualan')
@section('page-title', 'Laporan Penjualan')

@section('content')
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('laporan.penjualan') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search me-1"></i>Tampilkan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Summary -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stats-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-receipt"></i>
                </div>
                <div>
                    <div class="stats-value">{{ $summary['total_transaksi'] }}</div>
                    <div class="stats-label">Total Transaksi</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div>
                    <div class="stats-value">Rp {{ number_format($summary['total_penjualan'], 0, ',', '.') }}</div>
                    <div class="stats-label">Total Penjualan</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-info bg-opacity-10 text-info">
                    <i class="bi bi-calculator"></i>
                </div>
                <div>
                    <div class="stats-value">Rp {{ number_format($summary['rata_rata'], 0, ',', '.') }}</div>
                    <div class="stats-label">Rata-rata per Transaksi</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detail Table -->
<div class="card">
    <div class="card-header">
        <i class="bi bi-table me-2"></i>Detail Transaksi
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No. Faktur</th>
                        <th>Tanggal</th>
                        <th>Kasir</th>
                        <th>Item</th>
                        <th>Pembayaran</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $trx)
                    <tr>
                        <td>#{{ str_pad($trx->transaksi_id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $trx->tanggal->format('d/m/Y H:i') }}</td>
                        <td>{{ $trx->kasir->nama ?? '-' }}</td>
                        <td>{{ $trx->details->count() }} item</td>
                        <td><span class="badge bg-secondary text-uppercase">{{ $trx->metode_pembayaran }}</span></td>
                        <td class="text-end">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
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
