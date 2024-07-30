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
            "nivel_afluencia" => "sometimes|in:Baixo,Médio,Alto",
            "facilidade_acesso" => "sometimes|in:Fácil,Médio,Difícil",
            "distancia_estacionamento" => "sometimes|integer",
            "coordenadas" => "sometimes|string|unique:zona_espetaculo,coordenadas,". $this->route('zonaEspetaculo')->id . ',id,prova_id,' . $this->input('prova_id'),
            "nivel_ocupacao" => "sometimes|in:Livre,Intermédio,Completo",
            "prova_id" => "sometimes|exists:prova,id",
            "info" => "nullable|string"
        ];
    }
    public function messages(): array
    {
        return [
            'nome.string' => 'O campo nome deve ser um texto.',
            'nome.unique' => 'O nome fornecido já está em uso para esta prova.',
            'nivel_afluencia.in' => 'O nível de afluência deve ser um dos seguintes valores: Baixo, Médio, Alto.',
            'facilidade_acesso.in' => 'A facilidade de acesso deve ser um dos seguintes valores: Fácil, Médio, Difícil.',
            'distancia_estacionamento.integer' => 'O campo distância ao estacionamento deve ser um número inteiro.',
            'coordenadas.string' => 'O campo coordenadas deve ser um texto.',
            'coordenadas.unique' => 'As coordenadas fornecidas já estão em uso para esta prova.',
            'nivel_ocupacao.in' => 'O nível de ocupação deve ser um dos seguintes valores: Livre, Intermédio, Completo.',
            'prova_id.exists' => 'A prova selecionada é inválida.',
            'info.string' => 'O campo coordenadas deve ser um texto.',

        ];
    }
}
