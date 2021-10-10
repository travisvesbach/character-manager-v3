<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\DiceArray;

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
            'ability'               => 'boolean',
            'ability_dice'          => ['required_if:ability,true', 'nullable', new DiceArray($this->ability)],
            'save'                  => 'boolean',
            'save_dice'             => ['required_if:save,true', 'nullable', new DiceArray($this->save)],
            'attack'                => 'boolean',
            'attack_dice'           => ['required_if:attack,true', 'nullable', new DiceArray($this->attack)],
            'critical_range'        => 'boolean',
            'critical_range_start'  => 'required_if:critical_range,true|integer|nullable',
            'damage'                => 'boolean',
            'damage_as'             => 'required_if:damage,true|max:255|nullable',
            'damage_dc'             => 'required_if:damage_as,save|integer|nullable',
            'damage_save'           => 'required_if:damage_as,save|max:255|nullable',
            'damage_dice'           => ['required_if:damage,true', 'nullable', new DiceArray($this->damage)],
            'notes'                 => 'nullable',
            'enabled'               => 'boolean',
        ];
    }
}
