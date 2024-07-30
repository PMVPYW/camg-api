<?php

namespace App\Http\Requests;

use App\Rules\UniqueUpdateRule;
use Illuminate\Foundation\Http\FormRequest;

class HistoriaUpdateRequest extends FormRequest
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
        $id = $this->route('historia')->id;
        return [
            "titulo" => ["sometimes","string","min:0",new UniqueUpdateRule("historia", "titulo", $id)],
            "subtitulo" => "sometimes|string|min:0",
            "conteudo" => "sometimes|string|nullable|",
            "photo_url" => "sometimes|nullable|file|image"
        ];
    }
    public function messages(): array
    {
        return [
            'titulo.string' => 'O campo título deve ser um texto.',
            'titulo.min' => 'O campo título deve ter texto.',
            'subtitulo.string' => 'O campo subtítulo deve ser um texto.',
            'subtitulo.min' => 'O campo subtítulo deve ter texto.',
            'conteudo.string' => 'O campo conteúdo deve ser um texto.',
            'photo_url.file' => 'O campo imagem deve ser um arquivo.',
            'photo_url.image' => 'O campo deve ser uma imagem.',
        ];
    }
}
