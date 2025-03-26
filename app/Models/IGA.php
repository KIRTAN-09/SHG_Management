<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IGA extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['member_id', 'date', 'category', 'earned'];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
    
    protected $table = 'igas'; // Ensure the table name is correct
}
