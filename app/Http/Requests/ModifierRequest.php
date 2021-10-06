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
            'ability_dice'          => ['required_unless:ability,false', 'nullable', new DiceArray($this->ability)],
            'save'                  => 'boolean',
            'save_dice'             => ['required_unless:save,false', 'nullable', new DiceArray($this->save)],
            'attack'                => 'boolean',
            'attack_dice'           => ['required_unless:attack,false', 'nullable', new DiceArray($this->attack)],
            'critical_range'        => 'boolean',
            'critical_range_start'  => 'required_unless:critical_range,false|integer|nullable',
            'damage'                => 'boolean',
            'damage_as'             => 'required_unless:damage,false|max:255|nullable',
            'damage_dc'             => 'required_if:damage_as,save|integer|nullable',
            'damage_save'           => 'required_if:damage_as,save|max:255|nullable',
            'damage_dice'           => ['required_unless:damage,false', 'nullable', new DiceArray($this->damage)],
            'enabled'               => 'boolean',
        ];
    }
}
