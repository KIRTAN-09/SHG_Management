<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Savings extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'name', // Added to resolve SQL error
        'date', // Added date to the fillable array
    ];
}
