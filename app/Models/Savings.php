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

    public static function filter($filters)
    {
        $query = self::query();

        if (isset($filters['member_id'])) {
            $query->where('member_id', $filters['member_id']);
        }

        if (isset($filters['group_id'])) {
            $query->where('group_id', $filters['group_id']);
        }

        if (isset($filters['date_from']) && isset($filters['date_to'])) {
            $query->whereBetween('created_at', [$filters['date_from'], $filters['date_to']]);
        }

        return $query;
    }
}