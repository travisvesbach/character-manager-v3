<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Creature extends Model
{

    protected $fillable = [
        'user_id',
        'name',
        'max_hp',
        'hit_dice',
        'ac',
        'ac_source',
        'initiative',
        'speed',
        'strength',
        'strength_mod',
        'strength_save',
        'athletics',
        'dexterity',
        'dexterity_mod',
        'dexterity_save',
        'acrobatics',
        'sleight_of_hand',
        'stealth',
        'constitution',
        'constitution_mod',
        'constitution_save',
        'intelligence',
        'intelligence_mod',
        'intelligence_save',
        'arcana',
        'history',
        'investigation',
        'nature',
        'religion',
        'wisdom',
        'wisdom_mod',
        'wisdom_save',
        'animal_handling',
        'insight',
        'medicine',
        'perception',
        'survival',
        'charisma',
        'charisma_mod',
        'charisma_save',
        'deception',
        'intimidation',
        'performance',
        'persuasion',
        'actions',
        'modifiers',
        'spells',
        'resources',
        'show_notepad',
        'show_resources',
        'show_spells',
        'show_dice',
        'notes',
        'skills',
        'proficient_skills',
        'expert_skills',
        'special_skill_modifiers',
    ];

    protected $casts = [
        'actions' => 'array',
        'modifiers' => 'array',
        'spells' => 'array',
        'resources' => 'array',
        'proficient_skills' => 'array',
        'expert_skills' => 'array',
        'special_skill_modifiers' => 'array',
        'hit_dice' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
