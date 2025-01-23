<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
use App\Models\Alamat;
use App\Models\DetailPesanan;

class ProdukController extends Controller
{

    public function index()
    {
        // Mengambil semua data produk yang dimiliki oleh user yang sedang login
        $produk = Produk::where('id_user', Auth::id())->get();

        // Mengambil pesanan yang terkait dengan id_penjual sama dengan user yang sedang login
        $pesanan = Pesanan::with(['detailPesanan.produk', 'pembeli.alamat']) // Eager load alamat di pembeli
            ->where('id_penjual', Auth::id()) // Filter berdasarkan id_penjual
            ->where('status', '!=', 'menunggu pembayaran') // Tambahkan kondisi untuk status
            ->orderByRaw("CASE WHEN status = 'selesai' THEN 1 ELSE 0 END") // Urutkan status selesai paling akhir
            ->latest() // Urutkan berdasarkan pesanan terbaru (kecuali yang selesai)
            ->get();



        // Mengirimkan data produk dan pesanan ke view
        return view('petani', compact('produk', 'pesanan'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga_produk' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Foto wajib
        ]);

        // Tangani foto jika ada
        if ($request->hasFile('foto')) {
            $fileName = time() . '_' . $request->file('foto')->getClientOriginalName();
            $path = $request->file('foto')->storeAs('produk_images', $fileName, 'public');
            $validated['foto'] = $path;  // Simpan path foto
        }

        // Tambahkan id_user secara dinamis
        $validated['id_user'] = Auth::id(); // Ambil id_user yang sedang login

        // Simpan data ke dalam database
        Produk::create($validated);

        // Redirect kembali ke laman /petani dengan flash message
        return redirect('/petani')->with('success', 'Produk berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $produk = Produk::find($id);

        if ($produk) {
            return response()->json([
                'success' => true,
                'data' => $produk
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Produk tidak ditemukan.'
        ], 404);
    }


    public function update(Request $request, $id)
    {
        // Validasi data
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga_produk' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file foto
        ]);

        // Cari produk berdasarkan ID
        $produk = Produk::findOrFail($id);

        // Tangani foto jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($produk->foto && \Storage::exists('public/' . $produk->foto)) {
                \Storage::delete('public/' . $produk->foto);
            }

            // Simpan foto baru
            $fileName = time() . '_' . $request->file('foto')->getClientOriginalName();
            $path = $request->file('foto')->storeAs('produk_images', $fileName, 'public');
            $validated['foto'] = $path;
        }

        // Update data produk
        $produk->update($validated);

        // Redirect kembali dengan pesan sukses
        return redirect('/petani')->with('success', 'Produk berhasil diperbarui!');
    }
    public function destroy($id)
    {
        // Cari produk berdasarkan ID
        $produk = Produk::findOrFail($id);

        // Hapus foto produk jika ada
        if ($produk->foto && Storage::exists('public/' . $produk->foto)) {
            Storage::delete('public/' . $produk->foto);
        }

        // Hapus produk dari database
        $produk->delete();

        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect('/petani')->with('success', 'Produk berhasil DiHapus!');
    }

    // Menampilkan detail produk
    public function show($id)
    {
        // Mengambil data produk berdasarkan ID
        $produk = Produk::findOrFail($id);

        // Mengirimkan data produk ke view
        return view('show', compact('produk'));
    }

    public function updateResi(Request $request, $idPesanan)
    {
        $request->validate([
            'resi' => 'required|string|max:255',
        ]);

        $pesanan = Pesanan::find($idPesanan);
        if ($pesanan) {
            $pesanan->resi = $request->resi;
            $pesanan->status = 'dikirim';
            $pesanan->save();

            return redirect()->back()->with('message', 'Resi berhasil Di Update');
        }

        return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
    }

    public function updateSettingspatani()
    {
        // Get the current user session
        $userId = session('id'); // Assuming user ID is stored in session

        // If the form is submitted
        if ($this->request->getMethod() == 'post') {
            $validation = \Config\Services::validation();

            // Validate the inputs
            $validation->setRules([
                'username' => 'required|min_length[3]|max_length[50]',
                'password' => 'required|min_length[8]',
                'no_telepon' => 'required|min_length[10]|max_length[15]',
                'alamat_lengkap' => 'required',
                'kordinat' => 'required',
                'kecamatan' => 'required',
                'kota' => 'required'
            ]);

            if ($validation->run($this->request->getPost())) {
                // Get user data and update it
                $userModel = new UserModel();
                $data = [
                    'username' => $this->request->getPost('username'),
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                    'no_telepon' => $this->request->getPost('no_telepon'),
                    'alamat_lengkap' => $this->request->getPost('alamat_lengkap'),
                    'kordinat' => $this->request->getPost('kordinat'),
                    'kecamatan' => $this->request->getPost('kecamatan'),
                    'kota' => $this->request->getPost('kota')
                ];

                // Update user in the database
                $userModel->update($userId, $data);

                // Redirect with success message
                session()->setFlashdata('success', 'Data Berhasil di Update');
                return redirect()->to('/petani');
            } else {
                // Validation failed
                return redirect()->back()->withInput()->with('validation', $validation);
            }
        }

        // If the request is GET, just display the form
        return view('home/settings');
    }
    public function storeAlamatPatani(Request $request)
    {
        $user = auth()->user(); // Mengambil user yang sedang login

        // Validasi input latitude dan longitude
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Perbarui alamat user yang sedang login
        $alamat = Alamat::find($user->id_alamat);

        if ($alamat) {
            $alamat->latitude = $request->latitude;
            $alamat->longitude = $request->longitude;
            $alamat->save();

            // Redirect ke halaman /petani setelah berhasil menyimpan lokasi
            return redirect('/petani')->with('success', 'Lokasi berhasil disimpan');
        } else {
            return redirect('/petani')->with('error', 'Alamat tidak ditemukan');
        }
    }

    public function cariProduk(Request $request)
    {
        $query = $request->input('query');
        $produk = Produk::where('nama_produk', 'LIKE', "%{$query}%")
            ->orWhere('deskripsi', 'LIKE', "%{$query}%")
            ->get();

        return view('home', compact('produk'));
    }




}



