<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Creature;
use App\Models\Encounter;

class EncounterMonster extends Creature
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->mergeFillable([
            'size',
            'type',
            'alignment',
            'challenge_rating',
            'experience',
            'source',
            'weight',
            'encounter_id',
            'name_number',
        ]);

        $this->append([
            'path',
            'proficient_skills',
        ]);
    }

    public function path() {
        return route('encounter_monsters.show', [$this->encounter_id, $this->id]);
    }

    public function getPathAttribute() {
        return $this->path();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function encounter() {
        return $this->belongsTo(Encounter::class);
    }


    public function proficientSkills() {
        $skills = [
            [
                'slug' => 'acrobatics',
                'name' => 'Acrobatics',
                'proficient' => $this->acrobatics_proficiency || $this->acrobatics_expertise,
            ], [
                'slug' => 'animal_handling',
                'name' => 'Animal Handling',
                'proficient' => $this->animal_handling_proficiency || $this->animal_handling_expertise,
            ], [
                'slug' => 'arcana',
                'name' => 'Arcana',
                'proficient' => $this->arcana_proficiency || $this->arcana_expertise,
            ], [
                'slug' => 'athletics',
                'name' => 'Athletics',
                'proficient' => $this->athletics_proficiency || $this->athletics_expertise,
            ], [
                'slug' => 'deception',
                'name' => 'Deception',
                'proficient' => $this->deception_proficiency || $this->deception_expertise,
            ], [
                'slug' => 'history',
                'name' => 'History',
                'proficient' => $this->history_proficiency || $this->history_expertise,
            ], [
                'slug' => 'insight',
                'name' => 'Insight',
                'proficient' => $this->insight_proficiency || $this->insight_expertise,
            ], [
                'slug' => 'intimidation',
                'name' => 'Intimidation',
                'proficient' => $this->intimidation_proficiency || $this->intimidation_expertise,
            ], [
                'slug' => 'investigation',
                'name' => 'Investigation',
                'proficient' => $this->investigation_proficiency || $this->investigation_expertise,
            ], [
                'slug' => 'medicine',
                'name' => 'Medicine',
                'proficient' => $this->medicine_proficiency || $this->medicine_expertise,
            ], [
                'slug' => 'nature',
                'name' => 'Nature',
                'proficient' => $this->nature_proficiency || $this->nature_expertise,
            ], [
                'slug' => 'perception',
                'name' => 'Perception',
                'proficient' => $this->perception_proficiency || $this->perception_expertise,
            ], [
                'slug' => 'performance',
                'name' => 'Performance',
                'proficient' => $this->performance_proficiency || $this->performance_expertise,
            ], [
                'slug' => 'persuasion',
                'name' => 'Persuasion',
                'proficient' => $this->persuasion_proficiency || $this->persuasion_expertise,
            ], [
                'slug' => 'religion',
                'name' => 'Religion',
                'proficient' => $this->religion_proficiency || $this->religion_expertise,
            ], [
                'slug' => 'sleight_of_hand',
                'name' => 'Sleight of Hand',
                'proficient' => $this->sleight_of_hand_proficiency || $this->sleight_of_hand_expertise,
            ], [
                'slug' => 'stealth',
                'name' => 'Stealth',
                'proficient' => $this->stealth_proficiency || $this->stealth_expertise,
            ], [
                'slug' => 'survival',
                'name' => 'Survival',
                'proficient' => $this->survival_proficiency || $this->survival_expertise,
            ],
        ];

        foreach ($skills as $index => $skill) {
            if(!$this->{$skill['slug'] . '_proficiency'} && !$this->{$skill['slug'] . '_expertise'}) {
            // if(!$skill['proficient']) {
                unset($skills[$index]);
            }
        }
        return $skills;
    }

    public function getProficientSkillsAttribute() {
        return $this->proficientSkills();
    }
}
