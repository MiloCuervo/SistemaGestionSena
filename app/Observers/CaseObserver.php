<?php

namespace App\Observers;

use App\Models\Cases;
use App\Models\User;
use App\Notifications\CaseCreatedMail;
use App\Notifications\CaseCreatedNotification;
use App\Notifications\CaseStatusMail;
use Illuminate\Support\Facades\Notification;

class CaseObserver
{
    /**
     * Handle the cases "created" event.
     */
    public function created(cases $cases): void
    {
        // Get the user who created the case
        $user = $cases->user; 

        // If there is no user associated with the case, return early
        if (!$user) {
            return; 
        }
        
        // Notify the user who created the case via email
        $user->notify(new CaseCreatedMail($cases));
        
        // Notify all users about the new case via database notification
        $users = User::all();
        Notification::send($users, new CaseCreatedNotification($cases, $user));
    }

    /**
     * Handle the cases "updated" event.
     */
    public function updated(cases $cases): void
    {
        // Check if the 'status' attribute was changed
        if ($cases->wasChanged('status')) {
            // Get the user associated with the case
            $user = $cases->user; 

            // If there is no user associated with the case, return early
            if (!$user) {
                return; 
            }

            // Notify the user about the status update via email
            $user->notify(new CaseStatusMail($cases));
        }
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
