<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast;

class WeightLog extends Model
{
    protected $fillable = [
        'pet_id',
        'weight',
        'measured_at',
    ];

    protected function casts(): array
    {
        return [
            'measured_at' => 'datetime',
        ];
    }

        public function pet()
    {
        return $this->belongsTo(Pets::class);
    }
}
