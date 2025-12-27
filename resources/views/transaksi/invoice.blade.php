@extends('layouts.app')

@section('title', 'Faktur #' . $transaksi->transaksi_id)
@section('page-title', 'Detail Transaksi')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card" id="invoice">
            <div class="card-body p-4">
                <!-- Header -->
                <div class="text-center mb-4">
                    <h2 class="mb-1"><i class="bi bi-gear-fill text-primary me-2"></i>GearPOS</h2>
                    <p class="text-muted mb-0">Toko Suku Cadang Motor & Mobil</p>
                </div>
                
                <hr>
                
                <!-- Invoice Info -->
                <div class="row mb-4">
                    <div class="col-6">
                        <strong>No. Faktur:</strong><br>
                        <span class="text-primary">#{{ str_pad($transaksi->transaksi_id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="col-6 text-end">
                        <strong>Tanggal:</strong><br>
                        {{ $transaksi->tanggal->format('d/m/Y H:i') }}
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-6">
                        <strong>Kasir:</strong><br>
                        {{ $transaksi->kasir->nama ?? '-' }}
                    </div>
                    <div class="col-6 text-end">
                        <strong>Status:</strong><br>
                        <span class="badge {{ $transaksi->status == 'selesai' ? 'bg-success' : ($transaksi->status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                            {{ ucfirst($transaksi->status) }}
                        </span>
                    </div>
                </div>
                
                <!-- Items -->
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Barang</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi->details as $detail)
                        <tr>
                            <td>{{ $detail->barang->nama_barang ?? 'Barang dihapus' }}</td>
                            <td class="text-center">{{ $detail->jumlah }}</td>
                            <td class="text-end">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-light">
                            <th colspan="3" class="text-end">TOTAL</th>
                            <th class="text-end">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
                
                <div class="row mt-4">
                    <div class="col-6">
                        <strong>Metode Pembayaran:</strong><br>
                        <span class="badge bg-primary text-uppercase">{{ $transaksi->metode_pembayaran }}</span>
                    </div>
                </div>
                
                <hr>
                
                <div class="text-center text-muted">
                    <small>Terima kasih atas kunjungan Anda!</small><br>
                    <small>Barang yang sudah dibeli tidak dapat dikembalikan.</small>
                </div>
            </div>
        </div>
        
        <div class="d-flex gap-2 mt-3 justify-content-center">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="bi bi-printer me-1"></i>Cetak
            </button>
            <a href="{{ route('transaksi.riwayat') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
</div>

@push('styles')
<style>
@media print {
    .sidebar, .top-navbar, .btn { display: none !important; }
    .main-content { margin-left: 0 !important; }
    .content-area { padding: 0 !important; }
    .card { box-shadow: none !important; }
}
</style>
@endpush
@endsection
