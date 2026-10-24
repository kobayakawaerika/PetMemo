<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pets;

class PetController extends Controller
{
    public function index(Request $request)
    {
        $pets = Pets::where('user_id', Auth::id())->get();

        // ペットが1匹も登録されていない場合は新規作成画面へ
        if ($pets->isEmpty()) {
            return redirect()->route('pets.create');
        }

        // リクエストされたIDのペットを取得、なければ最初の1匹
        $pet = $request->filled('pet')
            ? $pets->firstWhere('id', $request->pet)
            : $pets->first();

        // 他人のペットIDが指定された場合などは404
        abort_if(! $pet, 404);

        $memos = $pet->memos()
            ->orderByDesc('memo_date')
            ->orderByDesc('id')
            ->take(5)
            ->get();

        return view('pets.index', compact('pets', 'pet', 'memos'));
    }

    public function create()
    {
        return view('pets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sex' => ['required', 'in:man,female,unknown'],
            'birthday' => ['nullable', 'date'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')){
            $photoPath = $request->file('photo')->store('pets', 'public');
        }

        Pets::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'sex' => $validated['sex'],
            'birthday' => $validated['birthday'],
            'photo_path' => $photoPath,
        ]);

        return redirect()->route('index');
    }

    // 編集画面
    public function edit($id)
    {
        // 自分のペットのみ取得（いなければ404）
        $pet = Pets::where('user_id', Auth::id())->findOrFail($id);

        return view('pets.edit', compact('pet'));
    }

    // 更新用
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sex' => ['required', 'in:man,female,unknown'],
            'birthday' => ['nullable', 'date'],
        ]);

        // 自分のペットのみ取得（いなければ404）
        $pet = Pets::where('user_id', Auth::id())->findOrFail($id);

        $pet->update([
            'name' => $validated['name'],
            'sex' => $validated['sex'],
            'birthday' => $validated['birthday'],
        ]);

        return redirect()->route('index', ['pet' => $pet->id]);
    }

    // 削除
    public function delete(Pets $pet)
    {
        // 自分のペットじゃなければ403を表示
        abort_unless($pet->user_id === Auth::id(), 403);

        $pet->delete();
        return redirect('/index')->with('status', 'ペットを削除しました');
    }
}
