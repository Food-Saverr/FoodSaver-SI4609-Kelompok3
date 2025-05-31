<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumLike extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'ID_Like';
    protected $fillable = ['ID_ForumPost', 'id_user'];
    
    public function post()
    {
        return $this->belongsTo(ForumPost::class, 'ID_ForumPost', 'ID_ForumPost');
    }
    
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_user', 'id_user');
    }
}