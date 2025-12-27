@extends('layouts.app')

@section('title', 'Detail Pembelian')
@section('page-title', 'Detail Pembelian')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-truck me-2"></i>Pembelian #{{ $pembelian->pembelian_id }}
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-6">
                        <strong>Tanggal:</strong><br>
                        {{ $pembelian->tanggal->format('d/m/Y H:i') }}
                    </div>
                    <div class="col-6">
                        <strong>Petugas:</strong><br>
                        {{ $pembelian->user->nama ?? '-' }}
                    </div>
                </div>
                
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Barang</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Harga Beli</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembelian->details as $detail)
                        <tr>
                            <td>{{ $detail->barang->nama_barang ?? '-' }}</td>
                            <td class="text-center">{{ $detail->jumlah }}</td>
                            <td class="text-end">Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-light">
                            <th colspan="3" class="text-end">TOTAL</th>
                            <th class="text-end">Rp {{ number_format($pembelian->total, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        <a href="{{ route('pembelian.index') }}" class="btn btn-secondary mt-3">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>
@endsection
