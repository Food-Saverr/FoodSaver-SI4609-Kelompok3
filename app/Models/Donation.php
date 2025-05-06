<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'id_user',
        'full_name',
        'phone',
        'nominal',
        'payment_method',
        'note',
        'status'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_user');
    }
}
