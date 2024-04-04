<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RallyRequestUpdate extends FormRequest
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
            "nome" => "sometimes|string|min:0",
            "data_inicio" => "sometimes|date|before_or_equal:data_fim",
            "data_fim" => "sometimes|date|after_or_equal:data_inicio",
            "external_entity_id" => "sometimes|integer",
            "photo_url" => "file|image"
        ];
    }
}
