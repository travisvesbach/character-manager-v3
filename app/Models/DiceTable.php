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
        'dice_size'
    ];

    protected $casts = [
        'rows' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function path() {
        return route('dice_tables.show', $this->id);
    }

    public function getPathAttribute() {
        return $this->path();
    }

    public function diceSize() {
        $rows = $this->rows;
        return end(end($rows)['range']);
    }

    public function getDiceSizeAttribute() {
        return $this->diceSize();
    }

    public function scopeUserOrPublic($query, $user_id) {
        return $query->where(function($q) use($user_id) {
            $q->where('user_id', $user_id)
                ->orWhere('public', 1);
        });
    }

    public function cleanRows() {
        $rows = $this->rows;
        foreach($rows as $index => $row) {
            $rows[$index]['range'] = array_filter($row['range'], function($v) { return !is_null($v); });
        }
        $this->rows = $rows;
    }
}
