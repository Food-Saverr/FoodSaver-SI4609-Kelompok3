<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $table = 'requests';
    protected $primaryKey = 'ID_Request';
    protected $fillable = ['ID_Makanan', 'id_user', 'Pesan', 'Status_Request'];

    public function makanan()
    {
        return $this->belongsTo(Makanan::class, 'ID_Makanan', 'ID_Makanan');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_user', 'id_user');
    }
}
