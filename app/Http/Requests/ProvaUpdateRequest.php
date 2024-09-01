<?php

namespace App\Http\Requests;

use App\Rules\HorarioJaTemProva;
use App\Rules\ValidKML;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Exists;

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
            "horario_id" => ["nullable", "integer", "exists:horarios,id", new HorarioJaTemProva($resourceId)], //implemented exists in HorarioJaTemProva because by some reason it just didnt work using exists:horarios,id
            "local" => "sometimes | string",
            "kml_src" => ["sometimes", "file", new ValidKML()],
        ];
    }
   /* public function messages(): array
    {
        return [
            'kml_src.file' => 'O kml deve ser um ficheiro.'
        ];
    }*/
}
