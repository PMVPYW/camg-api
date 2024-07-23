<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CapituloRequest extends FormRequest
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
            "historia_id" => "integer|sometimes|nullable|exists:historia,id",
            "titulo" => "required|string|min:0|unique:capitulo,titulo",
        ];
    }
    public static function rulesArray(): array
    {
        return [
            "titulo" => "required|string|min:0|unique:capitulo,titulo",
        ];
    }
}
