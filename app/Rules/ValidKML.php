<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidKML implements Rule
{
    public function passes($attribute, $value)
    {
        if ($value->getClientOriginalExtension() !== 'kml') {
            return false;
        }

        $content = file_get_contents($value->getRealPath());
        $xml = simplexml_load_string($content);

        return $xml !== false && $xml->getName() === 'kml';
    }

    public function message()
    {
        return 'O ficheiro deve ser um KML válido.';
    }
}
