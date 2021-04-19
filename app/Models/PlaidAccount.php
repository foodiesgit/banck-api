<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaidAccount extends Model
{
    use HasFactory;

    protected $table = "plaid_accounts";
    protected $fillable = [
        'client_user_id', 'link_token', 'expiration', 'request_id',
    ];
}
