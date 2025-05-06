<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikels';
    protected $primaryKey = 'id';

    protected $fillable = [
        'judul',
        'konten',
        'gambar',
        'status',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(Pengguna::class, 'user_id', 'id_user');
    }
}
