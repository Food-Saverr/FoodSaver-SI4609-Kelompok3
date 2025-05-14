<?php

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikels';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'image_path',
        'category',
        'user_id', // admin penulis
    ];

    /**
     * Set the slug automatically from the title.
     */
    public static function booted()
    {
        static::saving(function ($artikel) {
            if (empty($artikel->slug)) {
                $artikel->slug = Str::slug($artikel->title);
            }
        });
    }

    /**
     * Penulis (admin) relationship.
     */
    public function penulis()
    {
        return $this->belongsTo(Pengguna::class, 'user_id');
    }

    /**
     * Likes pivot.
     */
    public function likes()
    {
        return $this->hasMany(ArtikelUserLike::class);
    }

    /**
     * Scope to search by keyword or category.
     */
    public function scopeSearch($query, $term)
    {
        if ($term) {
            $query->where('title', 'like', "%{$term}%")
                  ->orWhere('body',  'like', "%{$term}%")
                  ->orWhere('category', $term);
        }
    }
}
