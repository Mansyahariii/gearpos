<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiHeader;
use App\Models\TransaksiDetail;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Keuangan;
use App\Models\Pembelian;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show dashboard based on user role
     */
    public function index()
    {
        $user = auth()->user();
        $data = [];

        // Common data for all roles
        $data['user'] = $user;

        switch ($user->role) {
            case 'kasir':
                $data = array_merge($data, $this->getKasirData());
                break;
            case 'staf_gudang':
                $data = array_merge($data, $this->getGudangData());
                break;
            case 'manajer':
                $data = array_merge($data, $this->getManajerData());
                break;
            case 'pemilik':
                $data = array_merge($data, $this->getPemilikData());
                break;
        }

        return view('dashboard.index', $data);
    }

    /**
     * Dashboard data for Kasir
     */
    private function getKasirData(): array
    {
        $today = now()->startOfDay();
        
        // Recent transactions
        $transaksi_terakhir = TransaksiHeader::where('kasir_id', auth()->id())
            ->whereDate('tanggal', $today)
            ->where('status', 'selesai')
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();
        
        // Popular products today
        $produk_populer = DB::table('transaksi_details')
            ->join('transaksi_headers', 'transaksi_details.transaksi_id', '=', 'transaksi_headers.transaksi_id')
            ->join('barangs', 'transaksi_details.barang_id', '=', 'barangs.barang_id')
            ->whereDate('transaksi_headers.tanggal', $today)
            ->where('transaksi_headers.status', 'selesai')
            ->select('barangs.nama_barang', DB::raw('SUM(transaksi_details.jumlah) as total_qty'))
            ->groupBy('barangs.barang_id', 'barangs.nama_barang')
            ->orderBy('total_qty', 'desc')
            ->limit(6)
            ->get();
        
        return [
            'transaksi_hari_ini' => TransaksiHeader::where('kasir_id', auth()->id())
                ->whereDate('tanggal', $today)
                ->where('status', 'selesai')
                ->count(),
            'total_penjualan_hari_ini' => TransaksiHeader::where('kasir_id', auth()->id())
                ->whereDate('tanggal', $today)
                ->where('status', 'selesai')
                ->sum('total_harga'),
            'transaksi_pending' => TransaksiHeader::where('kasir_id', auth()->id())
                ->where('status', 'pending')
                ->count(),
            'transaksi_terakhir' => $transaksi_terakhir,
            'produk_populer' => $produk_populer,
        ];
    }

    /**
     * Dashboard data for Staf Gudang
     */
    private function getGudangData(): array
    {
        // Stock by category
        $kategori_data = Kategori::withCount('barangs')
            ->withSum('barangs', 'stok')
            ->get();
        
        $kategori_labels = $kategori_data->pluck('nama_kategori')->toArray();
        $kategori_stok = $kategori_data->pluck('barangs_sum_stok')->map(fn($v) => $v ?? 0)->toArray();
        
        // Recent stock movements (from PembelianHeader with details)
        $pergerakan_stok = collect();
        try {
            if (class_exists('App\Models\PembelianHeader')) {
                $pergerakan_stok = \App\Models\PembelianHeader::with(['details.barang'])
                    ->orderBy('pembelian_id', 'desc')
                    ->limit(5)
                    ->get();
            }
        } catch (\Exception $e) {
            // Ignore if table doesn't exist
        }
        
        return [
            'total_barang' => Barang::count(),
            'stok_rendah' => Barang::where('stok', '<', 10)->count(),
            'stok_kosong' => Barang::where('stok', 0)->count(),
            'barang_stok_rendah' => Barang::where('stok', '<', 10)
                ->with('kategori')
                ->orderBy('stok', 'asc')
                ->limit(10)
                ->get(),
            'kategori_labels' => $kategori_labels,
            'kategori_stok' => $kategori_stok,
            'pergerakan_stok' => $pergerakan_stok,
        ];
    }

    /**
     * Dashboard data for Manajer
     */
    private function getManajerData(): array
    {
        $today = now()->startOfDay();
        $thisMonth = now()->startOfMonth();

        // Weekly sales data
        $sales_data = [];
        $sales_labels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $sales_labels[] = $date->locale('id')->isoFormat('ddd');
            $sales_data[] = (float) TransaksiHeader::whereDate('tanggal', $date->toDateString())
                ->where('status', 'selesai')
                ->sum('total_harga');
        }
        
        // Category sales distribution
        $category_sales = DB::table('transaksi_details')
            ->join('transaksi_headers', 'transaksi_details.transaksi_id', '=', 'transaksi_headers.transaksi_id')
            ->join('barangs', 'transaksi_details.barang_id', '=', 'barangs.barang_id')
            ->join('kategoris', 'barangs.kategori_id', '=', 'kategoris.kategori_id')
            ->whereDate('transaksi_headers.tanggal', '>=', $thisMonth)
            ->where('transaksi_headers.status', 'selesai')
            ->select('kategoris.nama_kategori', DB::raw('SUM(transaksi_details.subtotal) as total'))
            ->groupBy('kategoris.kategori_id', 'kategoris.nama_kategori')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        
        $category_labels = $category_sales->pluck('nama_kategori')->toArray();
        $category_data = $category_sales->pluck('total')->map(fn($v) => (float) $v)->toArray();
        
        // If no data, provide defaults
        if (empty($category_labels)) {
            $category_labels = ['Belum ada data'];
            $category_data = [0];
        }
        
        // Top selling products
        $top_products = DB::table('transaksi_details')
            ->join('transaksi_headers', 'transaksi_details.transaksi_id', '=', 'transaksi_headers.transaksi_id')
            ->join('barangs', 'transaksi_details.barang_id', '=', 'barangs.barang_id')
            ->leftJoin('kategoris', 'barangs.kategori_id', '=', 'kategoris.kategori_id')
            ->whereDate('transaksi_headers.tanggal', '>=', $thisMonth)
            ->where('transaksi_headers.status', 'selesai')
            ->select(
                'barangs.nama_barang',
                'kategoris.nama_kategori as kategori',
                DB::raw('SUM(transaksi_details.jumlah) as total_qty'),
                DB::raw('SUM(transaksi_details.subtotal) as total_revenue')
            )
            ->groupBy('barangs.barang_id', 'barangs.nama_barang', 'kategoris.nama_kategori')
            ->orderBy('total_qty', 'desc')
            ->limit(5)
            ->get();

        return [
            'transaksi_hari_ini' => TransaksiHeader::whereDate('tanggal', $today)
                ->where('status', 'selesai')
                ->count(),
            'penjualan_hari_ini' => TransaksiHeader::whereDate('tanggal', $today)
                ->where('status', 'selesai')
                ->sum('total_harga'),
            'penjualan_bulan_ini' => TransaksiHeader::whereDate('tanggal', '>=', $thisMonth)
                ->where('status', 'selesai')
                ->sum('total_harga'),
            'total_barang' => Barang::count(),
            'stok_rendah' => Barang::where('stok', '<', 10)->count(),
            'sales_labels' => $sales_labels,
            'sales_data' => $sales_data,
            'category_labels' => $category_labels,
            'category_data' => $category_data,
            'top_products' => $top_products,
        ];
    }

    /**
     * Dashboard data for Pemilik
     */
    private function getPemilikData(): array
    {
        $today = now()->startOfDay();
        $thisMonth = now()->startOfMonth();

        // Weekly finance data
        $finance_labels = [];
        $pemasukan_data = [];
        $pengeluaran_data = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $finance_labels[] = $date->locale('id')->isoFormat('ddd');
            
            $pemasukan_data[] = (float) Keuangan::pemasukan()
                ->whereDate('tanggal', $date->toDateString())
                ->sum('nominal');
            
            $pengeluaran_data[] = (float) Keuangan::pengeluaran()
                ->whereDate('tanggal', $date->toDateString())
                ->sum('nominal');
        }
        
        // Expense distribution by category (using keterangan field)
        $expense_distribution = Keuangan::pengeluaran()
            ->whereDate('tanggal', '>=', $thisMonth)
            ->select('keterangan', DB::raw('SUM(nominal) as total'))
            ->groupBy('keterangan')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        
        $expense_labels = $expense_distribution->pluck('keterangan')->toArray();
        $expense_data = $expense_distribution->pluck('total')->map(fn($v) => (float) $v)->toArray();
        
        // If no data, provide defaults
        if (empty($expense_labels)) {
            $expense_labels = ['Belum ada data'];
            $expense_data = [0];
        }
        
        // Monthly profit trend (last 6 months)
        $profit_labels = [];
        $profit_data = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $profit_labels[] = $month->locale('id')->isoFormat('MMM');
            
            $pemasukan = (float) Keuangan::pemasukan()
                ->whereYear('tanggal', $month->year)
                ->whereMonth('tanggal', $month->month)
                ->sum('nominal');
            
            $pengeluaran = (float) Keuangan::pengeluaran()
                ->whereYear('tanggal', $month->year)
                ->whereMonth('tanggal', $month->month)
                ->sum('nominal');
            
            $profit_data[] = $pemasukan - $pengeluaran;
        }

        return [
            'penjualan_hari_ini' => TransaksiHeader::whereDate('tanggal', $today)
                ->where('status', 'selesai')
                ->sum('total_harga'),
            'penjualan_bulan_ini' => TransaksiHeader::whereDate('tanggal', '>=', $thisMonth)
                ->where('status', 'selesai')
                ->sum('total_harga'),
            'total_pemasukan' => Keuangan::pemasukan()
                ->whereDate('tanggal', '>=', $thisMonth)
                ->sum('nominal'),
            'total_pengeluaran' => Keuangan::pengeluaran()
                ->whereDate('tanggal', '>=', $thisMonth)
                ->sum('nominal'),
            'total_barang' => Barang::count(),
            'finance_labels' => $finance_labels,
            'pemasukan_data' => $pemasukan_data,
            'pengeluaran_data' => $pengeluaran_data,
            'expense_labels' => $expense_labels,
            'expense_data' => $expense_data,
            'profit_labels' => $profit_labels,
            'profit_data' => $profit_data,
        ];
    }
}
