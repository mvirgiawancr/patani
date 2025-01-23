<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;
    protected $table = 'detail_pesanan';  // Sesuaikan nama tabel dengan yang ada di database
    protected $primaryKey = 'id_detail_pesanan';  // Pastikan primary key sesuai
    public $incrementing = true;  // Pastikan auto increment diaktifkan
    protected $keyType = 'int';  // Pastikan tipe primary key adalah integer
    protected $fillable = [
        'id_pesanan',
        'id_produk',
        'jumlah',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function detailPesanan()
{
    return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
}





}
