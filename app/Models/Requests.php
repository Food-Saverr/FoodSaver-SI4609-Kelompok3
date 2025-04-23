<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_Request';

    protected $table = 'requests';

    protected $fillable = [
        'ID_Makanan',
        'ID_Pengguna',
        'Pesan',
        'Status_Request',
    ];

    public function makanan()
    {
        return $this->belongsTo(Makanan::class, 'ID_Makanan', 'ID_Makanan');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'ID_Pengguna', 'ID_Pengguna');
    }
}