<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RangeNoDuplicates implements Rule
{

    protected $required = true;
    protected $duplicates = [];

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
        $all_numbers = [];
        $counter = $value[0]['range'][0];
        foreach($value as $row) {
            foreach($row['range'] as $num) {
                if($num != null) {
                    if(in_array($num, $all_numbers)) {
                        array_push($this->duplicates, $num);
                    } else {
                        array_push($all_numbers, $num);
                    }
                    if($counter < $num) {
                        while($counter < $num) {
                            if(in_array($counter, $all_numbers)) {
                                array_push($this->duplicates, $counter);
                            } else {
                                array_push($all_numbers, $counter);
                            }
                            $counter++;
                        }
                    }
                    $counter++;
                }
            }
        }
        if(count($this->duplicates) > 0) {
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
        return 'Ranges can\'t have duplicate numbers: ' . implode(', ', $this->duplicates);
    }
}
