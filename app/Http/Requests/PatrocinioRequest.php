<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatrocinioRequest extends FormRequest
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
            "rally_id" => "required | integer |exists:rallies,id",
            "entidade_id" => "required | integer |exists:entidades,id",
        ];
    }
}
