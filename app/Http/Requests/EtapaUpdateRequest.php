<?php

namespace App\Http\Requests;

use App\Rules\UniqueUpdateRule;
use Illuminate\Foundation\Http\FormRequest;

class EtapaUpdateRequest extends FormRequest
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
         $id = $this->route('etapa')->id;
         return [
             "capitulo_id" => "integer|sometimes|nullable|exists:capitulo,id",
             "nome" => ["sometimes","string","min:0",new UniqueUpdateRule("etapa", "nome", $id)],
             "ano_inicio" => "sometimes|integer|digits:4|lte:ano_fim",
             "ano_fim" => "sometimes|nullable|integer|digits:4|gte:ano_inicio",
        ];
    }

    public static function rulesArray(): array
    {
        return [
            "nome" => "sometimes|string|min:0",
        ];
    }
}
