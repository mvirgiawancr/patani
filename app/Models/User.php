<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Tentukan nama kolom primary key jika tidak menggunakan 'id'
    protected $primaryKey = 'id_user'; // Primary key menggunakan 'id_user'

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'no_telepon',
        'id_alamat',
        'role',
        'foto'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relasi ke tabel alamat (one-to-one).
     */
    public function alamat()
    {
        return $this->belongsTo(Alamat::class, 'id_alamat', 'id_alamat');
    }

 
    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_user');
    }
    /**
     * Mutator untuk menyimpan password yang di-hash (jika hashing digunakan).
     */
    public function setPasswordAttribute($value)
    {
        // Simpan password dengan hashing jika perlu
        $this->attributes['password'] = bcrypt($value);
    }

    public function pesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pembeli', 'id_user');
    }

}
