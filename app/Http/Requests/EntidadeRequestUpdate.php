<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntidadeRequestUpdate extends FormRequest
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
            'nome' => 'sometimes|unique:entidades,nome,' . $this->route('entidade')->id . ',id,entidade_oficial,' . $this->input('entidade_oficial'),
            'photo_url' => 'file|image',
            'url' => 'sometimes|url:http,https',
        ];
    }
    public function messages(): array
    {
        return [
            'nome.unique' => 'Este nome já está em uso.',
            'photo_url.file' => 'O campo logo deve ser um arquivo.',
            'photo_url.image' => 'O campo logo deve ser uma imagem.',
            'url.url' => 'O campo link deve ser um URL válido ou seja começar com http ou https.',
            'entidade_oficial.boolean' => 'O campo entidade oficial deve ser verdadeiro ou falso.'
        ];
    }
}
