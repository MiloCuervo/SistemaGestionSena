<?php

namespace App\Observers;

use App\Models\OrganizationProcess;
use App\Models\User;
use App\Notifications\ProcessClosedNotification;
use Illuminate\Support\Facades\Notification;

class OrganizationProcessObserver
{
    /**
     * Handle the OrganizationProcess "created" event.
     */
    public function created(OrganizationProcess $process): void
    {
        //
    }

    /**
     * Handle the OrganizationProcess "updated" event.
     */
    public function updated(OrganizationProcess $process): void
    {
        if ($process->isDirty('active') && !$process->active) {
            $users = User::all();
            Notification::send($users, new ProcessClosedNotification($process));
        }
    }

    /**
     * Handle the OrganizationProcess "deleted" event.
     */
    public function deleted(OrganizationProcess $process): void
    {
        //
    }

    /**
     * Handle the OrganizationProcess "restored" event.
     */
    public function restored(OrganizationProcess $process): void
    {
        //
    }

    /**
     * Handle the OrganizationProcess "force deleted" event.
     */
    public function forceDeleted(OrganizationProcess $organizationProcess): void
    {
        //
    }
}
