<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RallyFiltersRequest extends FormRequest
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
            "data_inicio" => "nullable|date",
            "data_fim" => "nullable|date",
            "status" => "nullable|string|in:all,not_started,on_going,terminated",
            "order" => "nullable|string|in:proximity,date_desc,date_asc"
        ];
    }
    public function messages(): array
    {
        return [
            'search.string' => 'O campo pesquisa deve ser um texto.',
            'search.min' => 'O campo pesquisa deve ter texto.',

            'data_inicio.date' => 'O campo data_inicio deve ser uma data válida.',

            'data_fim.date' => 'O campo data_fim deve ser uma data válida.',

            'status.string' => 'O campo status deve ser um texto.',
            'status.in' => 'O campo status deve ser um dos seguintes valores: all, not_started, on_going, terminated.',

            'order.string' => 'O campo ordem deve ser um texto.',
            'order.in' => 'O campo ordem deve ter um dos seguintes valores: proximity, date_desc, date_asc.',
        ];
    }
}
