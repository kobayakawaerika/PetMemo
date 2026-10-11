<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pets;

class MemoController extends Controller
{
    // メモ追加用
    public function memos(Request $request, $id){
        $validated = $request->validate([
            'memo' => ['required'],
        ]);

        $pet = Pets::where('user_id', Auth::id())->findOrFail($id);
        $pet->memo()->create([
            'memo' => $validated['memo'],
        ]);
        return back();
    }
}
