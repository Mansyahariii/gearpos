<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index(Request $request)
    {
        $query = Barang::with('kategori');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('lokasi_rak', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        $barangs = $query->orderBy('nama_barang')->paginate(15);
        $kategoris = Kategori::all();

        return view('barang.index', compact('barangs', 'kategoris'));
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('barang.create', compact('kategoris'));
    }

    /**
     * Store a newly created product
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:100',
            'kategori_id' => 'required|exists:kategoris,kategori_id',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'lokasi_rak' => 'nullable|string|max:50',
        ]);

        Barang::create($request->all());

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    /**
     * Display the specified product
     */
    public function show(Barang $barang)
    {
        $barang->load('kategori');
        return view('barang.show', compact('barang'));
    }

    /**
     * Show the form for editing a product
     */
    public function edit(Barang $barang)
    {
        $kategoris = Kategori::all();
        return view('barang.edit', compact('barang', 'kategoris'));
    }

    /**
     * Update the specified product
     */
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:100',
            'kategori_id' => 'required|exists:kategoris,kategori_id',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'lokasi_rak' => 'nullable|string|max:50',
        ]);

        $barang->update($request->all());

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Remove the specified product
     */
    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}
