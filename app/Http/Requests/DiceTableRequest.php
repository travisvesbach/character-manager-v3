<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\RangeStartsWithOne;
use App\Rules\RangeInOrder;
use App\Rules\RangeNotSkipNumbers;
use App\Rules\RowNotEmpty;
use App\Rules\RangeNoDuplicates;

class DiceTableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required|max:255',
            'rows'      => [
                'bail',
                'required',
                new RowNotEmpty($this->input('rows')),
                new RangeStartsWithOne($this->input('rows')),
                new RangeNoDuplicates($this->input('rows')),
                new RangeInOrder($this->input('rows')),
                new RangeNotSkipNumbers($this->input('rows')),
            ],
            'public'    => 'required|boolean',
        ];
    }
}
