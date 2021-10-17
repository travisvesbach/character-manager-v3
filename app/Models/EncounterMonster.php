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
    }

    protected $appends = [
        'path',
        'display_name',
    ];

    public function path() {
        return route('encounter_monsters.show', [$this->encounter_id, $this->id]);
    }

    public function getPathAttribute() {
        return $this->path();
    }

    public function displayName() {
        return $this->name . ($this->name_number ? ' ' . $this->name_number : '');
    }

    public function getDisplayNameAttribute() {
        return $this->displayName();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function encounter() {
        return $this->belongsTo(Encounter::class);
    }
}
