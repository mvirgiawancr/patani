<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';  // Tentukan kolom primary key yang digunakan
    public $incrementing = true;  // Pastikan auto increment diaktifkan
    protected $keyType = 'int';  // Pastikan tipe primary key adalah integer
    protected $fillable = [
        'id_penjual',
        'id_pembeli',
        'total_harga',
    ];


    public function penjual()
    {
        return $this->belongsTo(User::class, 'id_penjual');
    }

   

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan');
    }

    public function pembeli()
{
    return $this->belongsTo(User::class, 'id_pembeli', 'id_user');
}
}
