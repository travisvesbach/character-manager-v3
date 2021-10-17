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
    ];

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
        $monster = $this->monsters()->orderBy('weight', 'desc')->first();
        if($monster && $monster->weight) {
            return $monster->weight + 1;
        } else {
            return 1;
        }
    }
}
