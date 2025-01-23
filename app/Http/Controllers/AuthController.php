<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Alamat;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('login'); // Ganti dengan view login Anda jika diperlukan
    }
    // menampilkan form register
    public function showRegisterForm()
    {
        return view('register'); // Menampilkan view register.blade.php
    }
    // Menangani proses registrasi

    public function register(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'username' => 'required|string|unique:users,username',
        'password' => 'required|string|min:6',
        'no_telepon' => 'required|string',
        'alamat_lengkap' => 'required|string',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'kecamatan' => 'required|string',
        'kota' => 'required|string',
        'role' => 'required|string|in:petani,pelanggan',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Foto optional
    ]);

    try {
        // Tangani foto jika ada
        if ($request->hasFile('profile_picture')) {
            $fileName = time() . '_' . $request->file('profile_picture')->getClientOriginalName();
            $path = $request->file('profile_picture')->storeAs('produk_images', $fileName, 'public');
            $validated['foto'] = $path; // Simpan path foto
        } else {
            $validated['foto'] = 'default.png'; // Default foto jika tidak ada file
        }

        // Menyimpan alamat ke tabel alamats
        $alamat = new Alamat();
        $alamat->latitude = $validated['latitude']; // Menyimpan latitude
        $alamat->longitude = $validated['longitude']; // Menyimpan longitude
        $alamat->alamat_lengkap = $validated['alamat_lengkap'];
        $alamat->kecamatan = $validated['kecamatan'];
        $alamat->kota = $validated['kota'];
        $alamat->save();

        // Menyimpan user baru
        $user = new User();
        $user->username = $validated['username'];
        $user->password = $validated['password']; // Enkripsi password
        $user->no_telepon = $validated['no_telepon'];
        $user->id_alamat = $alamat->id_alamat; // Menyimpan id_alamat yang baru saja disimpan
        $user->role = $validated['role'];
        $user->foto = $validated['foto']; // Foto profil
        $user->save();

        // Redirect ke halaman login setelah registrasi berhasil
        return redirect('/')->with('message', 'Registrasi berhasil, silakan login.');
    } catch (\Exception $e) {
        // Kembali ke halaman registrasi dengan pesan error jika gagal
        return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.'])->withInput();
    }
}


    

public function login(Request $request)
{
    // Validasi input
    $credentials = $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    // Menambahkan log untuk username yang sedang dicoba
    Log::info('Attempting to login with username: ' . $credentials['username']);

    // Cari user berdasarkan username
    $user = User::where('username', $credentials['username'])->first();

    // Memeriksa apakah user ditemukan
    if ($user) {
        Log::info('User found: ' . $user->username);

        // Memeriksa apakah password yang dimasukkan cocok dengan hash password yang ada di database
        if (Hash::check($credentials['password'], $user->password)) {
            Log::info('Password check passed for username: ' . $user->username);

            // Login user
            Auth::login($user);
            session(['user_logged_in' => true]);

            // Simpan seluruh data pengguna ke session
            session([
                'id_user' => $user->id_user,
                'username' => $user->username,
                'role' => $user->role,
                'no_telepon' => $user->no_telepon,
                'foto' => $user->foto, // Menambahkan foto ke session
                'id_alamat' => $user->id_alamat,
            ]);

            // Cek role dan arahkan ke halaman yang sesuai
            if ($user->role === 'petani') {
                Log::info('Redirecting to petani page');
                return redirect('/petani'); // Arahkan ke halaman petani
            }

            Log::info('Redirecting to main page for pelanggan');
            return redirect('/')->with('message', 'Login berhasil');
        } else {
            // Jika password tidak cocok
            Log::error('Password check failed for username: ' . $user->username);
            return redirect()->back()->withErrors(['error' => 'Password salah, silahkan coba lagi.'])->withInput();
        }
    } else {
        // Jika user tidak ditemukan
        Log::error('User not found: ' . $credentials['username']);
        return redirect()->back()->withErrors(['error' => 'user tidak ditemukan, silahkan register.'])->withInput();
    }

    // Jika login gagal, tampilkan pesan error
    return back()->withErrors(['login' => 'Username atau password salah.']);
}





    public function logout(Request $request)
    {
        // Logout pengguna
        Auth::logout();
    
        // Hapus session yang terkait dengan login
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect('/'); // Redirect ke halaman utama setelah logout
    }
    
}
