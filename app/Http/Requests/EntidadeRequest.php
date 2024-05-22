<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntidadeRequest extends FormRequest
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
            'nome' => 'required|unique:entidades,nome,NULL,id,entidade_oficial,' . $this->input('entidade_oficial'),
            "photo_url" => "required|file|image",
            'url' => 'required|url:http,https',
            "entidade_oficial" => "required | boolean"
        ];
    }
    public function messages(): array
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.unique' => 'Este nome já está em uso.',
            'photo_url.required' => 'O campo imagem é obrigatório.',
            'photo_url.file' => 'O campo imagem deve ser um arquivo.',
            'photo_url.image' => 'O campo deve ser uma imagem.',
            'url.required' => 'O campo url é obrigatório.',
            'url.url' => 'O campo url deve ser uma URL válida começando com http ou https.',
            'entidade_oficial.required' => 'O campo entidade oficial é obrigatório.',
            'entidade_oficial.boolean' => 'O campo entidade oficial deve ser verdadeiro ou falso.'
        ];
    }
}
