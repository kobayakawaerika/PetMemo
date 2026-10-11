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

        if ($pets->isEmpty()) {
            return redirect('peets.create');
        }
        $pet = $request->filled('pet')
        ? $pets->firstWhere('id', $request->pet)
        : $pets->first();

    abort_if(! $pet, 404);

    return view('pets.index', compact('pets', 'pet'));
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
        ]);

        Pets::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'sex' => $validated['sex'],
            'birthday' => $validated['birthday'],
        ]);
        return redirect('index');
    }

    // 編集画面
    public function edit($id)
    {
        $pet = Pets::where('user_id', Auth::id())->findOrFail($id);

        return view('pets.edit', compact('pet'));
    }

    //更新用
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sex' => ['required', 'in:man,female,unknown'],
            'birthday' => ['nullable', 'date'],
        ]);
        $pet = Pets::where('user_id', Auth::id())->findOrFail($id);
        $pet->update([
            'name' => $validated['name'],
            'sex' => $validated['sex'],
            'birthday' => $validated['birthday'],
        ]);
        return redirect('index');
    }
}
