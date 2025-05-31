<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'latitude',
        'longitude',
        'Lokasi_Makanan',
        'Jumlah_Makanan',
        'id_user',
    ];

    // Relasi ke pengguna (bisa Donatur atau Admin tergantung rolenya)
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_user', 'id_user');
    }

    public function donatur()
    {
        return $this->belongsTo(Pengguna::class, 'id_user', 'id_user');
    }
         // Mengecek apakah makanan hampir kedaluwarsa (misal H-2)
    public function isAlmostExpired()
    {
        $expirationDate = Carbon::parse($this->Tanggal_Kedaluwarsa);
        return $expirationDate->diffInDays(Carbon::now()) <= 2 && !$this->notified;
    }

    // Menandai makanan sebagai telah diberi notifikasi
    public function markAsNotified()
    {
        $this->notified = true;
        $this->save();
    }
}
