<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestModel extends Model
{
    protected $fillable = [
        'id_user',
        'ID_Makanan',
        'Pesan',
        'Status_Request',
        'Waktu_Pengambilan',
        'Alamat_Pengambilan',
        'Status_Pengambilan'
    ];
} 