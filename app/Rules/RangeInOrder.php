<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RangeInOrder implements Rule
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
        $next = 1;
        foreach($value as $row) {
            if($row['range'][0] != $next) {
                return false;
            }
            if($row['range'][0] != null && isset($row['range'][1]) && $row['range'][1] != null && $row['range'][0] > $row['range'][1]) {
                return false;
            }
            $next = (isset($row['range'][1]) ? $row['range'][1] : $row['range'][0]) + 1;
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
        return 'A range\'s start can\'t be greater than its end.';
    }
}
