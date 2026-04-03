<?php

namespace App\Http\Requests\Cases;

use App\Models\Cases;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCaseRequest extends FormRequest
{
    /**
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
            'description' => 'required|string',
            'type' => 'required|in:denunciation,complaint,request,right_of_petition,tutelage',
            'status' => 'required|in:attended,in_progress,not_attended,closed',
            'contact_id' => 'required|exists:contacts,id',
            'organization_process_id' => 'required|exists:organization_processes,id',
        ];
    }
}
