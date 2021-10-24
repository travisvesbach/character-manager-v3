<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Resource;
use App\Models\Modifier;
use App\Models\Action;

class Creature extends Model
{

    protected $fillable = [
        'user_id',
        'name',
        'hp_max',
        'hp_current',
        'hp_temp',
        'hit_dice',
        'ac',
        'ac_source',
        'initiative',
        'speed',
        'strength',
        'strength_mod',
        'strength_save',
        'strength_save_proficiency',
        'athletics',
        'athletics_proficiency',
        'athletics_expertise',
        'dexterity',
        'dexterity_mod',
        'dexterity_save',
        'dexterity_save_proficiency',
        'acrobatics',
        'acrobatics_proficiency',
        'acrobatics_expertise',
        'sleight_of_hand',
        'sleight_of_hand_proficiency',
        'sleight_of_hand_expertise',
        'stealth',
        'stealth_proficiency',
        'stealth_expertise',
        'constitution',
        'constitution_mod',
        'constitution_save',
        'constitution_save_proficiency',
        'intelligence',
        'intelligence_mod',
        'intelligence_save',
        'intelligence_save_proficiency',
        'arcana',
        'arcana_proficiency',
        'arcana_expertise',
        'history',
        'history_proficiency',
        'history_expertise',
        'investigation',
        'investigation_proficiency',
        'investigation_expertise',
        'nature',
        'nature_proficiency',
        'nature_expertise',
        'religion',
        'religion_proficiency',
        'religion_expertise',
        'wisdom',
        'wisdom_mod',
        'wisdom_save',
        'wisdom_save_proficiency',
        'animal_handling',
        'animal_handling_proficiency',
        'animal_handling_expertise',
        'insight',
        'insight_proficiency',
        'insight_expertise',
        'medicine',
        'medicine_proficiency',
        'medicine_expertise',
        'perception',
        'perception_proficiency',
        'perception_expertise',
        'survival',
        'survival_proficiency',
        'survival_expertise',
        'charisma',
        'charisma_mod',
        'charisma_save',
        'charisma_save_proficiency',
        'deception',
        'deception_proficiency',
        'deception_expertise',
        'intimidation',
        'intimidation_proficiency',
        'intimidation_expertise',
        'performance',
        'performance_proficiency',
        'performance_expertise',
        'persuasion',
        'persuasion_proficiency',
        'persuasion_expertise',
        'skill_modifiers',
        'spellcaster',
        'spell_type',
        'spell_dc',
        'spell_level',
        'spell_points_max',
        'spell_points_current',
        'spell_recover',
        'spell_list_type',
        'spell_slots_1',
        'spell_slots_2',
        'spell_slots_3',
        'spell_slots_4',
        'spell_slots_5',
        'spell_slots_6',
        'spell_slots_7',
        'spell_slots_8',
        'spell_slots_9',
        'spell_list_0',
        'spell_list_1',
        'spell_list_2',
        'spell_list_3',
        'spell_list_4',
        'spell_list_5',
        'spell_list_6',
        'spell_list_7',
        'spell_list_8',
        'spell_list_9',
        'spell_prepare_count',
        'spell_prepared',
        'notes',
        'show_resources',
        'show_modifiers',
        'show_notes',
        'show_dice',
        'show_additional_stats',
        'show_temp_hp',
        'skills_auto_filled',
        'damage_vulnerabilities',
        'damage_resistances',
        'damage_immunities',
        'condition_immunities',
        'languages',
        'senses',
    ];

    protected $casts = [
        'hit_dice'                  => 'array',
        'skill_modifiers'           => 'array',
        'spell_slots_1'             => 'array',
        'spell_slots_2'             => 'array',
        'spell_slots_3'             => 'array',
        'spell_slots_4'             => 'array',
        'spell_slots_5'             => 'array',
        'spell_slots_6'             => 'array',
        'spell_slots_7'             => 'array',
        'spell_slots_8'             => 'array',
        'spell_slots_9'             => 'array',
        'spell_list_0'              => 'array',
        'spell_list_1'              => 'array',
        'spell_list_2'              => 'array',
        'spell_list_3'              => 'array',
        'spell_list_4'              => 'array',
        'spell_list_5'              => 'array',
        'spell_list_6'              => 'array',
        'spell_list_7'              => 'array',
        'spell_list_8'              => 'array',
        'spell_list_9'              => 'array',
        'spell_prepared'            => 'array',
    ];


    protected $appends = [
        'display_name',
    ];

    protected static function boot() {
        parent::boot();

        static::deleting(function($creature) {
            $creature->resources()->delete();
            $creature->modifiers()->delete();
            $creature->actions()->delete();
        });
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function resources() {
        return $this->morphMany(Resource::class, 'creature');
    }

    public function modifiers() {
        return $this->morphMany(Modifier::class, 'creature')->orderBy('name');
    }

    public function actions() {
        return $this->morphMany(Action::class, 'creature')->orderBy('name');
    }

    public function displayName() {
        return $this->name . ($this->name_number ? ' ' . $this->name_number : '');
    }

    public function getDisplayNameAttribute() {
        return $this->displayName();
    }

    public function rest($length) {
        $output = [];
        array_push($output, $this->display_name . ' took a ' . $length . ' rest.');

        if($length == 'long') {
            $recovered_hp = $this->hp_max - $this->hp_current;
            $this->hp_current = $this->hp_max;
            array_push($output, $recovered_hp . ' HP recovered.');
            $hit_dice_array = $this->hit_dice;
            foreach($this->hit_dice as $index => $hit_dice) {
                $half_hd = $hit_dice['count'] == 1 ? $hit_dice['count'] : floor($hit_dice['count'] / 2);
                $recovered_hd = false;
                if($hit_dice['count'] - $hit_dice['current'] < $half_hd) {
                    $recovered_hd = $hit_dice['count'] - $hit_dice['current'];
                    $hit_dice['current'] = $hit_dice['count'];
                } else {
                    $recovered_hd = $half_hd;
                    $hit_dice['current'] = $hit_dice['current'] + $half_hd;
                }
                $hit_dice_array[$index] = $hit_dice;
                array_push($output, $recovered_hd . ' hit dice recovered.');
            }
            $this->hit_dice = $hit_dice_array;
            if($this->hp_temp != 0) {
                $this->hp_temp = 0;
                array_push($output, 'Temp HP reset.');
            }
        }
        if($this->spellcaster) {
            if(($length == 'short' && $this->spell_recover == 'short') || $length == 'long') {
                if($this->spell_type == 'slots') {
                    for($level = 1;$level<=9;$level++) {
                        $slots = $this->{'spell_slots_' . $level};
                        if(is_array($slots)) {
                            foreach($slots as $index => $slot) {
                                $slots[$index] = false;
                            }
                            $this->{'spell_slots_' . $level} = $slots;
                        }
                    }
                } else {
                    $this->spell_points_current = $this->spell_points_max;
                }
                array_push($output, 'All spell ' . $this->spell_type . ' recovered.');
            }
        }
        $this->save();

        foreach($this->resources as $resource) {
            $result = $resource->rest($length);
            if($result) {
                array_push($output, $result);
            }
        }

        return implode('<br>', $output);
    }
}
