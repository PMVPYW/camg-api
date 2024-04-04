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
            "search" => "sometimes|string|min:0",
            "data_inicio" => "sometimes|date",
            "data_fim" => "sometimes|date",
            "status" => "sometimes|string|in:not_started,on_going,terminated",
            "order" => "sometimes|string|in:proximity,date_desc,date_asc"
        ];
    }
}
