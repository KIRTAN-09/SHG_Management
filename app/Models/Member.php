<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo', 'name', 'number', 'village', 'group', 'caste', 'share_price', 'share_quantity', 'member_type', 'member_id', 'Status', 'group_id'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
