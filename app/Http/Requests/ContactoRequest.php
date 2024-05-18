<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactoRequest extends FormRequest
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
            "nome" => "required|string",
            "tipo_valor" => "required|in:Email,Telemovel,Telefone,Fax,Facebook,Instagram,Twitter,PaginaWeb,WhatsApp,Morada,Coordenadas",
            "valor" => "required|string",
            "tipocontacto_id" => "required|integer|exists:tipo_contacto,id"
        ];
    }

    public function withValidator($validator): void
    {
        $validator->sometimes('valor', 'max:9', function ($input) {
            return in_array($input->tipo_valor, ['Telemovel', 'Telefone']);
        });
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.string' => 'O campo nome deve ser uma string.',
            'tipo_valor.required' => 'O campo tipo_valor é obrigatório.',
            'tipo_valor.in' => 'O campo tipo_valor deve ser um dos seguintes valores: Email, Telemovel, Telefone, Fax, Facebook, Instagram, Twitter, PaginaWeb, WhatsApp, Morada, Coordenadas.',
            'valor.required' => 'O campo valor é obrigatório.',
            'valor.string' => 'O campo valor deve ser uma string.',
            'valor.max' => 'O campo valor não pode ter mais que 9 caracteres quando do tipo Telemóvel ou Telefone.',
            'tipocontacto_id.required' => 'O campo tipocontacto_id é obrigatório.',
            'tipocontacto_id.integer' => 'O campo tipocontacto_id deve ser um número inteiro.',
            'tipocontacto_id.exists' => 'O tipocontacto_id fornecido não existe na tabela tipo_contacto.',
        ];
    }
}
