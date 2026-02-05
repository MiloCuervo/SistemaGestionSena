<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $fillable = [
        'name',
        'active',
    ];

    public function userConfiguration()
    {
        return $this->hasMany(UserConfiguration::class);
    }
}
