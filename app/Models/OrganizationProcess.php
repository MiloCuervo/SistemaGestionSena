<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cases;

class OrganizationProcess extends Model
{
    protected $table = 'organization_processes';
    protected $fillable = [
        'name',
        'description',
        'active',
    ];

    public function cases()
    {
        return $this->hasMany(Cases::class);
    }
}
