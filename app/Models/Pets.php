<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Memos;

class Pets extends Model
{
    protected $fillable = [
        'name',
        'birthday',
        'sex'
    ];
}
