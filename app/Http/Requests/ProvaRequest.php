<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProvaRequest extends FormRequest
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
        //    protected $fillable = ["rally_id","external_id","local","distancia_percurso","horario_id","nome"];
        return [
            "horario_id" => "nullable| integer |exists:horarios,id",
            "rally_id" => "required | integer |exists:rallies,id",
            "external_id" => "required | integer",
            "local" => "required | string",
            "distancia_percurso" => "required | integer",
            "nome" => "required | string",
        ];
    }
    public function messages(): array
    {
        return [
            'horario_id.integer' => 'O campo horario_id deve ser um número inteiro.',
            'horario_id.exists' => 'O horario_id fornecido não existe na tabela horários.',
            'rally_id.required' => 'O campo rally_id é obrigatório.',
            'rally_id.integer' => 'O campo rally_id deve ser um número inteiro.',
            'rally_id.exists' => 'O rally_id fornecido não existe na tabela rallies.',
            'external_id.required' => 'O campo external_id é obrigatório.',
            'external_id.integer' => 'O campo external_id deve ser um número inteiro.',
            'local.required' => 'O campo local é obrigatório.',
            'local.string' => 'O campo local deve ser uma string.',
            'distancia_percurso.required' => 'O campo distancia_percurso é obrigatório.',
            'distancia_percurso.integer' => 'O campo distancia_percurso deve ser um número inteiro.',
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.string' => 'O campo nome deve ser uma string.',
        ];
    }
}
