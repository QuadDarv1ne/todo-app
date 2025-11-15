<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Carbon\Carbon;

class NotPastDate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value) {
            return; // Если значение пустое, пропускаем проверку
        }

        try {
            $date = Carbon::parse($value)->startOfDay();
            $today = Carbon::today();

            if ($date->lt($today)) {
                $fail('Дата выполнения не может быть в прошлом.');
            }
        } catch (\Exception $e) {
            $fail('Некорректный формат даты.');
        }
    }
}
