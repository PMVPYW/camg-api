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
        //    protected $fillable = ["rally_id","external_id","local","distancia_percurso","data_inicio","nome"];
        return [
            "data_inicio" => "sometimes|date",
            "rally_id" => "required | integer |exists:rallies,id",
            "external_id" => "required | integer",
            "local" => "required | string",
            "distancia_percurso" => "required | integer",
            "nome" => "required | string",
        ];
    }
}
