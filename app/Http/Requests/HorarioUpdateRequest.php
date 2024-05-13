<?php

namespace App\Http\Requests;

use App\Rules\HorarioFimMaiorQueInicioRule;
use Illuminate\Foundation\Http\FormRequest;

class HorarioUpdateRequest extends FormRequest
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
        $resourceId = $this->route('horario')->id;
        $rules = [
            "rally_id" => "exists:rallies,id",
            "titulo" => "string",
            "descricao" => "string",
            "inicio" => ["date", "before:fim"],
            "fim" => ["date", "after:inicio"],
        ];
        if ($this->has('fim')) {
            $rules["fim"][] = new HorarioFimMaiorQueInicioRule("horarios", "fim", $resourceId);
        }
        if ($this->has('inicio')) {
            $rules["inicio"][] = new HorarioFimMaiorQueInicioRule("horarios", "inicio", $resourceId);
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            "inicio.date" => "A data de inicio deve ser uma data!",
            "inicio.before" => "A data de inicio deve ser menor que a data de fim!",
            "fim.date" => "A data de fim deve ser uma data!",
            "fim.after" => "A data de fim deve ser maior que a data de inicio!"
        ];
    }
}
