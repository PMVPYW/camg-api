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
            "descricao" => "required|string|max:255",
            "img_conselho" => "required|file|image",
            "erro" => "required|string|max:255",
            "img_erro" => "required|file|image"
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'descricao.required' => 'A descrição é obrigatória.',
            'descricao.string' => 'A descrição deve ser um texto.',
            'descricao.max' => 'A descrição não pode ter mais do que 255 caracteres.',
            'img_conselho.required' => 'A imagem do conselho é obrigatória.',
            'img_conselho.file' => 'A imagem do conselho deve ser um ficheiro.',
            'img_conselho.image' => 'A imagem do conselho deve ser uma imagem.',
            'erro.required' => 'O erro é obrigatório.',
            'erro.string' => 'O erro deve ser um texto.',
            'erro.max' => 'O erro não pode ter mais do que 255 caracteres.',
            'img_erro.required' => 'A imagem do erro é obrigatória.',
            'img_erro.file' => 'A imagem do erro deve ser um ficheiro.',
            'img_erro.image' => 'A imagem do erro deve ser uma imagem.',
        ];
    }
}
