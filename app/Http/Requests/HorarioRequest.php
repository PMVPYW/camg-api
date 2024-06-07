<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HorarioRequest extends FormRequest
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
            "titulo" => "required|string",
            "descricao" => "required|string",
            "inicio" => "required|date|before:fim",
            "fim" => "required|date|after:inicio",
        ];
    }

    public function messages(): array
    {
        return [
            "rally_id.required" => "O id do rally é obrigatório!",
            "titulo.required" => "O titulo é obrigatório!",
            "descricao.required" => "A descrição é obrigatória!",
            "inicio.required" => "A data de inicio é obrigatória!",
            "fim.required" => "A data de fim é obrigatória!",
            "inicio.date" => "A data de inicio deve ser uma data!",
            "inicio.before" => "A data de inicio deve ser menor que a data de fim!",
            "fim.date" => "A data de fim deve ser uma data!",
            "fim.after" => "A data de fim deve ser maior que a data de inicio!"
        ];
    }
}
