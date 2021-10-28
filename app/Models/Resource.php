<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DiceTable;

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
            'dice_table_id',
    ];

    protected $casts = [
        'slots' => 'array',
        'dice'  => 'array',
    ];

    public function creature() {
        return $this->morphTo();
    }

    public function diceTable() {
        return $this->belongsTo(DiceTable::class);
    }

    public function rest($length) {
        if(($length == 'short' && $this->recover == 'short') || ($length == 'long' && $this->recover)) {
            if($this->counter_type == 'slots') {
                $slots = $this->slots;
                foreach($slots as $index => $slot) {
                    $slots[$index] = false;
                }
                $this->slots = $slots;
            } else {
                $this->current = $this->total;
            }
            $this->save();
            return 'All ' . $this->name . ' ' . $this->counter_type . ' recovered.';
        }
        return false;
    }
}
