<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Memos;
use Carbon\Carbon;

class Pets extends Model
{


// クラスの中に
public function sexSymbol(): string
{
    return match ($this->sex) {
        'man' => '♂',
        'female' => '♀',
        default => '不明',
    };
}

public function age(): ?string
{
    if (! $this->birthday) {
        return null;
    }

    $diff = Carbon::parse($this->birthday)->diff(now());

    return $diff->y . '歳 ' . $diff->m . 'ヶ月';
}

    protected $fillable = [
        'user_id',
        'name',
        'birthday',
        'sex'
    ];

    public function memos(){
    return $this->hasMany(Memos::class);
}

}

