<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminsFiltersRequest extends FormRequest
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
            "order" => "nullable|string|in:nome_asc,nome_desc,most_recent,least_recent",
            "status" => "nullable|string|in:all,unblocked,blocked,unauthorized",
        ];
    }
    public function messages(): array
    {
        return [
            'search.string' => 'O campo procurar deve ser um texto.',
            'search.min' => 'O campo procurar deve ter texto.',
            'order.string' => 'O campo  ordem deve ser um texto.',
            'order.in' => 'O campo ordem deve conter um dos seguintes valores: nome_asc, nome_desc, most_recent, least_recent.',
            'status.string' => 'O campo estado deve ser um texto.',
            'status.in' => 'O campo estado deve conter um dos seguintes valores: all, unblocked, blocked, unauthorized.',
        ];
    }
}
