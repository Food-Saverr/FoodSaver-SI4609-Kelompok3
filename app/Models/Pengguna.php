<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'penggunas';
    protected $primaryKey = 'id_user';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'Nama_Pengguna',
        'Email_Pengguna',
        'Password_Pengguna',
        'Alamat_Pengguna',
        'Role_Pengguna',
        'is_active', // Kolom is_active ditambahkan ke sini
    ];

    protected $hidden = [
        'Password_Pengguna',
    ];

    public function makanans()
    {
        return $this->hasMany(Makanan::class, 'id_user', 'id_user');
    }

    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification::class, 'user_id', 'id_user');
    }

    public function notificationPreference()
    {
        return $this->hasOne(\App\Models\NotificationPreference::class, 'user_id', 'id_user');
    }

    public function getAuthIdentifierName()
    {
        return 'id_user';
    }

    public function getAuthPassword()
    {
        return $this->Password_Pengguna;
    }

    public function likedArtikels()
    {
        return $this->belongsToMany(
            Artikel::class,
            'artikel_user_like',
            'user_id',
            'artikel_id'
        )->withTimestamps();
    }

    public function forumPosts()
    {
        return $this->hasMany(\App\Models\ForumPost::class, 'id_user', 'id_user');
    }
}
