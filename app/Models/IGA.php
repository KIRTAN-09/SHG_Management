<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IGA extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'date', 'activity', 'category', 'earned'
    ];

    protected $table = 'igas'; // Ensure the table name is correct
}
