<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'creature_id',
        'creature_type',
        'type',
        'range',
        'notes',
        'attack',
        'attack_modifier',
        'attack_does_damage',
        'attack_dice',
        'save',
        'save_type',
        'save_dc',
        'save_does_damage',
        'save_dice',
        'auto',
        'auto_does_damage',
        'auto_dice',
    ];

    protected $casts = [
        'attack_dice'  => 'array',
        'save_dice'  => 'array',
        'auto_dice'  => 'array',
    ];

    public function creature() {
        return $this->morphTo();
    }
}
