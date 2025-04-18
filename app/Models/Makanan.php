<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Makanan extends Model
{
    use HasFactory;

    protected $table = 'makanan';

    protected $fillable = [
        'nama',
        'deskripsi',
        'jumlah',
        'status', 
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
