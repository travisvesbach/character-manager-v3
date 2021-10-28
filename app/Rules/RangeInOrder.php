<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RangeInOrder implements Rule
{

    protected $required = true;
    protected $missing = [];

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
        $counter = $value[0]['range'][0];
        foreach($value as $row) {
            foreach($row['range'] as $index => $num) {
                if($num && $counter <= $num) {
                    if($counter < $num && $index == 0) {
                        while($counter != $num) {
                            array_push($this->missing, $counter);
                            $counter++;
                        }
                    } else {
                        $counter = $num;
                    }
                    $counter++;
                }
            }
        }
        if(count($this->missing) > 0) {
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
        return 'Ranges numbers are missing or out of order: ' . implode(', ', $this->missing);
    }
}
