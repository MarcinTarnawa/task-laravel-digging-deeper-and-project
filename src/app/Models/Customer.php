<?php

namespace App\Models;

use App\Models\CustomerData;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name', 
        'lastName', 
        'address',
        'email',
        'email_consent',
        'consent_sent_at'
    ];

    public function customerData()
    {
        return $this->hasMany(CustomerData::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}