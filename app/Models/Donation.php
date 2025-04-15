<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'ID_Pengguna', 
        'full_name', 
        'phone', 
        'nominal',
        'note', 
        'status'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'Id_Pengguna');
    }
}
