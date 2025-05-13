<?php

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikels';

    protected $fillable = [
        'judul',
        'slug',
        'excerpt',
        'konten',
        'kategori',
        'image_path',
    ];

    public function likedBy()
    {
        return $this->belongsToMany(User::class, 'artikel_user_like')
                    ->withTimestamps();
    }
}
