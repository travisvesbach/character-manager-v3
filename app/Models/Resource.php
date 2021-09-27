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
            'counter_type',
            'total',
            'current',
            'slots',
            'recover',
            'dice',
    ];

    protected $casts = [
        'slots' => 'array',
        'dice'  => 'array',
    ];

    public function creature() {
        return $this->morphTo();
    }
}
