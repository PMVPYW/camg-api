<?php

namespace App\Http\Requests;

use App\Rules\UniqueUpdateRule;
use Illuminate\Foundation\Http\FormRequest;

class TipoContactoRequestUpdate extends FormRequest
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
        $id = $this->route('tipocontacto')->id;
        return [
            "nome" => ["sometimes", "string", new UniqueUpdateRule("tipo_contacto", 'nome', $id)]
        ];
    }

    public function messages(): array
    {
        return [
            "nome.string" => "O campo nome deve ser um texto.",
            "nome.unique" => "Este nome já está em uso."
        ];
    }
}
