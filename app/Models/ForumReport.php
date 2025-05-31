<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumReport extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'ID_Report';
    protected $fillable = ['ID_ForumPost', 'id_user', 'alasan_laporan', 'deskripsi', 'status', 'admin_notes', 'ID_Admin', 'handled_at'];
    
    // Report belongs to a post
    public function post()
    {
        return $this->belongsTo(ForumPost::class, 'ID_ForumPost', 'ID_ForumPost');
    }
    
    // Report belongs to a user (reporter)
    public function reporter()
    {
        return $this->belongsTo(Pengguna::class, 'id_user', 'id_user');
    }
    
    // Report may be handled by an admin
    public function admin()
    {
        return $this->belongsTo(Pengguna::class, 'ID_Admin', 'id_user');
    }
    
    // Scope for pending reports
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    
    // Scope for actioned reports
    public function scopeActioned($query)
    {
        return $query->where('status', 'actioned');
    }
    
    // Get report reason label
    public function getReasonLabel()
    {
        $reasons = [
            'spam' => 'Spam atau Konten Promosi',
            'inappropriate' => 'Konten Tidak Pantas',
            'harassment' => 'Pelecehan atau Intimidasi',
            'violence' => 'Konten Kekerasan',
            'hate_speech' => 'Ujaran Kebencian',
            'false_info' => 'Informasi Palsu',
            'other' => 'Alasan Lain',
        ];
        
        return $reasons[$this->alasan_laporan] ?? $this->alasan_laporan;
    }
}