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
    public function execute(LoginData $data): Login
    {
        try {
            // Convertimos el DTO a un array para crear el modelo
            $loginData = $data->toArray();
            // Creamos el registro con los datos proporcionados.
            return Login::create($loginData);

        } catch (\Exception $e) {
            // Registramos el error para debugging
            Log::error('Error al guardar registro de login: '.$e->getMessage(), [
                'data' => $data,
            ]);

            // Lanzamos la excepción para que pueda ser manejada por el llamador
            throw $e;
        }
    }
}


