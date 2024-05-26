<?php

namespace App\Rules;

use App\Models\Horario;
use App\Models\Prova;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class HorarioJaTemProva implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */

    protected $ignoreId;

    public function __construct($ignoreId = null)
    {
        $this->ignoreId = $ignoreId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = Prova::where('horario_id', $value)->wherenot('id', $this->ignoreId)->get();
        if ($query->count() > 0) {
            $fail("Este horário já tem uma prova associada!");
        }
    }
}
