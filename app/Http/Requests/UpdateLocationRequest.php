<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLocationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'], // class
            'description' => ['nullable', 'string'], // zone
            'code' => ['sometimes', 'string', 'max:50', Rule::unique('locations', 'code')->ignore($this->location)], // lokasi
            'qr_code' => ['nullable', 'string', 'max:255', Rule::unique('locations', 'qr_code')->ignore($this->location)], // auto from lokasi
        ];
    }
}
