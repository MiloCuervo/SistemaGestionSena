<?php

namespace App\Actions\Login;

use App\Models\Login;
use Illuminate\Support\Facades\Log;

class UpdateLogoutAction
{
    /**
     * Create a new class instance.
     */
    public function execute(array $criteria): bool
    {
        try {
            // se busca el registro del login donde cumpla con los criterios
            $updated = Login::where($criteria)
                ->whereNull('logged_out_at')
                ->update(['logged_out_at' => now()]);

            return $updated > 0;

        } catch (\Exception $e) {
            Log::error('Error al actualizar registro de login: '.$e->getMessage(), [
                'criteria' => $criteria,
            ]);

            throw $e;
        }
    }
}
