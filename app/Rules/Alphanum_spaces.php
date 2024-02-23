<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class Alphanum_spaces implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (!preg_match('/^[a-zA-Z0-9ÑñÁáÉéÍíÓóÚúÜü\-,()\s]*$/', $value)) {
            $fail('The :attribute may only contain letters, numbers and spaces.');
        }
    }
}
