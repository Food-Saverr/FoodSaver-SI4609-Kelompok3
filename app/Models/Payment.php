<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_id',
        'payment_method',
        'payment_status',
    ];

    /**
     * Relasi ke model Donation.
     */
    public function order()
    {
        return $this->belongsTo(Donation::class);
    }
}
