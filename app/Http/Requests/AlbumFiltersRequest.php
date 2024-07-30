<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AlbumFiltersRequest extends FormRequest
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
            "rally_id" => "string|nullable",
            "search" => "string|nullable",
        ];
    }
    public function messages(): array
    {
        return [
            'rally_id.string' => 'O campo rally_id deve ser um texto',
            'search.string' => 'O campo procurar deve ser um texto.',
        ];
    }
}
