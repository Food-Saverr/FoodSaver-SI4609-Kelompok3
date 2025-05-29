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
        'maintenance',
        'announcements_enabled',
        'ads_enabled'
    ];

    protected $casts = [
        'request_status' => 'boolean',
        'new_requests' => 'boolean',
        'maintenance' => 'boolean',
        'announcements_enabled' => 'boolean',
        'ads_enabled' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
