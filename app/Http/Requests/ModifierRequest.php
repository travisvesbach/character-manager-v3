<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModifierRequest extends FormRequest
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
            'name'                  => 'required|max:255',
            'creature_id'           => 'required|integer',
            'creature_type'         => 'required|max:255',
            'ability'               => 'required_without:save,attack,critical_range,damage',
            'ability_dice'          => 'required_if:ability,1|nullable',
            'save'                  => 'required_without:ability,attack,critical_range,damage',
            'save_dice'             => 'required_if:save,1|nullable',
            'attack'                => 'required_without:ability,save,critical_range,damage',
            'attack_dice'           => 'required_if:attack,1|nullable',
            'critical_range'        => 'required_without:ability,save,attack,damage',
            'critical_range_start'  => 'required_if:critical_range,1|integer|nullable',
            'damage'                => 'required_without:ability,save,attack,critical_range',
            'damage_as'             => 'required_if:damage,1|max:255|nullable',
            'damage_dc'             => 'required_if:damage_as,save|integer|nullable',
            'damage_save'           => 'required_if:damage_as,save|max:255|nullable',
            'damage_dice'           => 'required_if:damage,1|nullable',
        ];
    }
}
