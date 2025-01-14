<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use Illuminate\Http\Request;

class AulaController extends Controller
{
    public function index()
    {
        $aulas = Aula::all();
        return view('aulas.index', compact('aulas'));
    }

    public function create()
    {
        return view('aulas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad_sillas' => 'required|integer',
            'cantidad_mesas' => 'required|integer',
        ]);

        Aula::create($validated);

        return redirect()->route('aulas.index');
    }

    public function show(Aula $aula)
    {
        return view('aulas.show', compact('aula'));
    }

    public function edit(Aula $aula)
    {
        return view('aulas.edit', compact('aula'));
    }

    public function update(Request $request, Aula $aula)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad_sillas' => 'required|integer',
            'cantidad_mesas' => 'required|integer',
        ]);

        $aula->update($validated);

        return redirect()->route('aulas.index');
    }

    public function destroy(Aula $aula)
    {
        $aula->delete();

        return redirect()->route('aulas.index');
    }
}
