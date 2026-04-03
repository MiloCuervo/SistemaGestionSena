<?php

namespace App\Http\Requests\Cases;

use App\Models\Cases;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCaseStatusRequest extends FormRequest
{
    /*
     *Determina si el usuario si está autorizado para realizar esta solicitud 
     *En este caso, solo los comisionados pueden modificar el estado de un caso.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isCommissioner();
    }


    /*
     * Obtiene las reglas de validación que se aplican a la solicitud.
     */
    public function rules(): array
    {
        return [
            'status' => 'required|in:attended,not_attended,in_progress',
        ];
    }
}
