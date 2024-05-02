<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CopyProvaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "external_entity_id" => "required|integer|exists:rallies,external_entity_id",
            "rally_id" => "required|integer|exists:rallies,id",
        ];
    }
}
