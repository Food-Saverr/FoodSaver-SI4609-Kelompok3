<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_Permintaan';

    protected $fillable = [
        'Status_Permintaan',
        'Waktu_Permintaan',
        'ID_Pengguna',
        'ID_Makanan',
    ];
    public function makanan()
    {
        return $this->belongsTo(Makanan::class, 'ID_Makanan');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'ID_Pengguna');
    }
}

