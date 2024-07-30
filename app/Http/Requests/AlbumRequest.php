<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AlbumRequest extends FormRequest
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
            "rally_id" => "integer|exists:rallies,id|nullable",
            "nome" => "string|required",
            "img" => "file|nullable|image"
        ];
    }
    public function messages(): array
    {
        return [
            'rally_id.integer' => 'O campo rally deve ser um número inteiro.',
            'rally_id.exists' => 'O rally fornecido não existe.',
            'nome.string' => 'O campo nome deve ser um texto.',
            'nome.required' => 'O campo nome é obrigatório.',
            'img.file' => 'O campo imagem deve ser um arquivo.',
            'img.image' => 'O campo deve ser uma imagem.',
        ];
    }
}
