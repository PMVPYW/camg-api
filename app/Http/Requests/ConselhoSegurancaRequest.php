<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConselhoSegurancaRequest extends FormRequest
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
            "rally_id" => "required|exists:rallies,id",
            "descricao" => "required|string",
            "img_conselho" => "required|file|image",
            "erro" => "required|string",
            "img_erro" => "required|file|image"
        ];
    }
}
