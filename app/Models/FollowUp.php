<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{

    protected $table = 'follow_ups';
    protected $fillable = [
        'case_id',
        'description',
        'follow_up_evidence',
        'follow_up_number',

    ];

    public function case()
    {
        return $this->belongsTo(Cases::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
