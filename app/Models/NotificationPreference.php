<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'request_status',
        'new_requests',
        'maintenance'
    ];

    protected $casts = [
        'request_status' => 'boolean',
        'new_requests' => 'boolean',
        'maintenance' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
