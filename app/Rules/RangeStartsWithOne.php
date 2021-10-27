<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RangeStartsWithOne implements Rule
{

    protected $required = true;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($required = true)
    {
        $this->required = $required;
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
        if(!$this->required) {
            return true;
        }
        if($value[0]['range'][0] != 1) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Range doesn\'t start with 1.';
    }
}
