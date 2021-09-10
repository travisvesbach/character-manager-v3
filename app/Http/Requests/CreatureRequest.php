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
            'name' => 'required',
            'max_hp' => 'required|integer',
            'hit_dice' => '',
            'ac' => 'required|integer',
            'ac_source' => 'max:255',
            'initiative' => 'required|integer',
            'speed' => 'required|max:255',
            'strength' => 'required|integer',
            'strength_mod' => 'required|integer',
            'strength_save' => 'required|integer',
            'strength_save_proficiency' => 'required|boolean',
            'athletics' => 'required|boolean',
            'athletics_proficiency' => 'required|boolean',
            'athletics_expertise' => 'required|boolean',
            'dexterity' => 'required|integer',
            'dexterity_proficiency' => 'required|boolean',
            'dexterity_expertise' => 'required|boolean',
            'dexterity_mod' => 'required|integer',
            'dexterity_save' => 'required|integer',
            'dexterity_save_proficiency' => 'required|boolean',
            'acrobatics' => 'required|boolean',
            'acrobatics_proficiency' => 'required|boolean',
            'acrobatics_expertise' => 'required|boolean',
            'sleight_of_hand' => 'required|integer',
            'sleight_of_hand_proficiency' => 'required|boolean',
            'sleight_of_hand_expertise' => 'required|boolean',
            'stealth' => 'required|integer',
            'stealth_proficiency' => 'required|boolean',
            'stealth_expertise' => 'required|boolean',
            'constitution' => 'required|integer',
            'constitution_proficiency' => 'required|boolean',
            'constitution_expertise' => 'required|boolean',
            'constitution_mod' => 'required|integer',
            'constitution_save' => 'required|integer',
            'constitution_save_proficiency' => 'required|boolean',
            'intelligence' => 'required|boolean',
            'intelligence_proficiency' => 'required|boolean',
            'intelligence_expertise' => 'required|boolean',
            'intelligence_mod' => 'required|integer',
            'intelligence_save' => 'required|integer',
            'intelligence_save_proficiency' => 'required|boolean',
            'arcana' => 'required|boolean',
            'arcana_proficiency' => 'required|boolean',
            'arcana_expertise' => 'required|boolean',
            'history' => 'required|integer',
            'history_proficiency' => 'required|boolean',
            'history_expertise' => 'required|boolean',
            'investigation' => 'required|integer',
            'investigation_proficiency' => 'required|boolean',
            'investigation_expertise' => 'required|boolean',
            'nature' => 'required|integer',
            'nature_proficiency' => 'required|boolean',
            'nature_expertise' => 'required|boolean',
            'religion' => 'required|integer',
            'religion_proficiency' => 'required|boolean',
            'religion_expertise' => 'required|boolean',
            'wisdom' => 'required|integer',
            'wisdom_proficiency' => 'required|boolean',
            'wisdom_expertise' => 'required|boolean',
            'wisdom_mod' => 'required|integer',
            'wisdom_save' => 'required|integer',
            'wisdom_save_proficiency' => 'required|boolean',
            'animal_handling' => 'required|boolean',
            'animal_handling_proficiency' => 'required|boolean',
            'animal_handling_expertise' => 'required|boolean',
            'insight' => 'required|integer',
            'insight_proficiency' => 'required|boolean',
            'insight_expertise' => 'required|boolean',
            'medicine' => 'required|integer',
            'medicine_proficiency' => 'required|boolean',
            'medicine_expertise' => 'required|boolean',
            'perception' => 'required|integer',
            'perception_proficiency' => 'required|boolean',
            'perception_expertise' => 'required|boolean',
            'survival' => 'required|integer',
            'survival_proficiency' => 'required|boolean',
            'survival_expertise' => 'required|boolean',
            'charisma' => 'required|integer',
            'charisma_proficiency' => 'required|boolean',
            'charisma_expertise' => 'required|boolean',
            'charisma_mod' => 'required|integer',
            'charisma_save' => 'required|integer',
            'charisma_save_proficiency' => 'required|boolean',
            'deception' => 'required|boolean',
            'deception_proficiency' => 'required|boolean',
            'deception_expertise' => 'required|boolean',
            'intimidation' => 'required|integer',
            'intimidation_proficiency' => 'required|boolean',
            'intimidation_expertise' => 'required|boolean',
            'performance' => 'required|integer',
            'performance_proficiency' => 'required|boolean',
            'performance_expertise' => 'required|boolean',
            'persuasion' => 'required|integer',
            'persuasion_proficiency' => 'required|boolean',
            'persuasion_expertise' => 'required|boolean',
            'skills_auto_filled' => 'boolean',
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
