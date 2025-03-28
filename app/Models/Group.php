<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes,HasFactory;

    protected $fillable = [
        'group_uid',
        'name',
        'village_name',
        'president_name',
        'secretary_name',
        'no_of_members',
    ];

    public function members()
    {
        return $this->hasMany(Member::class); // Adjust the related model and foreign key as needed
    }
}
