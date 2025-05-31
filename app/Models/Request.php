<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $table = 'requests';
    protected $primaryKey = 'ID_Request';
    protected $fillable = [
        'ID_Makanan', 
        'ID_Pengguna', 
        'Pesan', 
        'id_user',
        'Status_Request',
        'Status_Pengambilan',
        'Waktu_Pengambilan',
        'Alamat_Pengambilan',
        'Catatan_Pembatalan'
    ];

    protected $casts = [
        'Waktu_Pengambilan' => 'datetime'
    ];

    public function makanan()
    {
        return $this->belongsTo(Makanan::class, 'ID_Makanan', 'ID_Makanan');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_user', 'id_user');
    }
}
