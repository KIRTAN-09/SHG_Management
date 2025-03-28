<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Group;

class Member extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'photo', 'name', 'number', 'village', 'group', 'caste', 'share_price', 'share_quantity', 'member_type', 'member_uid', 'status', 'group_uid'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }   
}
