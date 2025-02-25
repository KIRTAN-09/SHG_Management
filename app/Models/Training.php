<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_date',
        'trainer',
        'members_name',
        'members_ID',
        'location',
        'category',
    ];
}
