<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pets;
use App\Models\Memos;

class MemoController extends Controller
{
    // メモ追加用
    public function memos(Request $request, $id)
    {
        $validated = $request->validate([
            'content' => ['required'],
        ]);

        $pet = Pets::where('user_id', Auth::id())->findOrFail($id);
        $pet->memos()->create([
            'content' => $validated['content'],
            'memo_date' => now()->toDateString(),
        ]);
        return back();
    }

    // メモ削除ボタン
    public function delete($id)
    {
        $petIds = Pets::where('user_id', Auth::id())->pluck('id');

        $memo = Memos::whereIn('pet_id', $petIds)->findOrFail($id);
        $memo->delete();

        return back();
    }
}
