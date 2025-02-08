<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan konvensi Laravel
    protected $table = 'alamats';

    // Tentukan primary key jika tidak menggunakan 'id'
    protected $primaryKey = 'id_alamat';

    // Nonaktifkan auto-increment jika primary key bukan integer
    public $incrementing = true;

    // Tentukan tipe primary key
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'latitude',
        'longitude',
        'alamat_lengkap',
        'kecamatan',
        'kota',
    ];

    /**
     * Relasi dengan tabel User (one-to-many atau one-to-one tergantung kebutuhan).
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id_alamat', 'id_alamat');
    }
}
