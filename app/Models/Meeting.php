<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'date',
        'group_name',
        'group_uid',
        'discussion',
        'photo',
        'attendance',
    ];
}
