<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForumPost extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $primaryKey = 'ID_ForumPost';
    protected $fillable = ['ID_Pengguna', 'judul', 'konten'];
    
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'ID_Pengguna', 'ID_Pengguna');
    }
    
    public function comments()
    {
        return $this->hasMany(ForumComment::class, 'ID_ForumPost', 'ID_ForumPost');
    }
    
    public function attachments()
    {
        return $this->hasMany(ForumAttachment::class, 'ID_ForumPost', 'ID_ForumPost');
    }
    
    public function likes()
    {
        return $this->hasMany(ForumLike::class, 'ID_ForumPost', 'ID_ForumPost');
    }
    
    public function isLikedByUser($userId)
    {
        return $this->likes()->where('ID_Pengguna', $userId)->exists();
    }
    
    // Menghitung jumlah like
    public function likeCount()
    {
        return $this->likes()->count();
    }
    
    // Menghitung jumlah komentar
    public function commentCount()
    {
        return $this->comments()->count();
    }
}