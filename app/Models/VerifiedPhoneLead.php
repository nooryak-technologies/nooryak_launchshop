<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifiedPhoneLead extends Model
{
    protected $table = 'verified_phone_leads';

    protected $fillable = [
        'name',
        'phone',
        'country_code',
        'purchased',
        'otp_sent_at',
    ];

    protected $casts = [
        'purchased'   => 'boolean',
        'otp_sent_at' => 'datetime',
    ];
}
