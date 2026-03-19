<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationProcess extends Model
{
    protected $table = 'organization_processes';

    public const PAGINATE = 10;

    protected $fillable = [
        'name',
        'description',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function cases()
    {
        return $this->hasMany(Cases::class);
    }
}
