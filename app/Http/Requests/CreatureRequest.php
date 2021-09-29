<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\DiceArray;

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
            'name'                          => 'required',
            'hp_max'                        => 'required|integer',
            'hp_current'                    => 'nullable|integer',
            'hp_temp'                       => 'nullable|integer',
            'hit_dice'                      => ['nullable', new DiceArray],
            'ac'                            => 'required|integer',
            'ac_source'                     => 'nullable|max:255',
            'initiative'                    => 'required|integer',
            'speed'                         => 'required|max:255',
            'strength'                      => 'required|integer',
            'strength_mod'                  => 'required|integer',
            'strength_save'                 => 'required|integer',
            'strength_save_proficiency'     => 'boolean',
            'athletics'                     => 'required|integer',
            'athletics_proficiency'         => 'boolean',
            'athletics_expertise'           => 'boolean',
            'dexterity'                     => 'required|integer',
            'dexterity_mod'                 => 'required|integer',
            'dexterity_save'                => 'required|integer',
            'dexterity_save_proficiency'    => 'boolean',
            'acrobatics'                    => 'required|integer',
            'acrobatics_proficiency'        => 'boolean',
            'acrobatics_expertise'          => 'boolean',
            'sleight_of_hand'               => 'required|integer',
            'sleight_of_hand_proficiency'   => 'boolean',
            'sleight_of_hand_expertise'     => 'boolean',
            'stealth'                       => 'required|integer',
            'stealth_proficiency'           => 'boolean',
            'stealth_expertise'             => 'boolean',
            'constitution'                  => 'required|integer',
            'constitution_mod'              => 'required|integer',
            'constitution_save'             => 'required|integer',
            'constitution_save_proficiency' => 'boolean',
            'intelligence'                  => 'required|integer',
            'intelligence_mod'              => 'required|integer',
            'intelligence_save'             => 'required|integer',
            'intelligence_save_proficiency' => 'boolean',
            'arcana'                        => 'required|integer',
            'arcana_proficiency'            => 'boolean',
            'arcana_expertise'              => 'boolean',
            'history'                       => 'required|integer',
            'history_proficiency'           => 'boolean',
            'history_expertise'             => 'boolean',
            'investigation'                 => 'required|integer',
            'investigation_proficiency'     => 'boolean',
            'investigation_expertise'       => 'boolean',
            'nature'                        => 'required|integer',
            'nature_proficiency'            => 'boolean',
            'nature_expertise'              => 'boolean',
            'religion'                      => 'required|integer',
            'religion_proficiency'          => 'boolean',
            'religion_expertise'            => 'boolean',
            'wisdom'                        => 'required|integer',
            'wisdom_mod'                    => 'required|integer',
            'wisdom_save'                   => 'required|integer',
            'wisdom_save_proficiency'       => 'boolean',
            'animal_handling'               => 'required|integer',
            'animal_handling_proficiency'   => 'boolean',
            'animal_handling_expertise'     => 'boolean',
            'insight'                       => 'required|integer',
            'insight_proficiency'           => 'boolean',
            'insight_expertise'             => 'boolean',
            'medicine'                      => 'required|integer',
            'medicine_proficiency'          => 'boolean',
            'medicine_expertise'            => 'boolean',
            'perception'                    => 'required|integer',
            'perception_proficiency'        => 'boolean',
            'perception_expertise'          => 'boolean',
            'survival'                      => 'required|integer',
            'survival_proficiency'          => 'boolean',
            'survival_expertise'            => 'boolean',
            'charisma'                      => 'required|integer',
            'charisma_mod'                  => 'required|integer',
            'charisma_save'                 => 'required|integer',
            'charisma_save_proficiency'     => 'boolean',
            'deception'                     => 'required|integer',
            'deception_proficiency'         => 'boolean',
            'deception_expertise'           => 'boolean',
            'intimidation'                  => 'required|integer',
            'intimidation_proficiency'      => 'boolean',
            'intimidation_expertise'        => 'boolean',
            'performance'                   => 'required|integer',
            'performance_proficiency'       => 'boolean',
            'performance_expertise'         => 'boolean',
            'persuasion'                    => 'required|integer',
            'persuasion_proficiency'        => 'boolean',
            'persuasion_expertise'          => 'boolean',
            'skills_auto_filled'            => 'boolean',
            'actions'                       => '',
            'modifiers'                     => '',
            'spellcaster'                   => 'required|boolean',
            'spell_type'                    => 'nullable|max:255',
            'spell_dc'                      => 'nullable|integer',
            'spell_level'                   => 'nullable|integer',
            'spell_points_max'              => 'nullable|integer',
            'spell_points_current'          => 'nullable|integer',
            'spell_recover'                 => 'nullable|max:255',
            'spell_list_type'               => 'nullable|max:255',
            'spell_slots_1'                 => '',
            'spell_slots_2'                 => '',
            'spell_slots_3'                 => '',
            'spell_slots_4'                 => '',
            'spell_slots_5'                 => '',
            'spell_slots_6'                 => '',
            'spell_slots_7'                 => '',
            'spell_slots_8'                 => '',
            'spell_slots_9'                 => '',
            'spell_list_0'                  => '',
            'spell_list_1'                  => '',
            'spell_list_2'                  => '',
            'spell_list_3'                  => '',
            'spell_list_4'                  => '',
            'spell_list_5'                  => '',
            'spell_list_6'                  => '',
            'spell_list_7'                  => '',
            'spell_list_8'                  => '',
            'spell_list_9'                  => '',
            'spell_prepare_count'           => 'nullable|integer',
            'spell_prepared'                => '',
            'spell_counters'                => '',
            'notes'                         => '',
            'show_notepad'                  => 'boolean',
            'show_resources'                => 'boolean',
            'show_spells'                   => 'boolean',
        ];
    }
}
