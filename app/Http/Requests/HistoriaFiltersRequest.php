<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoriaFiltersRequest extends FormRequest
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
            "search" => "nullable|string|min:0",
            "order" => "nullable|string|in:subtitulo_desc,subtitulo_asc,titulo_asc,titulo_desc"
        ];
    }
    public function messages(): array
    {
        return [
            'search.string' => 'O campo procurar deve ser um texto.',
            'search.min' => 'O campo procurar deve ter texto',
            'order.string' => 'O campo ordenar deve ser um texto.',
            'order.in' => 'O campo ordenar deve ser um dos seguintes valores: subtitulo_desc, subtitulo_asc, titulo_asc, titulo_desc.',
        ];
    }
}
