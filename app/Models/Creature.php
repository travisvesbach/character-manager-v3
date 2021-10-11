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
        'spell_counters',
        'notes',
        'show_resources',
        'show_modifiers',
        'show_notes',
        'show_dice',
        'skills_auto_filled',
    ];

    protected $casts = [
        'hit_dice'                  => 'array',
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
        'spell_counters'            => 'array',
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
}
