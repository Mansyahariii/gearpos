<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of categories
     */
    public function index()
    {
        $kategoris = Kategori::withCount('barangs')->get();
        return view('kategori.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:50|unique:kategoris,nama_kategori',
        ]);

        Kategori::create($request->only('nama_kategori'));

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Show the form for editing a category
     */
    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:50|unique:kategoris,nama_kategori,' . $kategori->kategori_id . ',kategori_id',
        ]);

        $kategori->update($request->only('nama_kategori'));

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified category
     */
    public function destroy(Kategori $kategori)
    {
        if ($kategori->barangs()->count() > 0) {
            return redirect()->route('kategori.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki barang.');
        }

        $kategori->delete();

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
