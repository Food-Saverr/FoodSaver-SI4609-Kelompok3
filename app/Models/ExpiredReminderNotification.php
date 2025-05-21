<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpiredReminderNotification extends Model
{
    protected $table = 'expired_reminder_notifications';
    
    protected $fillable = [
        'makanan_id',
        'subject',
        'message',
        'send_at',
        'status'
    ];

    protected $casts = [
        'send_at' => 'datetime',
    ];

    /**
     * Get the makanan associated with the notification.
     */
    public function makanan(): BelongsTo
    {
        return $this->belongsTo(Makanan::class, 'makanan_id', 'ID_Makanan');
    }
}
