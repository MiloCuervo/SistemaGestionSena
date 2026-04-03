<?php

namespace App\Http\Requests\Cases;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCaseRequest extends FormRequest
{
    /**
     *Determina si el usuario si está autorizado para realizar esta solicitud 
     *En este caso, solo los comisionados pueden agregar un nuevo caso.
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
            'sena_number' => 'nullable|string',
            'description' => 'required|string',
            'case_evidence' => 'nullable|string',
            'contact_id' => 'required|exists:contacts,id',
            'organization_process_id' => 'required|exists:organization_processes,id',
            'type' => 'required|in:denunciation,complaint,request,right_of_petition,tutelage',
        ];
    }
}
