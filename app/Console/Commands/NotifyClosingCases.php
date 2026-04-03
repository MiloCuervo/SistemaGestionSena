<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cases;
use App\Notifications\CaseClosingSoonNotification;
use Carbon\Carbon;

class NotifyClosingCases extends Command
{
    protected $signature = 'app:notify-closing-cases';
    protected $description = 'Notifica casos próximos a cerrar';

    public function handle()
    {
        $start = Carbon::now()->addDays(1)->toDateString();
        $end = Carbon::now()->addDays(10)->toDateString();

        $this->info("Buscando casos con fecha de cierre entre: {$start} y {$end}");

        $cases = Cases::whereBetween('closed_date', [$start, $end])->get();

        $this->info("Total de casos encontrados: " . $cases->count());

        if ($cases->isEmpty()) {
            $this->warn("No hay casos en ese proximos a cerrar.");
            return;
        }

        foreach ($cases as $case) {
            $this->line("Procesando caso número: {$case->case_number}, cierra: {$case->closed_date}");

            if (!$case->user) {
                $this->error("El caso no tiene usuario asociado (user_id = {$case->user_id})");
                continue;
            }

            $case->user->notify(new CaseClosingSoonNotification($case));
            $this->info("Notificación enviada al usuario {$case->user->name}");
        }
    }
}