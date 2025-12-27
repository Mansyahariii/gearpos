@extends('layouts.app')

@section('title', 'Laporan Keuangan')
@section('page-title', 'Laporan Keuangan')

@section('content')
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('laporan.keuangan') }}" method="GET" class="row g-3">
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
                <div class="stats-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-arrow-down-circle"></i>
                </div>
                <div>
                    <div class="stats-value text-success">Rp {{ number_format($summary['total_pemasukan'], 0, ',', '.') }}</div>
                    <div class="stats-label">Total Pemasukan</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-danger bg-opacity-10 text-danger">
                    <i class="bi bi-arrow-up-circle"></i>
                </div>
                <div>
                    <div class="stats-value text-danger">Rp {{ number_format($summary['total_pengeluaran'], 0, ',', '.') }}</div>
                    <div class="stats-label">Total Pengeluaran</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon {{ $summary['saldo'] >= 0 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 {{ $summary['saldo'] >= 0 ? 'text-success' : 'text-danger' }}">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div>
                    <div class="stats-value {{ $summary['saldo'] >= 0 ? 'text-success' : 'text-danger' }}">
                        Rp {{ number_format($summary['saldo'], 0, ',', '.') }}
                    </div>
                    <div class="stats-label">Saldo</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detail Table -->
<div class="card">
    <div class="card-header">
        <i class="bi bi-table me-2"></i>Riwayat Keuangan
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Keterangan</th>
                        <th>Petugas</th>
                        <th class="text-end">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($keuangans as $keuangan)
                    <tr>
                        <td>{{ $keuangan->tanggal->format('d/m/Y H:i') }}</td>
                        <td>
                            <span class="badge {{ $keuangan->jenis == 'pemasukan' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($keuangan->jenis) }}
                            </span>
                        </td>
                        <td>{{ $keuangan->keterangan ?? '-' }}</td>
                        <td>{{ $keuangan->user->nama ?? '-' }}</td>
                        <td class="text-end {{ $keuangan->jenis == 'pemasukan' ? 'text-success' : 'text-danger' }}">
                            {{ $keuangan->jenis == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($keuangan->nominal, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
