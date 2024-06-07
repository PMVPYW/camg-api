<?php

namespace App\Http\Requests;

use App\Rules\HorarioJaTemProva;
use Illuminate\Foundation\Http\FormRequest;

class ProvaUpdateRequest extends FormRequest
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
        $resourceId = $this->route('prova')->id;
        return [
            "horario_id" => ["sometimes", "integer", "exists:horarios,id", new HorarioJaTemProva($resourceId)],
            "local" => "sometimes | string",
            "nome" => "sometimes | string",
        ];
    }
}
