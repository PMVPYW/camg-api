<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class HorarioFimMaiorQueInicioRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */

    protected $table;
    protected $column;
    protected $ignoreId;

    public function __construct($table, $column, $current_id = null)
    {
        $this->table = $table;
        $this->column = $column;
        $this->current_id = $current_id;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = DB::table($this->table)->where('id', $this->current_id);
        if ($query->count() != 1 || !($value > $query->first()->inicio)) {
            $fail("O :attribute deve ser maior que a data de inicio!");
        }
    }
}
