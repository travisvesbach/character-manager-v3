<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'max_hp' => 'required',
            'hit_dice' => '',
            'ac' => 'required|integer',
            'ac_source' => '',
            'initiative' => 'required|integer',
            'speed' => 'required|max:255',
            'strength' => 'required|integer',
            'strength_mod' => 'required|integer',
            'strength_save' => 'required|integer',
            'athletics' => 'required|integer',
            'dexterity' => 'required|integer',
            'dexterity_mod' => 'required|integer',
            'dexterity_save' => 'required|integer',
            'acrobatics' => 'required|integer',
            'sleight_of_hand' => 'required|integer',
            'stealth' => 'required|integer',
            'constitution' => 'required|integer',
            'constitution_mod' => 'required|integer',
            'constitution_save' => 'required|integer',
            'intelligence' => 'required|integer',
            'intelligence_mod' => 'required|integer',
            'intelligence_save' => 'required|integer',
            'arcana' => 'required|integer',
            'history' => 'required|integer',
            'investigation' => 'required|integer',
            'nature' => 'required|integer',
            'religion' => 'required|integer',
            'wisdom' => 'required|integer',
            'wisdom_mod' => 'required|integer',
            'wisdom_save' => 'required|integer',
            'animal_handling' => 'required|integer',
            'insight' => 'required|integer',
            'medicine' => 'required|integer',
            'perception' => 'required|integer',
            'survival' => 'required|integer',
            'charisma' => 'required|integer',
            'charisma_mod' => 'required|integer',
            'charisma_save' => 'required|integer',
            'deception' => 'required|integer',
            'intimidation' => 'required|integer',
            'performance' => 'required|integer',
            'persuasion' => 'required|integer',
            'skills' => '',
            'proficient_skills' => '',
            'expert_skills' => '',
            'special_skill_modifiers' => '',
            'actions' => '',
            'modifiers' => '',
            'spells' => '',
            'resources' => '',
            'notes' => '',
            'show_notepad' => 'required|boolean',
            'show_resources' => 'required|boolean',
            'show_spells' => 'required|boolean',
            'show_dice' => 'required|boolean',
        ];
    }
}
