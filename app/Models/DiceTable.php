<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Resource;

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

    protected static function boot() {
        parent::boot();

        static::deleting(function($dice_table) {
            $dice_table->resources()->delete();
        });
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function resources() {
        return $this->hasMany(Resource::class);
    }

    public function path() {
        return route('dice_tables.show', $this->id);
    }

    public function getPathAttribute() {
        return $this->path();
    }

    public function diceSize() {
        if($this->rows) {
            $rows = $this->rows;
            return end(end($rows)['range']);
        }
        return null;
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
