<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZonaEspetaculoRequest extends FormRequest
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

            "nome" => 'required|string|unique:zona_espetaculo,nome,NULL,id,prova_id,' . $this->input('prova_id'),
            "nivel_afluencia" => "required|in:facil,medio,dificil",
            "facilidade_acesso" => "required|in:facil,medio,dificil",
            "distancia_estacionamento" => "required|integer",
            "coordenadas" => 'required|string|unique:zona_espetaculo,coordenadas,NULL,id,prova_id,' . $this->input('prova_id'),
            "prova_id" => "required|exists:prova,id"
        ];
    }
}
