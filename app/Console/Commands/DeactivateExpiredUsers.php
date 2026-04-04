<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserConfiguration;
use App\Models\Auditing;

class DeactivateExpiredUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deactivate-expired-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate users whose validity has expired';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expired = UserConfiguration::where('active', true)
            ->where('expires_at', '<=', now())
            ->get();

        foreach ($expired as $config) {
            $config->update([
                'active' => false,
                'deactivation_reason' => 'expired',
            ]);

            Auditing::create([
                'user_id' => $config->user_id,
                'action' => 'user_expired',
                'description' => 'Usuario desactivado por expiración de vigencia',
            ]);
        }

        $this->info("Se desactivaron {$expired->count()} usuarios.");
    }
}
