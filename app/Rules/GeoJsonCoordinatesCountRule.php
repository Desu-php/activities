<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class GeoJsonCoordinatesCountRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, string): void  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $coordinates = $value['geojson']['features'][0]['geometry']['coordinates'] ?? null;

        if (!is_array($coordinates)) {
            $fail('Поле '.$attribute.' отсутствует или имеет неправильный формат.');
            return;
        }

        if (count($value['geojson']['features']) !== 1) {
            $fail('Поле '.$attribute.' должно содержать ровно один элемент.');
        }
    }
}
