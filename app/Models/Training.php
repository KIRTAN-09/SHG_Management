<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'training_date',
        'trainer',
        'members_name',
        'members_ID',
        'location',
        'category',
    ];
}
