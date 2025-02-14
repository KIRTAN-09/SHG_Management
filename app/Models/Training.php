<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_id', 'title', 'date', 'location', 'trainer', 'duration', 'status', 'photo'
    ];
}
