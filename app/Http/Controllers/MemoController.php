<?php

namespace App\Http\Controllers;

use App\Models\Memos;
use App\Models\Pets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemoController extends Controller
{
    /**
     * メモの追加
     */
    public function memos(Request $request, $id)
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:1000'],
            'memo_date' => ['nullable', 'date'], // 日付指定があれば使用、なければ本日
        ]);

        // 自分のペットのみ取得（存在しなければ404）
        $pet = Pets::where('user_id', Auth::id())->findOrFail($id);

        $pet->memos()->create([
            'content' => $validated['content'],
            'memo_date' => $validated['memo_date'] ?? now()->toDateString(),
        ]);

        return back()->with('success', 'メモを追加しました');
    }

    /**
     * メモの削除
     */
    public function delete($id)
    {
        // ログインユーザーのペットに紐づくメモであることを条件にして取得
        $memo = Memos::whereHas('pet', function ($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $memo->delete();

        return back()->with('success', 'メモを削除しました');
    }
}
