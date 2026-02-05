<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'full_name',
        'identity_document',
        'email',
        'phone',
        'position',
    ];

    protected $hidden = [
        'identity_document',
    ];

    public function cases()
    {
        return $this->hasMany(cases::class);
    }
}
