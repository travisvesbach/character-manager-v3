<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Creature;

class Monster extends Creature
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->mergeFillable([
            'size',
            'type',
            'alignment',
            'damage_vulnerabilities',
            'damage_resistances',
            'damage_immunities',
            'condition_immunities',
            'senses',
            'languages',
            'challenge_rating',
            'experience',
            'source',
            'public',
        ]);
    }

    protected $appends = [
        'path',
    ];

    public function path() {
        return route('monsters.show', $this->id);
    }

    public function getPathAttribute() {
        return $this->path();
    }

    public function scopeUserOrPublic($query, $user_id) {
        return $query->where(function($q) use($user_id) {
            $q->where('user_id', $user_id)
                ->orWhere('public', 1);
        });
    }
}
