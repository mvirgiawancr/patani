<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak menggunakan nama tabel default
    protected $table = 'produk';

    // Tentukan kolom primary key jika bukan 'id'
    protected $primaryKey = 'id_produk';

    // Jika kolom primary key tidak menggunakan auto-increment, atur menjadi false
    public $incrementing = true;

    // Tentukan tipe data primary key jika bukan integer (misalnya, jika menggunakan string atau UUID)
    protected $keyType = 'int';

    // Kolom yang boleh diisi mass-assign
    protected $fillable = [
        'nama_produk',
        'harga_produk',
        'deskripsi',
        'stok',
        'id_user',
        'foto',
    ];

    // Jika Anda ingin menetapkan kolom timestamp di database (created_at, updated_at)
    public $timestamps = true;
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function penjual()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
