<?php

// app/Models/Makanan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Makanan extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_Makanan';

    protected $fillable = [
        'Nama_Makanan',
        'Deskripsi_Makanan',
        'Kategori_Makanan',
        'Status_Makanan',
        'Tanggal_Kedaluwarsa',
        'Lokasi_Makanan',
        'ID_Pengguna',
    ];
}
