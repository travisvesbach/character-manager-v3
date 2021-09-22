<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'counter_total'     => 'integer',
            'counter_type'      => 'max:255',
            'counter_slots'     => '',
            'counter_current'   => 'integer',
            'recover'           => '',
            'dice_count'        => 'integer',
            'dice_size'         => 'integer',
            'dice_modifier'     => 'integer',
        ];
    }
}
