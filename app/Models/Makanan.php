<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Makanan extends Model
{
    use HasFactory;

    protected $table = 'makanans';
    protected $primaryKey = 'ID_Makanan';

    protected $fillable = [
        'Nama_Makanan',
        'Deskripsi_Makanan',
        'Kategori_Makanan',
        'Foto_Makanan',
        'Status_Makanan',
        'Tanggal_Kedaluwarsa',
        'Lokasi_Makanan',
        'Jumlah_Makanan',
        'ID_Pengguna',
    ];

    // Relasi ke pengguna (bisa Donatur atau Admin tergantung rolenya)
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'ID_Pengguna', 'ID_Pengguna');
    }

    public function donatur()
    {
        return $this->belongsTo(Pengguna::class, 'ID_Pengguna', 'ID_Pengguna');
    }
}
