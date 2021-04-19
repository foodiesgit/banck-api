<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryCodes extends Model
{
    use HasFactory;
    protected $table = 'countries_iso_3166';
}
