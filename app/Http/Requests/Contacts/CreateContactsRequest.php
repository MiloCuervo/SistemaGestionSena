<?php

namespace App\Http\Requests\Contacts;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateContactsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'identification_number' => 'required|int|max:10000000000',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:15',
            'position' => 'nullable|string|max:255',
        ];
    }
}
