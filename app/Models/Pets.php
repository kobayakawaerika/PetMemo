<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Memos;
use App\Models\User;
use Carbon\Carbon;

class Pets extends Model
{
    /**
     * 一括指定可能な属性
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'birthday',
        'sex',
    ];

    /**
     * 属性のキャスト
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birthday' => 'date',
    ];

    // --- リレーション ---

    /**
     * メモとのリレーション（1対多）
     */
    public function memos(): HasMany
    {
        return $this->hasMany(Memos::class, 'pet_id');
    }

    /**
     * ユーザーとのリレーション（多対1）
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // --- カスタムヘルパーメソッド ---

    /**
     * 性別記号を取得
     */
    public function sexSymbol(): string
    {
        return match ($this->sex) {
            'man' => '♂',
            'female' => '♀',
            default => '不明',
        };
    }

    /**
     * 年齢文字列（〇歳 〇ヶ月）を取得
     */
    public function age(): ?string
    {
        if (! $this->birthday) {
            return null;
        }

        // $casts 設定により $this->birthday はすでに Carbon インスタンスになります
        $diff = $this->birthday->diff(now());

        return $diff->y . '歳 ' . $diff->m . 'ヶ月';
    }

    protected function casts(): array
    {
        return [
            'birthday' => 'date',
        ];
    }
}
