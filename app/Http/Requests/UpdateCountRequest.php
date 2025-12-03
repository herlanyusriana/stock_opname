<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCountRequest extends FormRequest
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
            'code' => ['sometimes', 'string', 'max:100', Rule::unique('counts', 'code')->ignore($this->count)],
            'location_id' => ['sometimes', 'exists:locations,id'],
            'shift' => ['sometimes', 'string', 'max:50'],
            'production_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.part_id' => ['required', 'exists:parts,id'],
            'items.*.quantity' => ['required', 'integer', 'min:0'],
            'items.*.production_date' => ['nullable', 'date'],
            'items.*.shift' => ['nullable', 'string', 'max:50'],
        ];
    }
}
