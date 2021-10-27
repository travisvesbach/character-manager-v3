<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RowNotEmpty implements Rule
{

    protected $required = true;
    protected $message = null;

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
        foreach($value as $row) {
            if(!isset($row['range'][0]) || $row['range'][0] == null) {
                $this->message = 'Range start cannot be empty.';
                return false;
            }
            if(!isset($row['result']) || $row['result'] == null) {
                $this->message = 'Result cannot be empty.';
                return false;
            }
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
        return $this->message;
    }
}
