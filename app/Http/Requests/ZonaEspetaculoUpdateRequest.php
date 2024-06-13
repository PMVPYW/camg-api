<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZonaEspetaculoUpdateRequest extends FormRequest
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
            "nome" => "sometimes|string|unique:zona_espetaculo,nome,". $this->route('zonaEspetaculo')->id . ',id,prova_id,' . $this->input('prova_id'),
            "nivel_afluencia" => "sometimes|in:Fácil,Médio,Difícil",
            "facilidade_acesso" => "sometimes|in:Fácil,Médio,Difícil",
            "distancia_estacionamento" => "sometimes|integer",
            "coordenadas" => "sometimes|string|unique:zona_espetaculo,coordenadas,". $this->route('zonaEspetaculo')->id . ',id,prova_id,' . $this->input('prova_id'),
            "nivel_ocupacao" => "sometimes|in:Livre,Intermédio,Completo",
            "prova_id" => "sometimes|exists:prova,id"
        ];
    }
}
