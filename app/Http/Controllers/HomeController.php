<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Alamat;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    // Menampilkan halaman utama (home)
    public function index(Request $request)
    {
        $user_id = auth()->id();
    
        // Keranjang Items
        $keranjangItems = [];
        if ($user_id) {
            $keranjangItems = Keranjang::where('id_user', $user_id)
                ->with('produk')
                ->get();
        }
    
        // Tangkap parameter pencarian
        $query = $request->query('query'); // Nama produk
        $latitude = $request->query('latitude'); // Latitude pengguna
        $longitude = $request->query('longitude'); // Longitude pengguna
        $radius = $request->query('radius', 10); // Radius pencarian dalam kilometer (default 10 km)
    
        // Query produk
        $produkAll = Produk::with('user.alamat');
    
        if ($query) {
            $produkAll = $produkAll->whereRaw('LOWER(nama_produk) LIKE ?', ['%' . strtolower($query) . '%']);
        }
    
        if ($latitude && $longitude) {
            $produkAll = $produkAll->whereHas('user.alamat', function ($query) use ($latitude, $longitude, $radius) {
                $query->whereRaw("
                    6371 * acos(
                        cos(radians(?)) * cos(radians(latitude)) *
                        cos(radians(longitude) - radians(?)) +
                        sin(radians(?)) * sin(radians(latitude))
                    ) <= ?
                ", [$latitude, $longitude, $latitude, $radius]);
            });
        }
    
        $produkAll = $produkAll->get();
    

    
        // Tangani permintaan AJAX
        if ($request->ajax()) {
            return response()->json([
                'produkAll' => $produkAll,
            ]);
        }
    
        // Data lain
        $orders = Pesanan::with('penjual', 'detailPesanan.produk')
            ->where('id_pembeli', $user_id)
            ->orderByRaw("CASE WHEN status = 'selesai' THEN 1 ELSE 0 END")
            ->latest()
            ->get();
    
        $penjualLokasi = User::with('alamat')
            ->whereHas('produk')
            ->get()
            ->map(function ($user) {
                return [
                    'nama_penjual' => $user->username,
                    'latitude' => $user->alamat->latitude ?? null,
                    'longitude' => $user->alamat->longitude ?? null,
                ];
            });
    
        return view('home', compact('produkAll', 'keranjangItems', 'orders', 'penjualLokasi'));
    }
    
    



    // Menambahkan produk ke keranjang dan menyimpan di database
    public function tambahKeranjangDB(Request $request, $produk_id)
    {
        $user_id = auth()->id();

        if (!$user_id) {
            // Memberikan pesan error jika user belum login
            session()->flash('error', 'Anda harus login untuk menambahkan produk ke keranjang!');
            return redirect()->route('home'); // Tetap di halaman home
        }

        $produk = Produk::find($produk_id);

        if (!$produk) {
            // Memberikan pesan error jika produk tidak ditemukan
            session()->flash('error', 'Produk tidak ditemukan!');
            return redirect()->route('home');
        }

        // Mengecek apakah stok produk cukup
        if ($produk->stok < 1) {
            session()->flash('error', 'Stok produk tidak cukup!');
            return redirect()->route('home');
        }

        // Menambah produk ke keranjang jika belum ada, atau memperbarui jumlah jika sudah ada
        $keranjang = Keranjang::where('id_user', $user_id)
            ->where('id_produk', $produk_id)
            ->first();

        if ($keranjang) {
            $keranjang->jumlah += 1;  // Menambah jumlah produk yang sama di keranjang
            $keranjang->save();
        } else {
            Keranjang::create([
                'id_user' => $user_id,
                'id_produk' => $produk_id,
                'jumlah' => 1
            ]);
        }

        // Memberikan pesan sukses
        session()->flash('message', 'Produk berhasil ditambahkan ke keranjang!');
        return redirect()->route('home');
    }
    public function updateJumlah(Request $request)
    {
        \Log::info('Data request update jumlah:', $request->all());

        // Validasi data yang diterima
        $validated = $request->validate([
            'id_keranjang' => 'required|exists:keranjang,id_keranjang',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Cari keranjang berdasarkan ID
        $keranjang = Keranjang::find($validated['id_keranjang']);

        if ($keranjang) {
            // Update jumlah di database
            $keranjang->jumlah = $validated['jumlah'];
            $keranjang->save();

            return response()->json([
                'success' => true,
                'message' => 'Jumlah berhasil diperbarui!',
                'data' => $keranjang,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Keranjang tidak ditemukan.',
        ], 404);
    }
    // Fungsi untuk checkout
    public function checkout(Request $request)
    {
        $keranjangItems = $request->input('keranjang_items');
        $keranjangItems = json_decode($keranjangItems, true);
        \Log::info('Data dari frontend:', ['keranjangItemsInput' => $request->input('keranjangItemsInput')]);


        if (empty($keranjangItems)) {
            Log::warning("Proses checkout gagal: Keranjang kosong untuk pengguna dengan ID " . auth()->id());
            return back()->with('error', 'Keranjang kosong, tidak dapat melakukan checkout.');
        }

        DB::beginTransaction();

        try {
            $idUser = auth()->id(); // Mendapatkan ID pengguna yang login
            Log::info("Memulai proses checkout untuk pengguna dengan ID: $idUser.");

            // Log isi keranjang untuk debugging
            Log::info("Isi keranjang untuk checkout: ", $keranjangItems);

            $groupedItems = collect($keranjangItems)->groupBy('id_penjual');

            foreach ($groupedItems as $idPenjual => $items) {
                $totalHarga = 0;

                Log::info("Memproses pesanan untuk penjual dengan ID: $idPenjual.");

                foreach ($items as $item) {
                    $totalHarga += $item['total_harga'];
                    Log::info("Menambahkan harga item ke total: Item ID {$item['id_produk']}, Total Harga: $totalHarga.");
                }

                Log::info("Total harga untuk penjual $idPenjual adalah: $totalHarga.");

                $pesanan = Pesanan::create([
                    'id_penjual' => $idPenjual,
                    'id_pembeli' => $idUser,
                    'total_harga' => $totalHarga,
                ]);

                Log::info("Pesanan berhasil dibuat dengan ID: {$pesanan->id_pesanan}.");

                foreach ($items as $item) {
                    $idProduk = $item['id_produk'];
                    $jumlah = $item['jumlah'];

                    Log::info("Memproses produk dengan ID: $idProduk, jumlah: $jumlah.");

                    $produk = Produk::find($idProduk);

                    if (!$produk) {
                        Log::error("Produk dengan ID $idProduk tidak ditemukan.");
                        throw new \Exception("Produk dengan ID $idProduk tidak ditemukan.");
                    }

                    if ($produk->stok < $jumlah) {
                        Log::error("Stok produk {$produk->nama_produk} tidak mencukupi. Stok saat ini: {$produk->stok}, Jumlah diminta: $jumlah.");
                        throw new \Exception("Stok produk {$produk->nama_produk} tidak mencukupi.");
                    }

                    $produk->stok -= $jumlah;
                    $produk->save();

                    Log::info("Stok produk {$produk->nama_produk} berhasil dikurangi. Stok tersisa: {$produk->stok}.");

                    DetailPesanan::create([
                        'id_pesanan' => $pesanan->id_pesanan,
                        'id_produk' => $idProduk,
                        'jumlah' => $jumlah,
                    ]);

                    Log::info("Detail pesanan berhasil ditambahkan untuk produk {$produk->nama_produk} dengan jumlah $jumlah.");

                    // Hapus produk dari keranjang
                    Keranjang::where('id_user', $idUser)
                        ->where('id_produk', $idProduk)
                        ->delete();

                    Log::info("Produk dengan ID $idProduk berhasil dihapus dari keranjang pengguna dengan ID $idUser.");
                }
            }

            DB::commit();

            Log::info("Proses checkout berhasil untuk pengguna dengan ID: $idUser.");
            return redirect()->route('home')->with('success', 'Checkout berhasil.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Checkout failed: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat checkout. Silakan coba lagi.');
        }
    }







    public function updateSettings()
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
                session()->setFlashdata('success', 'Data updated successfully');
                return redirect()->to('/home');
            } else {
                // Validation failed
                return redirect()->back()->withInput()->with('validation', $validation);
            }
        }

        // If the request is GET, just display the form
        return view('home/settings');
    }

    public function hapus($id)
    {
        try {
            // Cari item keranjang berdasarkan ID
            $item = Keranjang::findOrFail($id);
            $item->delete(); // Hapus item

            session()->flash('message', 'Produk berhasil Dihapus dari Keranjang!');
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus produk.']);
        }
    }


    public function deleteKeranjang(Request $request)
    {
        try {
            $ids = $request->input('id_keranjang');
            if (empty($ids)) {
                return response()->json(['success' => false, 'message' => 'Tidak ada item yang dipilih untuk dihapus.']);
            }

            // Hapus item berdasarkan ID
            \DB::table('keranjang')->whereIn('id_keranjang', $ids)->delete();

            return response()->json(['success' => true, 'message' => 'Item berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan.']);
        }
    }


    public function uploadPayment(Request $request, $id)
    {
        // Validasi file bukti pembayaran
        $request->validate([
            'paymentProof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Cari pesanan berdasarkan ID
        $pesanan = Pesanan::findOrFail($id);

        // Simpan file bukti pembayaran
        $file = $request->file('paymentProof');
        $path = $file->store('bukti_pembayaran', 'public');

        // Perbarui data pesanan dengan lokasi file bukti pembayaran
        $pesanan->bukti_pembayaran = $path;

        // Perbarui status pesanan menjadi 'diproses'
        $pesanan->status = 'diproses';

        // Simpan perubahan status dan bukti pembayaran
        $pesanan->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah dan status pesanan telah diperbarui!');
    }

    public function selesaikanPesanan($id)
    {
        try {
            // Cari pesanan berdasarkan ID
            $pesanan = Pesanan::find($id);

            if (!$pesanan) {
                return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan.'], 404);
            }

            // Ubah status pesanan menjadi 'selesai'
            if ($pesanan->status === 'dikirim') {
                $pesanan->status = 'selesai';
                $pesanan->save();

                return response()->json(['success' => true, 'message' => 'Pesanan berhasil diselesaikan.']);
            }

            return response()->json(['success' => false, 'message' => 'Pesanan tidak dapat diselesaikan.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan.'], 500);
        }
    }

    public function storeAlamat(Request $request)
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

            // Redirect setelah berhasil menyimpan lokasi
            return redirect('/')->with('success', 'Lokasi berhasil disimpan');
        } else {
            return redirect('/')->with('error', 'Alamat tidak ditemukan');
        }
    }


    public function cari(Request $request)
        {
            $query = $request->query('query'); // Ambil query dari request
            $produkAll = Produk::with('user')
                ->whereRaw('LOWER(nama_produk) LIKE ?', ['%' . strtolower($query) . '%']) // Filter berdasarkan nama produk
                ->get();
            \Log::info("fungsi pencarian biasa aktif");
        
            return response()->json([
                'produkAll' => $produkAll,
            ]);
        }
        public function searchByLocation(Request $request)
        {
            // Ambil parameter dari request
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');
            $radius = $request->input('radius', 1); // Default radius 1 km
            // Log hasil pencarian
            \Log::info('Latitude: ' . $latitude . ', Longitude: ' . $longitude . ', Radius: ' . $radius);

    
            if (!$latitude || !$longitude) {
                return response()->json(['error' => 'Koordinat lokasi tidak valid'], 400);
            }
    
            // Mengambil data alamat penjual dan menghitung jarak berdasarkan lokasi yang dipilih
            $penjualLokasi = User::join('alamats', 'alamats.id_alamat', '=', 'users.id_alamat')
                ->select('users.id_user', 'alamats.latitude', 'alamats.longitude', 'users.username')
                ->get()
                ->map(function ($penjual) use ($latitude, $longitude, $radius) {
                    // Hitung jarak menggunakan Haversine Formula
                    $distance = $this->haversine($latitude, $longitude, $penjual->latitude, $penjual->longitude);
    
                    // Menyaring penjual yang berada dalam radius yang ditentukan
                    if ($distance <= $radius) {
                        $penjual->distance = $distance;
                        return $penjual;
                    }
                })
                ->filter()
                ->values();
    
            // Ambil produk-produk dari penjual yang berada dalam radius
            $produkAll = Produk::whereIn('id_user', $penjualLokasi->pluck('id_user'))
                ->with('user')
                ->get();
                \Log::info('produk dari penjual di radius'.$produkAll);
    
            return response()->json([
                'produkAll' => $produkAll,
                'penjualLokasi' => $penjualLokasi
            ]);
        }
    
        // Fungsi untuk menghitung jarak menggunakan Haversine formula (dalam kilometer)
        private function haversine($lat1, $lon1, $lat2, $lon2)
        {
            $earthRadius = 6371; // Radius bumi dalam kilometer
    
            // Konversi derajat ke radian
            $lat1 = deg2rad($lat1);
            $lon1 = deg2rad($lon1);
            $lat2 = deg2rad($lat2);
            $lon2 = deg2rad($lon2);
    
            // Hitung selisih koordinat
            $dLat = $lat2 - $lat1;
            $dLon = $lon2 - $lon1;
    
            // Haversine formula
            $a = sin($dLat / 2) * sin($dLat / 2) + cos($lat1) * cos($lat2) * sin($dLon / 2) * sin($dLon / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    
            // Hitung jarak
            return $earthRadius * $c;
        }

    

}
