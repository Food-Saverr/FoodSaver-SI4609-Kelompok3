<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumLike extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'ID_Like';
    protected $fillable = ['ID_ForumPost', 'ID_Pengguna'];
    
    public function post()
    {
        return $this->belongsTo(ForumPost::class, 'ID_ForumPost', 'ID_ForumPost');
    }
    
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'ID_Pengguna', 'ID_Pengguna');
    }
}