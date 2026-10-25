<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pets;
use App\Models\WeightLog;
use Illuminate\Support\Facades\Storage;

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

        $weights = $pet->weightLogs()
            ->orderByDesc('measured_at')
            ->take(1)
            ->get();

        return view('pets.index', compact('pets', 'pet', 'memos', 'weights'));
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
        if ($request->hasFile('photo')) {
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
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        // 自分のペットのみ取得（いなければ404）
        $pet = Pets::where('user_id', Auth::id())->findOrFail($id);

        // 更新する中身（先に作っておく）
        $data = [
            'name' => $validated['name'],
            'sex' => $validated['sex'],
            'birthday' => $validated['birthday'],
        ];

        // 新しい写真があるときだけ、古い写真を消して保存
        if ($request->hasFile('photo')) {
            if ($pet->photo_path) {
                Storage::disk('public')->delete($pet->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('pets', 'public');
        }

        $pet->update($data);

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

    // 体重記録
    public function weight(Request $request, Pets $pet)
    {
        abort_unless($pet->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'weight' => ['required', 'numeric', 'gt:0', 'max:999.99'],
            'measured_at' => ['required', 'date'],
        ]);

        WeightLog::create([
            'pet_id' => $pet->id,
            'weight' => $validated['weight'],
            'measured_at' => $validated['measured_at'],
        ]);

        return redirect()->route('index', ['pet' => $pet->id]);
    }

    // 体重削除
    public function weightDelete(WeightLog $weightLog, Pets $pet)
    {
        abort_unless($weightLog->pet->user_id === Auth::id(), 403);

        $weightLog->delete();
        return redirect()->route('index', ['pet' => $weightLog->pet_id]);
    }
}
