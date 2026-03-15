<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Money\Money;

class CustomerData extends Model
{
    protected $fillable = [
        'name',
        'customer_id',
        'user_id',
        'date_sold',
        'date_delivered',
        'product_name',
        'price',
        'vat',
        'invoice_uuid',
        'version',
        'is_active',
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
    ];

public function getNettoAttribute() {
    return Money::PLN((int)$this->price);
}

public function getVatValueAttribute() {
    $multiplier = (string)($this->vat / 100);
    return $this->netto->multiply($multiplier);
}

public function getBruttoAttribute() {
    return $this->netto->add($this->vatValue);
}

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
