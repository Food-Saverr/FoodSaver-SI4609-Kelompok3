<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtikelUserLike extends Model
{
    use HasFactory;

    protected $table = 'artikel_user_like';

    protected $fillable = ['artikel_id', 'user_id'];

    public function artikel()
    {
        return $this->belongsTo(Artikel::class);
    }

    public function user()
    {
        return $this->belongsTo(Pengguna::class, 'user_id');
    }
}