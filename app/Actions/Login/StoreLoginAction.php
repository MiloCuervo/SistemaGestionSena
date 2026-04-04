<?php

namespace App\Actions\Login;

use App\DTOs\LoginData;
use App\Models\Login;
use Illuminate\Support\Facades\Log;

class StoreLoginAction
{
    /**
     * Ejecuta el proceso de guardado de un login.
     */
    public function execute(array $data): Login
    {
        try {
            return Login::create($data);
        } catch (\Exception $e) {
            Log::error('Error al guardar registro de login: '.$e->getMessage(), [
                'data' => $data,
            ]);
            throw $e;
        }
    }
}


