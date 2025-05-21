<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;

    protected $table = 'forums';
    protected $fillable = [
        'judul', 'konten', 'is_active', 'created_at', 'updated_at'
    ];

    protected $guarded = [];

    public static function statistikPerBulan()
    {
        return self::select(
                \DB::raw('cast(strftime("%m", created_at) as integer) as bulan'),
                \DB::raw('COUNT(*) as total_forum')
            )
            ->groupBy(\DB::raw('cast(strftime("%m", created_at) as integer)'))
            ->orderBy('bulan')
            ->get();
    }

    public static function forumAktif()
    {
        return self::where('is_active', true)->get();
    }
}
