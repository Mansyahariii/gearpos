@extends('layouts.app')

@section('title', 'Stok Masuk')
@section('page-title', 'Stok Masuk (Pembelian)')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-truck me-2"></i>Daftar Pembelian</span>
        <a href="{{ route('pembelian.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus me-1"></i>Tambah Stok
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Petugas</th>
                        <th>Jumlah Item</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembelians as $pembelian)
                    <tr>
                        <td><strong>#{{ $pembelian->pembelian_id }}</strong></td>
                        <td>{{ $pembelian->tanggal->format('d/m/Y H:i') }}</td>
                        <td>{{ $pembelian->user->nama ?? '-' }}</td>
                        <td>{{ $pembelian->details->count() }} item</td>
                        <td>Rp {{ number_format($pembelian->total, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $pembelian->status == 'selesai' ? 'bg-success' : 'bg-warning' }}">
                                {{ ucfirst($pembelian->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('pembelian.show', $pembelian->pembelian_id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada data pembelian</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $pembelians->links() }}
    </div>
</div>
@endsection
