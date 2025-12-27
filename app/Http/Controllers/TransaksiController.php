<?php

namespace App\Http\Controllers;

use App\Models\TransaksiHeader;
use App\Models\TransaksiDetail;
use App\Models\Barang;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Display POS interface
     */
    public function index()
    {
        $barangs = Barang::with('kategori')
            ->where('stok', '>', 0)
            ->orderBy('nama_barang')
            ->get();
        
        return view('transaksi.index', compact('barangs'));
    }

    /**
     * Display transaction history
     */
    public function riwayat(Request $request)
    {
        $query = TransaksiHeader::with('kasir', 'details.barang');

        // Filter by date
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // If kasir, only show their own transactions
        if (auth()->user()->isKasir()) {
            $query->where('kasir_id', auth()->id());
        }

        $transaksis = $query->orderBy('tanggal', 'desc')->paginate(15);

        return view('transaksi.riwayat', compact('transaksis'));
    }

    /**
     * Store a new transaction
     */
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barangs,barang_id',
            'items.*.jumlah' => 'required|integer|min:1',
            'metode_pembayaran' => 'required|in:tunai,transfer,qris,lainnya',
        ]);

        DB::beginTransaction();

        try {
            // Create transaction header
            $transaksi = TransaksiHeader::create([
                'tanggal' => now(),
                'total_harga' => 0,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status' => 'selesai',
                'kasir_id' => auth()->id(),
            ]);

            $totalHarga = 0;

            // Create transaction details
            foreach ($request->items as $item) {
                $barang = Barang::find($item['barang_id']);
                
                // Check stock
                if (!$barang->isStokCukup($item['jumlah'])) {
                    throw new \Exception("Stok {$barang->nama_barang} tidak mencukupi.");
                }

                $subtotal = $barang->harga_jual * $item['jumlah'];
                
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->transaksi_id,
                    'barang_id' => $item['barang_id'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $barang->harga_jual,
                    'subtotal' => $subtotal,
                ]);

                // Reduce stock
                $barang->kurangiStok($item['jumlah']);

                $totalHarga += $subtotal;
            }

            // Update total
            $transaksi->update(['total_harga' => $totalHarga]);

            // Record to keuangan
            Keuangan::create([
                'user_id' => auth()->id(),
                'tanggal' => now(),
                'jenis' => 'pemasukan',
                'keterangan' => 'Penjualan #' . $transaksi->transaksi_id,
                'nominal' => $totalHarga,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil.',
                'transaksi_id' => $transaksi->transaksi_id,
                'total' => $totalHarga,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Show transaction detail / invoice
     */
    public function show(TransaksiHeader $transaksi)
    {
        $transaksi->load('kasir', 'details.barang');
        return view('transaksi.invoice', compact('transaksi'));
    }

    /**
     * Cancel a transaction
     */
    public function batal(TransaksiHeader $transaksi)
    {
        if ($transaksi->status !== 'pending') {
            return back()->with('error', 'Hanya transaksi pending yang dapat dibatalkan.');
        }

        DB::beginTransaction();

        try {
            // Restore stock
            foreach ($transaksi->details as $detail) {
                $detail->barang->tambahStok($detail->jumlah);
            }

            $transaksi->batalkan();

            DB::commit();

            return back()->with('success', 'Transaksi berhasil dibatalkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membatalkan transaksi.');
        }
    }
}
