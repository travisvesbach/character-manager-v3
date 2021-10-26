<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class DiceTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'rows',
        'public',
    ];

    protected $appends = [
        'path',
    ];

    protected $casts = [
        'rows' => 'array',
    ];

    public function path() {
        return route('dice_tables.show', $this->id);
    }

    public function getPathAttribute() {
        return $this->path();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
