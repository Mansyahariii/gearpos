<?php

namespace App\Http\Controllers;

use App\Models\PembelianHeader;
use App\Models\PembelianDetail;
use App\Models\Barang;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    /**
     * Display pembelian list
     */
    public function index(Request $request)
    {
        $query = PembelianHeader::with('user', 'details.barang');

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $pembelians = $query->orderBy('tanggal', 'desc')->paginate(15);

        return view('pembelian.index', compact('pembelians'));
    }

    /**
     * Show form to create new pembelian (stock in)
     */
    public function create()
    {
        $barangs = Barang::with('kategori')->orderBy('nama_barang')->get();
        return view('pembelian.create', compact('barangs'));
    }

    /**
     * Store a new pembelian
     */
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barangs,barang_id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga_beli' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Create pembelian header
            $pembelian = PembelianHeader::create([
                'tanggal' => now(),
                'total' => 0,
                'user_id' => auth()->id(),
                'status' => 'selesai',
            ]);

            $total = 0;

            // Create pembelian details
            foreach ($request->items as $item) {
                $subtotal = $item['harga_beli'] * $item['jumlah'];
                
                PembelianDetail::create([
                    'pembelian_id' => $pembelian->pembelian_id,
                    'barang_id' => $item['barang_id'],
                    'jumlah' => $item['jumlah'],
                    'harga_beli' => $item['harga_beli'],
                    'subtotal' => $subtotal,
                ]);

                // Add stock
                $barang = Barang::find($item['barang_id']);
                $barang->tambahStok($item['jumlah']);

                // Update harga beli if different
                if ($barang->harga_beli != $item['harga_beli']) {
                    $barang->update(['harga_beli' => $item['harga_beli']]);
                }

                $total += $subtotal;
            }

            // Update total
            $pembelian->update(['total' => $total]);

            // Record to keuangan
            Keuangan::create([
                'user_id' => auth()->id(),
                'tanggal' => now(),
                'jenis' => 'pengeluaran',
                'keterangan' => 'Pembelian Stok #' . $pembelian->pembelian_id,
                'nominal' => $total,
            ]);

            DB::commit();

            return redirect()->route('pembelian.index')
                ->with('success', 'Pembelian berhasil disimpan. Total: Rp ' . number_format($total, 0, ',', '.'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan pembelian: ' . $e->getMessage());
        }
    }

    /**
     * Show pembelian detail
     */
    public function show(PembelianHeader $pembelian)
    {
        $pembelian->load('user', 'details.barang');
        return view('pembelian.show', compact('pembelian'));
    }
}
