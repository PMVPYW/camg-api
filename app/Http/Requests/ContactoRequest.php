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
}
