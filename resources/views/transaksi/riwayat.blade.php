@extends('layouts.app')

@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-receipt me-2"></i>Daftar Transaksi
    </div>
    <div class="card-body">
        <!-- Filter -->
        <form action="{{ route('transaksi.riwayat') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="bi bi-search me-1"></i>Filter
                </button>
            </div>
        </form>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No. Faktur</th>
                        <th>Tanggal</th>
                        <th>Kasir</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $trx)
                    <tr>
                        <td><strong>#{{ str_pad($trx->transaksi_id, 6, '0', STR_PAD_LEFT) }}</strong></td>
                        <td>{{ $trx->tanggal->format('d/m/Y H:i') }}</td>
                        <td>{{ $trx->kasir->nama ?? '-' }}</td>
                        <td>Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                        <td><span class="badge bg-secondary text-uppercase">{{ $trx->metode_pembayaran }}</span></td>
                        <td>
                            <span class="badge {{ $trx->status == 'selesai' ? 'bg-success' : ($trx->status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                {{ ucfirst($trx->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('transaksi.show', $trx->transaksi_id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $transaksis->links() }}
    </div>
</div>
@endsection
