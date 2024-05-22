<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactoRequestUpdate extends FormRequest
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
            "nome" => "sometimes|string",
            "tipo_valor" => "sometimes|in:Email,Telemovel,Telefone,Fax,Facebook,Instagram,Twitter,PaginaWeb,WhatsApp,Morada,Coordenadas",
            "valor" => "sometimes|string",
            "tipocontacto_id" => "sometimes|integer|exists:tipo_contacto,id"
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
            'nome.string' => 'O campo nome deve ser uma string.',
            'tipo_valor.in' => 'O campo tipo deve ser um dos seguintes valores: Email, Telemovel, Telefone, Fax, Facebook, Instagram, Twitter, PaginaWeb, WhatsApp, Morada, Coordenadas.',
            'valor.string' => 'O campo valor deve ser uma string.',
            'valor.max' => 'O campo valor não pode ter mais que 9 caracteres quando do tipo Telemóvel ou Telefone.',
            'tipocontacto_id.integer' => 'O campo tipo de contacto deve ser um número inteiro.',
            'tipocontacto_id.exists' => 'O tipo de contacto fornecido não existe na tabela tipo_contacto.',
        ];
    }
}
