<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Filter implements Rule
{
    protected $words;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($words)
    {
        //
        $this->words = $words;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
//        return !(strtolower($value)==$this->word);
        return !(in_array(strtolower($value),$this->words));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This value is Forbidden!';
    }
}
