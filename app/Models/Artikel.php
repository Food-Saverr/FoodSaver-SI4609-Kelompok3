<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikel';

    protected $primaryKey = 'id';

    protected $fillable = [
        'judul',
        'konten',
        'gambar',
        'status',
        'user_id',
        'status',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(Pengguna::class, 'user_id', 'ID_Pengguna');

        return $this->belongsTo(User::class);
    }
} 