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
            "nivel_afluencia" => "required|in:Baixo,Médio,Alto",
            "facilidade_acesso" => "required|in:Fácil,Médio,Difícil",
            "distancia_estacionamento" => "required|integer",
            "coordenadas" => 'required|string|unique:zona_espetaculo,coordenadas,NULL,id,prova_id,' . $this->input('prova_id'),
            "nivel_ocupacao" => "required|in:Livre,Intermédio,Completo",
            "prova_id" => "required|exists:prova,id",
            "info" => "nullable|string"
        ];
    }
    public function messages(): array
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.string' => 'O campo nome deve ser uma string.',
            'nome.unique' => 'O nome fornecido já está em uso para esta prova.',

            'nivel_afluencia.required' => 'O campo nível de afluência é obrigatório.',
            'nivel_afluencia.in' => 'O nível de afluência deve ser um dos seguintes valores: Baixo, Médio, Alto.',

            'facilidade_acesso.required' => 'O campo facilidade de acesso é obrigatório.',
            'facilidade_acesso.in' => 'A facilidade de acesso deve ser um dos seguintes valores: Fácil, Médio, Difícil.',

            'distancia_estacionamento.required' => 'O campo distância ao estacionamento é obrigatório.',
            'distancia_estacionamento.integer' => 'O campo distância ao estacionamento deve ser um número inteiro.',

            'coordenadas.required' => 'O campo coordenadas é obrigatório.',
            'coordenadas.string' => 'O campo coordenadas deve ser uma string.',
            'coordenadas.unique' => 'As coordenadas fornecidas já estão em uso para esta prova.',

            'nivel_ocupacao.required' => 'O campo nível de ocupação é obrigatório.',
            'nivel_ocupacao.in' => 'O nível de ocupação deve ser um dos seguintes valores: Livre, Intermédio, Completo.',

            'prova_id.required' => 'O campo prova é obrigatório.',
            'prova_id.exists' => 'A prova selecionada é inválida.',

            'info.string' => 'O campo coordenadas deve ser uma string.',

        ];
    }
}
