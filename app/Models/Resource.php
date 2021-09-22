<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
            'name',
            'creature_id',
            'creature_type',
            'type',
            'counter_total',
            'counter_type',
            'counter_slots',
            'counter_current',
            'recover',
            'dice_count',
            'dice_size',
            'dice_modifier',
    ];

    public function creature() {
        return $this->morphTo();
    }
}
