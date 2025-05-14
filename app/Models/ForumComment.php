<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForumComment extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $primaryKey = 'ID_Comment';
    protected $fillable = ['ID_ForumPost', 'ID_Pengguna', 'konten'];
    
    public function post()
    {
        return $this->belongsTo(ForumPost::class, 'ID_ForumPost', 'ID_ForumPost');
    }
    
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'ID_Pengguna', 'ID_Pengguna');
    }
}