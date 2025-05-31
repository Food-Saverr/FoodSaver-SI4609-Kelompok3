<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumAttachment extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'ID_Attachment';
    protected $fillable = ['ID_ForumPost', 'nama_file', 'path', 'tipe_file', 'ukuran'];
    
    public function post()
    {
        return $this->belongsTo(ForumPost::class, 'ID_ForumPost', 'ID_ForumPost');
    }
    
    // Mengecek apakah attachment adalah gambar
    public function isImage()
    {
        return in_array($this->tipe_file, ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
    }
}