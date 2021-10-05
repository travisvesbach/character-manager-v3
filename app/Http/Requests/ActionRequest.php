<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\DiceArray;

class ActionRequest extends FormRequest
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
            'type'                  => 'required|max:255',
            'range'                 => 'required|max:255',
            'notes'                 => 'nullable',
            'attack'                => 'required_without:save,auto|boolean',
            'attack_modifier'       => 'required_if:save,true|integer|nullable',
            'attack_does_damage'    => 'required_if:attack,true|boolean|nullable',
            'attack_dice'           => ['required_unless:attack,false', 'nullable', new DiceArray($this->attack)],
            'save'                  => 'required_without:attack,auto|boolean',
            'save_type'             => 'required_if:save,true|max:255|nullable',
            'save_dc'               => 'required_if:save,true|integer|nullable',
            'save_does_damage'      => 'required_if:save,true|boolean|nullable',
            'save_dice'             => ['required_unless:save,false', 'nullable', new DiceArray($this->save)],
            'auto'                  => 'required_without:attack,save|boolean',
            'auto_does_damage'      => 'required_if:auto,true|boolean|nullable',
            'auto_dice'             => ['required_unless:auto,false', 'nullable', new DiceArray($this->auto)],
        ];
    }
}
