<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Report;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ReportNotification;

class NotifyReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-reports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::whereHas('configurations', function ($query) {
            $query->where('active', true);
        })->get();
        
        foreach ($users as $user) {
            $frecuency = $user->configurations()->where('active', true)->first()->frequency;
            
            if ($frecuency == 'daily') {
                $reports = Report::where('user_id', $user->id)
                    ->whereDate('created_at', now()->toDateString())
                    ->get();
            } 
            
            elseif ($frecuency == 'weekly') {
                $reports = Report::where('user_id', $user->id)
                    ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                    ->get();
            } 
            
            elseif ($frecuency == 'monthly') {
                $reports = Report::where('user_id', $user->id)
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->get();
            }

            if ($reports->count() > 0) {
                Notification::send($user, new ReportNotification($reports));
            }
        }
    }
}
