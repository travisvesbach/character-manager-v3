<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Creature;

class Character extends Creature
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->mergeFillable([
            'race',
            'class',
            'level',
            'current_hp',
            'is_archived',
            'archive_date',
        ]);
    }

    public function path() {
        return route('characters.show', $this->id);
    }
}
