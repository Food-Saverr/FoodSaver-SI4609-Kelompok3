<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Makanan extends Model
{
    use HasFactory;

    protected $table = 'makanan';

    protected $fillable = [
        'Nama_Makanan',
        'Jumlah_Tersedia',
        'Jumlah_Didonasi',
        'status',
        'user_id'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'user_id', 'ID_Pengguna');
    }
}
