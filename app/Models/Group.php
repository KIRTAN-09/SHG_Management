<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'name',
        'village_name',
        'president_name',
        'secretary_name',
        'no_of_members',
    ];

    public function members()
    {
        return $this->hasMany(Member::class);
    }
}
