<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikels';
    protected $primaryKey = 'id';

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'gambar',
        'user_id',
    ];

    protected static function booted()
    {
        static::creating(function ($artikel) {
            $artikel->slug = Str::slug($artikel->judul);
        });

        static::updating(function ($artikel) {
            if ($artikel->isDirty('judul')) {
                $artikel->slug = Str::slug($artikel->judul);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(Pengguna::class, 'user_id', 'id_user');
    }

    public function likers()
    {
        return $this->belongsToMany(
            Pengguna::class,
            'artikel_user_like',
            'artikel_id',
            'user_id'
        )->withTimestamps();
    }

    public function getLikeCountAttribute()
    {
        return $this->likers()->count();
    }

    public function isLikedBy(Pengguna $user): bool
    {
        return $this->likers()->where('user_id', $user->id_user)->exists();
    }
}