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
            "nivel_afluencia" => "required|in:Fácil,Médio,Difícil",
            "facilidade_acesso" => "required|in:Fácil,Médio,Difícil",
            "distancia_estacionamento" => "required|integer",
            "coordenadas" => 'required|string|unique:zona_espetaculo,coordenadas,NULL,id,prova_id,' . $this->input('prova_id'),
            "nivel_ocupacao" => "required|in:Livre,Intermédio,Completo",
            "prova_id" => "required|exists:prova,id"
        ];
    }
}
