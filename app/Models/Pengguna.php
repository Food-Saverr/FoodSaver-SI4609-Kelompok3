<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'penggunas';
    protected $primaryKey = 'ID_Pengguna';

    protected $fillable = [
        'Nama_Pengguna',
        'Email_Pengguna',
        'Password_Pengguna',
        'Alamat_Pengguna',
        'Role_Pengguna',
    ];

    protected $hidden = [
        'Password_Pengguna',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->Password_Pengguna;
    }

    public function makanan()
    {
        return $this->hasMany(Makanan::class, 'user_id', 'ID_Pengguna');
    }
}
