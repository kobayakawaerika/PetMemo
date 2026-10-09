<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Memos extends Model
{
    protected $fillable = [
        'pet_id',
        'memo_date',
        'health_status',
        'weight',
        'content'
    ];
}
