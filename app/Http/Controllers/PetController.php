<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pets;

class PetController extends Controller
{
    public function index()
    {
        $pets = Pets::where('user_id', Auth::id())->get();

        if ($pets->isEmpty()){
            return redirect('peets.create');
        }
        return view('pets.index', compact('pets'));
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
}
