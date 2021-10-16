<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
