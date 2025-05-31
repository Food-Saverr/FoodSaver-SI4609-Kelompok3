<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpiredFoodHistory extends Model
{
    use HasFactory;

    protected $table = 'expired_food_history';
    
    protected $fillable = [
        'ID_Makanan',
        'Nama_Makanan',
        'Deskripsi_Makanan',
        'Kategori_Makanan',
        'Foto_Makanan',
        'Tanggal_Kedaluwarsa',
        'Jumlah_Makanan',
        'Jumlah_Didonasi',
        'id_user',
        'expired_at'
    ];

    protected $casts = [
        'Tanggal_Kedaluwarsa' => 'datetime',
        'expired_at' => 'datetime'
    ];

    // Relasi ke pengguna (donatur)
    public function donatur()
    {
        return $this->belongsTo(Pengguna::class, 'id_user', 'id_user');
    }
} 