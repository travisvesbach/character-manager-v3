<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\DiceArray;

class ResourceRequest extends FormRequest
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
            'name'              => 'required|max:255',
            'creature_id'       => 'required|integer',
            'creature_type'     => 'required|max:255',
            'type'              => 'required|max:255',
            'counter_type'      => 'required_if:type,counter|max:255',
            'total'             => 'required_if:type,counter|integer|nullable',
            'current'           => 'integer|nullable',
            'slots'             => '',
            'recover'           => 'max:255',
            'dice'              => ['required_if:type,dice', 'nullable', new DiceArray($this->type == 'dice')],
        ];
    }
}
