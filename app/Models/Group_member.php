<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group_member extends Model
{
    //
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'group_uid',
        'member_id',
        'in_date',
        'out_date',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_uid', 'id');
    }
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
