<?php

namespace App\Http\Controllers;

use App\Models\TransaksiHeader;
use App\Models\Barang;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Laporan penjualan
     */
    public function penjualan(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $transaksis = TransaksiHeader::with('kasir', 'details.barang')
            ->whereDate('tanggal', '>=', $startDate)
            ->whereDate('tanggal', '<=', $endDate)
            ->where('status', 'selesai')
            ->orderBy('tanggal', 'desc')
            ->get();

        $summary = [
            'total_transaksi' => $transaksis->count(),
            'total_penjualan' => $transaksis->sum('total_harga'),
            'rata_rata' => $transaksis->count() > 0 ? $transaksis->sum('total_harga') / $transaksis->count() : 0,
        ];

        // Group by date
        $perHari = $transaksis->groupBy(function($item) {
            return $item->tanggal->format('Y-m-d');
        })->map(function($items) {
            return [
                'jumlah' => $items->count(),
                'total' => $items->sum('total_harga'),
            ];
        });

        return view('laporan.penjualan', compact('transaksis', 'summary', 'perHari', 'startDate', 'endDate'));
    }

    /**
     * Laporan stok
     */
    public function stok(Request $request)
    {
        $query = Barang::with('kategori');

        // Filter by category
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Filter stok rendah
        if ($request->get('stok_rendah')) {
            $query->where('stok', '<', 10);
        }

        // Filter stok kosong
        if ($request->get('stok_kosong')) {
            $query->where('stok', 0);
        }

        $barangs = $query->orderBy('nama_barang')->get();

        $summary = [
            'total_jenis' => $barangs->count(),
            'total_unit' => $barangs->sum('stok'),
            'nilai_stok' => $barangs->sum(function($b) { return $b->stok * $b->harga_beli; }),
            'stok_rendah' => Barang::where('stok', '<', 10)->count(),
            'stok_kosong' => Barang::where('stok', 0)->count(),
        ];

        return view('laporan.stok', compact('barangs', 'summary'));
    }

    /**
     * Laporan keuangan
     */
    public function keuangan(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $keuangans = Keuangan::with('user')
            ->whereDate('tanggal', '>=', $startDate)
            ->whereDate('tanggal', '<=', $endDate)
            ->orderBy('tanggal', 'desc')
            ->get();

        $summary = [
            'total_pemasukan' => $keuangans->where('jenis', 'pemasukan')->sum('nominal'),
            'total_pengeluaran' => $keuangans->where('jenis', 'pengeluaran')->sum('nominal'),
        ];
        $summary['saldo'] = $summary['total_pemasukan'] - $summary['total_pengeluaran'];

        return view('laporan.keuangan', compact('keuangans', 'summary', 'startDate', 'endDate'));
    }
}
