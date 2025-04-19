<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    use HasFactory;

    protected $table = 'penggunas';
    protected $primaryKey = 'ID_Pengguna';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'Nama_Pengguna',
        'Email_Pengguna',
        'Password_Pengguna',
        'Alamat_Pengguna',
        'Role_Pengguna',
    ];

    protected $hidden = [
        'Password_Pengguna',
    ];

    public function getAuthPassword()
    {
        return $this->Password_Pengguna;
    }
}
