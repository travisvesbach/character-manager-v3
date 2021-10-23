<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EncounterMonster;

class Encounter extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'notes',
    ];

    protected $appends = [
        'path',
        'experience',
        'difficulty',
    ];

    public $xp_thresholds = [
        1  => ['easy' => 25,   'medium' => 50,   'hard' => 75,   'deadly' => 100],
        2  => ['easy' => 50,   'medium' => 100,  'hard' => 150,  'deadly' => 200],
        3  => ['easy' => 75,   'medium' => 150,  'hard' => 225,  'deadly' => 400],
        4  => ['easy' => 125,  'medium' => 250,  'hard' => 375,  'deadly' => 500],
        5  => ['easy' => 250,  'medium' => 500,  'hard' => 750,  'deadly' => 1100],
        6  => ['easy' => 300,  'medium' => 600,  'hard' => 900,  'deadly' => 1400],
        7  => ['easy' => 350,  'medium' => 750,  'hard' => 1100, 'deadly' => 1700],
        8  => ['easy' => 450,  'medium' => 900,  'hard' => 1400, 'deadly' => 2100],
        9  => ['easy' => 550,  'medium' => 1100, 'hard' => 1600, 'deadly' => 2400],
        10 => ['easy' => 600,  'medium' => 1200, 'hard' => 1900, 'deadly' => 2800],
        11 => ['easy' => 800,  'medium' => 1600, 'hard' => 2400, 'deadly' => 3600],
        12 => ['easy' => 1000, 'medium' => 2000, 'hard' => 3000, 'deadly' => 4500],
        13 => ['easy' => 1100, 'medium' => 2200, 'hard' => 3400, 'deadly' => 5100],
        14 => ['easy' => 1250, 'medium' => 2500, 'hard' => 3800, 'deadly' => 5700],
        15 => ['easy' => 1400, 'medium' => 2800, 'hard' => 4300, 'deadly' => 6400],
        16 => ['easy' => 1600, 'medium' => 3200, 'hard' => 4800, 'deadly' => 7200],
        17 => ['easy' => 2000, 'medium' => 3900, 'hard' => 5900, 'deadly' => 8800],
        18 => ['easy' => 2100, 'medium' => 4200, 'hard' => 6300, 'deadly' => 9500],
        19 => ['easy' => 2400, 'medium' => 4900, 'hard' => 7300, 'deadly' => 10900],
        20 => ['easy' => 2800, 'medium' => 5700, 'hard' => 8500, 'deadly' => 12700]
    ];

    // public $encounter_multipliers = [1, 1.5, 2, 2.5, 3, 4];

    public function path() {
        return route('encounters.show', $this->id);
    }

    public function getPathAttribute() {
        return $this->path();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function monsters() {
        return $this->hasMany(EncounterMonster::class);
    }

    public function nextAvailableWeight() {
        $monster = $this->monsters->sortByDesc('weight')->first();

        if($monster && $monster->weight) {
            return $monster->weight + 1;
        }
        return 1;
    }

    public function nextNameNumber($name) {
        $monster = $this->monsters()->where('name', $name)->orderBy('name_number', 'desc')->first();
        if($monster && ($monster->name_number != null || $monster->name_number == 0)) {
            return $monster->name_number + 1;
        }
        return 0;
    }

    public function experience() {
        $experience = 0;
        foreach($this->monsters as $monster) {
            $experience += $monster->experience;
        }
        return $experience;
    }

    public function getExperienceAttribute() {
        return $this->experience();
    }

    public function difficulty() {
        $party_xp_thresholds = [
            'easy' => 0,
            'medium' => 0,
            'hard' => 0,
            'deadly' => 0,

        ];
        $party_size = 0;
        if(!auth()->user()->party) {
            return '&#8212';
        }
        foreach(auth()->user()->party as $group) {
            $party_size += $group['count'];
            $thresholds = $this->xp_thresholds[$group['level']];
            foreach($thresholds as $key => $threshold) {
                $party_xp_thresholds[$key] += ($threshold * $group['count']);
            }
        }

        $encounter_multipliers = [1, 1.5, 2, 2.5, 3, 4];
        $monster_count = $this->loadCount('monsters')->monsters_count;

        if($monster_count == 1) {
            $index = $this->multiplierByPartySize(0, $party_size);
        } elseif($monster_count == 2) {
            $index = $this->multiplierByPartySize(1, $party_size);
        } elseif($monster_count <= 6) {
            $index = $this->multiplierByPartySize(2, $party_size);
        } elseif($monster_count <= 10) {
            $index = $this->multiplierByPartySize(3, $party_size);
        } elseif($monster_count <= 14) {
            $index = $this->multiplierByPartySize(4, $party_size);
        } elseif($monster_count >= 15) {
            $index = $this->multiplierByPartySize(5, $party_size);
        }

        $modified_encounter_xp = $this->experience * $encounter_multipliers[$index];
        if($modified_encounter_xp < $party_xp_thresholds['medium']) {
            return 'Easy';
        } elseif($modified_encounter_xp < $party_xp_thresholds['hard']) {
            return 'Medium';
        } elseif($modified_encounter_xp < $party_xp_thresholds['deadly']) {
            return 'Hard';
        } elseif($modified_encounter_xp >= $party_xp_thresholds['deadly']) {
            return 'Deadly';
        }
    }

    public function multiplierByPartySize($index, $party_size) {
        if($party_size < 3) {
            return $index == 5 ? $index : $index + 1;
        } elseif($party_size > 5) {
            return $index == 0 ? $index : $index - 1;
        } else {
            return $index;
        }
    }

    public function getDifficultyAttribute() {
        return $this->difficulty();
    }
}
