<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GearPOS') - Sistem Point of Sales</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #0d6efd;
            --primary-dark: #0b5ed7;
            --accent-color: #fd7e14;
            --sidebar-width: 260px;
            --sidebar-bg: #1e293b;
            --sidebar-text: #94a3b8;
            --sidebar-active: #3b82f6;
        }
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background-color: #f1f5f9;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            padding: 1rem;
            overflow-y: auto;
            z-index: 1000;
        }
        
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            color: white;
            font-weight: 700;
            font-size: 1.25rem;
        }
        
        .sidebar-brand i {
            font-size: 1.75rem;
            color: var(--accent-color);
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-menu li {
            margin-bottom: 0.25rem;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--sidebar-text);
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }
        
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(59, 130, 246, 0.1);
            color: white;
        }
        
        .sidebar-menu a.active {
            background: var(--sidebar-active);
        }
        
        .sidebar-section {
            color: var(--sidebar-text);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            padding: 1rem 1rem 0.5rem;
            margin-top: 0.5rem;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }
        
        /* Top Navbar */
        .top-navbar {
            background: white;
            padding: 1rem 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-title {
            font-weight: 600;
            font-size: 1.25rem;
            color: #1e293b;
            margin: 0;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        
        /* Content Area */
        .content-area {
            padding: 1.5rem;
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            padding: 1rem 1.25rem;
        }
        
        /* Stats Card */
        .stats-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .stats-card .stats-icon {
            width: 48px;
            height: 48px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .stats-card .stats-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e293b;
        }
        
        .stats-card .stats-label {
            color: #64748b;
            font-size: 0.875rem;
        }
        
        /* Buttons */
        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        
        .btn-accent {
            background: var(--accent-color);
            border-color: var(--accent-color);
            color: white;
        }
        
        /* Tables */
        .table th {
            font-weight: 600;
            color: #475569;
            background: #f8fafc;
        }
        
        /* Alerts */
        .alert {
            border: none;
            border-radius: 0.5rem;
        }
        
        /* Badge */
        .badge-role {
            padding: 0.35rem 0.65rem;
            font-weight: 500;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-gear-fill"></i>
            <span>GearPOS</span>
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            @if(auth()->user()->isKasir())
            <div class="sidebar-section">Point of Sales</div>
            <li>
                <a href="{{ route('transaksi.index') }}" class="{{ request()->routeIs('transaksi.index') ? 'active' : '' }}">
                    <i class="bi bi-cart3"></i>
                    <span>Transaksi Baru</span>
                </a>
            </li>
            <li>
                <a href="{{ route('transaksi.riwayat') }}" class="{{ request()->routeIs('transaksi.riwayat') ? 'active' : '' }}">
                    <i class="bi bi-receipt"></i>
                    <span>Riwayat Transaksi</span>
                </a>
            </li>
            @endif
            
            @if(auth()->user()->isStafGudang())
            <div class="sidebar-section">Inventaris</div>
            <li>
                <a href="{{ route('barang.index') }}" class="{{ request()->routeIs('barang.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i>
                    <span>Data Barang</span>
                </a>
            </li>
            <li>
                <a href="{{ route('kategori.index') }}" class="{{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i>
                    <span>Kategori</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pembelian.index') }}" class="{{ request()->routeIs('pembelian.*') ? 'active' : '' }}">
                    <i class="bi bi-truck"></i>
                    <span>Stok Masuk</span>
                </a>
            </li>
            @endif
            
            @if(auth()->user()->isManajer())
            <div class="sidebar-section">Manajemen</div>
            <li>
                <a href="{{ route('barang.index') }}" class="{{ request()->routeIs('barang.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i>
                    <span>Data Barang</span>
                </a>
            </li>
            <li>
                <a href="{{ route('kategori.index') }}" class="{{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i>
                    <span>Kategori</span>
                </a>
            </li>
            <div class="sidebar-section">Laporan</div>
            <li>
                <a href="{{ route('laporan.penjualan') }}" class="{{ request()->routeIs('laporan.penjualan') ? 'active' : '' }}">
                    <i class="bi bi-graph-up"></i>
                    <span>Laporan Penjualan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('laporan.stok') }}" class="{{ request()->routeIs('laporan.stok') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-data"></i>
                    <span>Laporan Stok</span>
                </a>
            </li>
            @endif
            
            @if(auth()->user()->isPemilik())
            <div class="sidebar-section">Laporan</div>
            <li>
                <a href="{{ route('laporan.penjualan') }}" class="{{ request()->routeIs('laporan.penjualan') ? 'active' : '' }}">
                    <i class="bi bi-graph-up"></i>
                    <span>Laporan Penjualan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('laporan.stok') }}" class="{{ request()->routeIs('laporan.stok') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-data"></i>
                    <span>Laporan Stok</span>
                </a>
            </li>
            <li>
                <a href="{{ route('laporan.keuangan') }}" class="{{ request()->routeIs('laporan.keuangan') ? 'active' : '' }}">
                    <i class="bi bi-cash-stack"></i>
                    <span>Laporan Keuangan</span>
                </a>
            </li>
            @endif
        </ul>
    </aside>
    
    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
            
            <div class="user-info">
                <div class="text-end">
                    <div class="fw-semibold">{{ auth()->user()->nama }}</div>
                    <small class="text-muted text-capitalize">{{ str_replace('_', ' ', auth()->user()->role) }}</small>
                </div>
                <div class="dropdown">
                    <button class="user-avatar dropdown-toggle" data-bs-toggle="dropdown">
                        {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- Content Area -->
        <div class="content-area">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            
            @yield('content')
        </div>
    </main>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
