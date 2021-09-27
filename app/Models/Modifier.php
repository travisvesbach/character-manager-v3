<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modifier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'creature_id',
        'creature_type',
        'ability',
        'ability_dice',
        'save',
        'save_dice',
        'attack',
        'attack_dice',
        'critical_range',
        'critical_range_start',
        'damage',
        'damage_as',
        'damage_dc',
        'damage_save',
        'damage_dice',
    ];

    protected $casts = [
        'ability_dice' => 'array',
        'save_dice'  => 'array',
        'attack_dice'  => 'array',
        'damage_dice'  => 'array',
    ];

    public function creature() {
        return $this->morphTo();
    }
}
