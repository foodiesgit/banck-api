<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'costumers';
    protected $fillable = [
        'client_name',
        'legal_name',
        'phone_number',
        'email_address',
        'country_code',
        'language',
    ];

    public function plaidProducts()
    {
        return $this->belongsToMany('App\Models\PlaidProduct', 'costumer_plaid_product', 'plaid_product_id', 'costumer_id');

    }
}
