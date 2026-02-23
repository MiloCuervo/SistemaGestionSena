<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cases extends Model
{
    protected $table = 'cases';
    protected $fillable = [
        'case_number',
        'description',
        'case_evidence',
        'status',
        'type',
        'user_id',
        'contact_id',
        'organization_process_id',
        'closed_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function organizationProcess()
    {
        return $this->belongsTo(OrganizationProcess::class);
    }

    public function followUps()
    {
        return $this->hasMany(FollowUp::class, 'case_id');
    }

    public function audittings()
    {
        return $this->hasMany(Auditing::class, 'case_id');
    }
}
