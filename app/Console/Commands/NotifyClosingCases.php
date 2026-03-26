<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cases;
use App\Notifications\CaseClosingSoonNotification;
use Carbon\Carbon;

class NotifyClosingCases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-closing-cases';

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
        $targetDate = Carbon::now()->addDays(15)->toDateString();
        $cases = Cases::where('closed_date', $targetDate)->get();
        foreach ($cases as $case) {
            $case->user->notify(new CaseClosingSoonNotification($case));
        }
    }
}
