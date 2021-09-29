<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DiceArray implements Rule
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
        foreach($value as $dice) {
            if(isset($dice['count']) && $dice['count'] > 0) {
                if(isset($dice['size']) && $dice['size'] > 0) {
                    continue;
                } else if(isset($dice['size']) && $dice['size'] == 0) {
                    return false;
                }
            }

            if(isset($dice['size']) && $dice['size'] > 0 && isset($dice['count']) && $dice['count'] <= 0) {
                return false;
            }


            if(isset($dice['modifier']) && $dice['modifier'] != 0) {
                continue;
            }
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
        return 'Dice input is not valid.';
    }
}
