<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auditing extends Model
{
    protected $fillable = [
        'user_id',
        'case_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function case()
    {
        return $this->belongsTo(cases::class);
    }
}
