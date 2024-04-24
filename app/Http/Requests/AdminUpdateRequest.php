<?php

namespace App\Http\Requests;

use App\Rules\UniqueUpdateRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AdminUpdateRequest extends FormRequest
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
        $resourceId = $this->route('admin')->id;
        return [
            "nome" => "sometimes|string",
            "email" => ["sometimes", "email:rfc,dns", new UniqueUpdateRule("users", 'email', $resourceId)],
            "password" => ["sometimes", "string", "confirmed", Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
            "old_password" => "required_with:password|current_password:sanctum",
            "photo_url" => "nullable|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
        ];
    }

    public function messages()
    {
        return [
            "nome.string" => "O campo nome deve ser uma string.",
            "email.email" => "O campo email deve ser um endereço de e-mail válido.",
            "password.string" => "O campo senha deve ser uma string.",
            "password.confirmed" => "A confirmação da senha não corresponde.",
            "password.min" => "A senha deve ter no mínimo :min caracteres.",
            "password.mixed" => "A senha deve conter caracteres maiúsculos e minúsculos.",
            "password.numbers" => "A senha deve conter números.",
            "password.symbols" => "A senha deve conter símbolos.",
            "password.uncompromised" => "A senha fornecida foi comprometida e não pode ser utilizada.",
            "photo_url.file" => "O campo foto deve ser um arquivo.",
            "photo_url.image" => "O campo foto deve ser uma imagem.",
            "photo_url.mimes" => "O campo foto deve ser um arquivo do tipo: :values.",
            "photo_url.max" => "O tamanho máximo permitido para a foto é de :max kilobytes.",
        ];
    }
}
