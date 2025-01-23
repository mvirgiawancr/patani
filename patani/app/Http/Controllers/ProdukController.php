<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukController extends Controller
{

    public function index()
    {
        // Mengambil semua data produk dari database
        $produk = Produk::all();

        // Mengirimkan data produk ke view
        return view('petani', compact('produk'));
    }
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga_produk' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Tambahkan validasi foto
        ]);

        // Tangani foto jika ada
        if ($request->hasFile('foto')) {
            $fileName = time() . '_' . $request->file('foto')->getClientOriginalName();
            $path = $request->file('foto')->storeAs('produk_images', $fileName, 'public');
            $validated['foto'] = $path;  // Simpan path foto
        }

        // Tambahkan id_user secara statis
        $validated['id_user'] = 6; // Id user statis

        // Simpan data ke dalam database
        Produk::create($validated);

        // Redirect kembali ke laman /petani dengan flash message
        return redirect('/petani')->with('success', 'Produk berhasil ditambahkan!');
    }
}
