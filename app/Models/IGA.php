<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IGA extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'activity',
        'date',
        'location',
        'amount',
        'description',
    ];

    protected $table = 'igas'; // Ensure the table name is correct
}
