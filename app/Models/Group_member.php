<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group_member extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'group_id',
        'member_id',
        'in_date',
        'out_date',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
