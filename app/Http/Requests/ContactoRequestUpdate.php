<?php

namespace App\Http\Requests;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            "nome" => ["sometimes", "string", Rule::unique('contactos')->where(fn (Builder $query) => $query->where('tipocontacto_id', $this->input('tipocontacto_id')))->ignore($this->route('contacto')->id)],
            "tipo_valor" => "sometimes|in:Email,Telemovel,Telefone,Fax,Facebook,Instagram,Twitter,PaginaWeb,WhatsApp,Morada,Coordenadas",
            "valor" => "sometimes|string",
            "tipocontacto_id" => "sometimes|integer|exists:tipo_contacto,id"
        ];
    }
    public function withValidator($validator): void
    {
        if ($this->filled('tipo_valor')) {
            $validator->sometimes('valor', 'max:9', function ($input) {
                return in_array($input->tipo_valor, ['Telemovel', 'Telefone']);
            });

            $validator->sometimes('valor', 'email:rfc,dns', function ($input) {
                return in_array($input->tipo_valor, ['Email']);
            });
        }else{
            $validator->sometimes('valor', 'max:9', function () {
                return in_array(request()->route('contacto')->tipo_valor, ['Telemovel', 'Telefone']);
            });

            $validator->sometimes('valor', 'email:rfc,dns', function () {
                return in_array(request()->route('contacto')->tipo_valor, ['Email']);
            });
        }
    }

    public function messages(): array
    {
        return [
            'nome.string' => 'O campo nome deve ser uma string.',
            'tipo_valor.in' => 'O campo tipo deve ser um dos seguintes valores: Email, Telemovel, Telefone, Fax, Facebook, Instagram, Twitter, PaginaWeb, WhatsApp, Morada, Coordenadas.',
            "nome.unique" => 'O nome deve ser unico dentro do tipo de contacto.',
            'valor.string' => 'O campo valor deve ser uma string.',
            'valor.max' => 'O campo valor não pode ter mais que 9 caracteres quando do tipo Telemóvel ou Telefone.',
            'valor.email' => 'O campo valor não é um email válido',
            'tipocontacto_id.integer' => 'O campo tipo de contacto deve ser um número inteiro.',
            'tipocontacto_id.exists' => 'O tipo de contacto fornecido não existe na tabela tipo_contacto.',
        ];
    }
}
