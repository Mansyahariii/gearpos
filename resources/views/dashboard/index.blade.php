@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    @if(auth()->user()->isKasir())
    <!-- Kasir Dashboard -->
    <div class="col-md-4">
        <div class="stats-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-receipt"></i>
                </div>
                <div>
                    <div class="stats-value">{{ $transaksi_hari_ini ?? 0 }}</div>
                    <div class="stats-label">Transaksi Hari Ini</div>
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
                    <div class="stats-value">Rp {{ number_format($total_penjualan_hari_ini ?? 0, 0, ',', '.') }}</div>
                    <div class="stats-label">Total Penjualan Hari Ini</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div>
                    <div class="stats-value">{{ $transaksi_pending ?? 0 }}</div>
                    <div class="stats-label">Transaksi Pending</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Action Card -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body text-center py-4">
                <i class="bi bi-cart-plus display-4 text-primary mb-3"></i>
                <h5>Mulai Transaksi Baru</h5>
                <p class="text-muted mb-3">Klik tombol di bawah untuk memulai transaksi penjualan</p>
                <a href="{{ route('transaksi.index') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Transaksi Baru
                </a>
            </div>
        </div>
    </div>
    
    <!-- Recent Transactions -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-2"></i>Transaksi Terakhir</span>
                <a href="{{ route('transaksi.riwayat') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No. Transaksi</th>
                                <th>Total</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($transaksi_terakhir) && count($transaksi_terakhir) > 0)
                                @foreach($transaksi_terakhir as $trx)
                                <tr>
                                    <td><code>{{ $trx->transaksi_id }}</code></td>
                                    <td>Rp {{ number_format($trx->total_harga ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ $trx->tanggal ? $trx->tanggal->format('H:i') : '-' }}</td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox display-6 d-block mb-2"></i>
                                        Belum ada transaksi hari ini
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Popular Products Today -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-fire me-2 text-danger"></i>Produk Populer Hari Ini
            </div>
            <div class="card-body">
                <div class="row">
                    @if(isset($produk_populer) && count($produk_populer) > 0)
                        @foreach($produk_populer as $index => $produk)
                        <div class="col-md-4 col-lg-2 mb-3">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="badge bg-primary mb-2">#{{ $index + 1 }}</div>
                                <div class="fw-semibold small">{{ $produk->nama_barang ?? 'Produk' }}</div>
                                <div class="text-muted small">{{ $produk->total_qty ?? 0 }} terjual</div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="col-12 text-center text-muted py-3">
                            <i class="bi bi-box-seam display-6 d-block mb-2"></i>
                            Belum ada data penjualan hari ini
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
    
    @if(auth()->user()->isStafGudang())
    <!-- Staf Gudang Dashboard -->
    <div class="col-md-4">
        <div class="stats-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div>
                    <div class="stats-value">{{ $total_barang ?? 0 }}</div>
                    <div class="stats-label">Total Jenis Barang</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div>
                    <div class="stats-value">{{ $stok_rendah ?? 0 }}</div>
                    <div class="stats-label">Stok Rendah (&lt;10)</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-danger bg-opacity-10 text-danger">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div>
                    <div class="stats-value">{{ $stok_kosong ?? 0 }}</div>
                    <div class="stats-label">Stok Kosong</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Stock by Category Chart -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-bar-chart me-2"></i>Stok per Kategori
            </div>
            <div class="card-body">
                <canvas id="stockByCategoryChart" height="250"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Recent Stock Movement -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-arrow-left-right me-2"></i>Pergerakan Stok Terakhir</span>
                <a href="{{ route('pembelian.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th>Jenis</th>
                                <th>Qty</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($pergerakan_stok) && count($pergerakan_stok) > 0)
                                @foreach($pergerakan_stok as $pembelian)
                                    @foreach($pembelian->details as $detail)
                                    <tr>
                                        <td>{{ Str::limit($detail->barang->nama_barang ?? '-', 20) }}</td>
                                        <td>
                                            <span class="badge bg-success">Masuk</span>
                                        </td>
                                        <td>+{{ $detail->jumlah ?? 0 }}</td>
                                        <td>{{ $pembelian->tanggal ? $pembelian->tanggal->format('d/m') : '-' }}</td>
                                    </tr>
                                    @endforeach
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox display-6 d-block mb-2"></i>
                                        Belum ada pergerakan stok
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    @if(isset($barang_stok_rendah) && $barang_stok_rendah->count() > 0)
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-exclamation-triangle text-warning me-2"></i>Barang Stok Rendah</span>
                <a href="{{ route('pembelian.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus me-1"></i>Tambah Stok
                </a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Lokasi Rak</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barang_stok_rendah as $barang)
                        <tr>
                            <td>{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $barang->stok == 0 ? 'bg-danger' : 'bg-warning' }}">
                                    {{ $barang->stok }} {{ $barang->satuan }}
                                </span>
                            </td>
                            <td>{{ $barang->lokasi_rak ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
    @endif
    
    @if(auth()->user()->isManajer())
    <!-- Manajer Dashboard -->
    <div class="col-md-3">
        <div class="stats-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-receipt"></i>
                </div>
                <div>
                    <div class="stats-value">{{ $transaksi_hari_ini ?? 0 }}</div>
                    <div class="stats-label">Transaksi Hari Ini</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div>
                    <div class="stats-value">Rp {{ number_format($penjualan_hari_ini ?? 0, 0, ',', '.') }}</div>
                    <div class="stats-label">Penjualan Hari Ini</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-info bg-opacity-10 text-info">
                    <i class="bi bi-graph-up"></i>
                </div>
                <div>
                    <div class="stats-value">Rp {{ number_format($penjualan_bulan_ini ?? 0, 0, ',', '.') }}</div>
                    <div class="stats-label">Penjualan Bulan Ini</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div>
                    <div class="stats-value">{{ $stok_rendah ?? 0 }}</div>
                    <div class="stats-label">Stok Rendah</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Weekly Sales Chart -->
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-graph-up me-2"></i>Grafik Penjualan Mingguan
            </div>
            <div class="card-body">
                <canvas id="weeklySalesChart" height="200"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Category Distribution -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-pie-chart me-2"></i>Penjualan per Kategori
            </div>
            <div class="card-body">
                <canvas id="categoryChart" height="200"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Top Selling Products -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-trophy me-2 text-warning"></i>Top 5 Produk Terlaris Bulan Ini
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">Rank</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Terjual</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($top_products) && count($top_products) > 0)
                            @foreach($top_products as $index => $product)
                            <tr>
                                <td>
                                    @if($index == 0)
                                        <span class="badge bg-warning text-dark">🥇 1</span>
                                    @elseif($index == 1)
                                        <span class="badge bg-secondary">🥈 2</span>
                                    @elseif($index == 2)
                                        <span class="badge bg-danger">🥉 3</span>
                                    @else
                                        <span class="badge bg-light text-dark">{{ $index + 1 }}</span>
                                    @endif
                                </td>
                                <td class="fw-medium">{{ $product->nama_barang ?? 'Produk' }}</td>
                                <td>{{ $product->kategori ?? '-' }}</td>
                                <td>{{ $product->total_qty ?? 0 }} unit</td>
                                <td class="fw-semibold">Rp {{ number_format($product->total_revenue ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox display-6 d-block mb-2"></i>
                                    Belum ada data penjualan
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
    
    @if(auth()->user()->isPemilik())
    <!-- Pemilik Dashboard -->
    <div class="col-md-3">
        <div class="stats-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div>
                    <div class="stats-value">Rp {{ number_format($penjualan_hari_ini ?? 0, 0, ',', '.') }}</div>
                    <div class="stats-label">Penjualan Hari Ini</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-graph-up"></i>
                </div>
                <div>
                    <div class="stats-value">Rp {{ number_format($penjualan_bulan_ini ?? 0, 0, ',', '.') }}</div>
                    <div class="stats-label">Penjualan Bulan Ini</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-arrow-down-circle"></i>
                </div>
                <div>
                    <div class="stats-value">Rp {{ number_format($total_pemasukan ?? 0, 0, ',', '.') }}</div>
                    <div class="stats-label">Pemasukan Bulan Ini</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-danger bg-opacity-10 text-danger">
                    <i class="bi bi-arrow-up-circle"></i>
                </div>
                <div>
                    <div class="stats-value">Rp {{ number_format($total_pengeluaran ?? 0, 0, ',', '.') }}</div>
                    <div class="stats-label">Pengeluaran Bulan Ini</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Finance Chart -->
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-graph-up-arrow me-2"></i>Grafik Keuangan Mingguan
            </div>
            <div class="card-body">
                <canvas id="financeChart" height="200"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Expense Distribution -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-pie-chart me-2"></i>Distribusi Pengeluaran
            </div>
            <div class="card-body">
                <canvas id="expenseChart" height="200"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Financial Summary -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-bar-chart me-2"></i>Ringkasan Keuangan
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <h4 class="text-success mb-1">Rp {{ number_format($total_pemasukan ?? 0, 0, ',', '.') }}</h4>
                        <p class="text-muted small mb-0">Total Pemasukan</p>
                    </div>
                    <div class="col-4">
                        <h4 class="text-danger mb-1">Rp {{ number_format($total_pengeluaran ?? 0, 0, ',', '.') }}</h4>
                        <p class="text-muted small mb-0">Total Pengeluaran</p>
                    </div>
                    <div class="col-4">
                        <h4 class="{{ ($total_pemasukan ?? 0) - ($total_pengeluaran ?? 0) >= 0 ? 'text-success' : 'text-danger' }} mb-1">
                            Rp {{ number_format(($total_pemasukan ?? 0) - ($total_pengeluaran ?? 0), 0, ',', '.') }}
                        </h4>
                        <p class="text-muted small mb-0">Saldo</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Profit Trend -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-trending-up me-2"></i>Tren Profit Bulanan
            </div>
            <div class="card-body">
                <canvas id="profitChart" height="150"></canvas>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart.js default configuration
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.plugins.legend.labels.usePointStyle = true;
    
    @if(auth()->user()->isStafGudang())
    // Stock by Category Chart
    const stockCtx = document.getElementById('stockByCategoryChart');
    if (stockCtx) {
        new Chart(stockCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($kategori_labels ?? ['Ban', 'Oli', 'Mesin', 'Elektrik', 'Lainnya']) !!},
                datasets: [{
                    label: 'Jumlah Stok',
                    data: {!! json_encode($kategori_stok ?? [45, 32, 28, 15, 20]) !!},
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(249, 115, 22, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                        'rgba(107, 114, 128, 0.8)'
                    ],
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }
    @endif
    
    @if(auth()->user()->isManajer())
    // Weekly Sales Chart
    const salesCtx = document.getElementById('weeklySalesChart');
    if (salesCtx) {
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($sales_labels ?? ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']) !!},
                datasets: [{
                    label: 'Penjualan',
                    data: {!! json_encode($sales_data ?? [4200000, 3800000, 5100000, 4600000, 7200000, 6100000, 5800000]) !!},
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000000).toFixed(1) + 'jt';
                            }
                        }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    }
    
    // Category Chart
    const catCtx = document.getElementById('categoryChart');
    if (catCtx) {
        new Chart(catCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($category_labels ?? ['Ban', 'Oli', 'Mesin', 'Elektrik', 'Lainnya']) !!},
                datasets: [{
                    data: {!! json_encode($category_data ?? [30, 25, 20, 15, 10]) !!},
                    backgroundColor: ['#3b82f6', '#10b981', '#f97316', '#8b5cf6', '#6b7280'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 15, font: { size: 11 } }
                    }
                },
                cutout: '60%'
            }
        });
    }
    @endif
    
    @if(auth()->user()->isPemilik())
    // Finance Chart
    const finCtx = document.getElementById('financeChart');
    if (finCtx) {
        new Chart(finCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($finance_labels ?? ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']) !!},
                datasets: [{
                    label: 'Pemasukan',
                    data: {!! json_encode($pemasukan_data ?? [4200000, 3800000, 5100000, 4600000, 7200000, 6100000, 5800000]) !!},
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: false,
                    tension: 0.4,
                    borderWidth: 2
                }, {
                    label: 'Pengeluaran',
                    data: {!! json_encode($pengeluaran_data ?? [2800000, 3200000, 2900000, 3100000, 4500000, 3800000, 3200000]) !!},
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    fill: false,
                    tension: 0.4,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000000).toFixed(1) + 'jt';
                            }
                        }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    }
    
    // Expense Chart
    const expCtx = document.getElementById('expenseChart');
    if (expCtx) {
        new Chart(expCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pembelian Stok', 'Operasional', 'Gaji', 'Lainnya'],
                datasets: [{
                    data: {!! json_encode($expense_data ?? [45, 25, 20, 10]) !!},
                    backgroundColor: ['#3b82f6', '#f97316', '#10b981', '#8b5cf6'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 15, font: { size: 11 } }
                    }
                },
                cutout: '60%'
            }
        });
    }
    
    // Profit Chart
    const profitCtx = document.getElementById('profitChart');
    if (profitCtx) {
        new Chart(profitCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($profit_labels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun']) !!},
                datasets: [{
                    label: 'Profit',
                    data: {!! json_encode($profit_data ?? [12000000, 15000000, 11000000, 18000000, 14000000, 20000000]) !!},
                    backgroundColor: function(context) {
                        const value = context.raw;
                        return value >= 0 ? 'rgba(16, 185, 129, 0.8)' : 'rgba(239, 68, 68, 0.8)';
                    },
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000000).toFixed(0) + 'jt';
                            }
                        }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    }
    @endif
});
</script>
@endpush
@endsection
