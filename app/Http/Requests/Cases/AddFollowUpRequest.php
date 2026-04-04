<?php

namespace App\Http\Requests\Cases;

use App\Models\Cases;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AddFollowUpRequest extends FormRequest
{
    /**
     *Determina si el usuario si está autorizado para realizar esta solicitud 
     *En este caso, solo los comisionados pueden agregar seguimientos a un caso.
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
            'follow_up_evidence' => 'nullable|array',
            'follow_up_evidence.*' => 'file|mimes:pdf,png,jpg,jpeg|max:5120',
        ];
    }
}
