<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserConfiguration extends Model
{
    protected $table = 'user_configurations';
    protected $fillable = [
        'user_id',
        'role_id',
        'dark_mode',
        'report_frequency',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
