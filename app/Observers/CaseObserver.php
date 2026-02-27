<?php

namespace App\Observers;

use App\Models\cases;
use Illuminate\Support\Facades\Notification;

class CaseObserver
{
    /**
     * Handle the cases "created" event.
     */
    public function created(cases $cases): void
    {
        // Get the user who created the case
        $creator = $cases->user; 

        // If there is no creator associated with the case, return early
        if (!$creator) {
            return; 
        }
        
        // Notify the user who created the case via email
        $creator->notify(new \App\Notifications\CaseCreatedMail($cases));
        
        // Notify all users about the new case via database notification
        $users = \App\Models\User::all();
        Notification::send($users, new \App\Notifications\CaseCreatedNotification($cases, $creator));
    }

    /**
     * Handle the cases "updated" event.
     */
    public function updated(cases $cases): void
    {
        //
    }

    /**
     * Handle the cases "deleted" event.
     */
    public function deleted(cases $cases): void
    {
        //
    }

    /**
     * Handle the cases "restored" event.
     */
    public function restored(cases $cases): void
    {
        //
    }

    /**
     * Handle the cases "force deleted" event.
     */
    public function forceDeleted(cases $cases): void
    {
        //
    }
}
