<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Savings extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'group_uid',
        'member_name', // Change to member_uid
        'amount',
        'date_of_deposit',
    ];

    // Define the relationship with the Member model
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_uid'); // Ensure this is correct
    }

    // Define the relationship with the Group model
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_uid'); // Ensure this is correct
    }
}