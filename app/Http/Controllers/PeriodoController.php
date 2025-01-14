<?php
namespace App\Http\Controllers;

use App\Models\Periodo;
use Illuminate\Http\Request;

class PeriodoController extends Controller
{
    public function index()
    {
        $periodos = Periodo::all();
        return view('periodos.index', compact('periodos'));
    }

    public function create()
    {
        return view('periodos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'dia' => 'required|string|max:255',
        ]);

        Periodo::create($validated);

        return redirect()->route('periodos.index');
    }

    public function show(Periodo $periodo)
    {
        return view('periodos.show', compact('periodo'));
    }

    public function edit(Periodo $periodo)
    {
        return view('periodos.edit', compact('periodo'));
    }

    public function update(Request $request, Periodo $periodo)
    {
        $validated = $request->validate([
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'dia' => 'required|string|max:255',
        ]);

        $periodo->update($validated);

        return redirect()->route('periodos.index');
    }

    public function destroy(Periodo $periodo)
    {
        $periodo->delete();

        return redirect()->route('periodos.index');
    }
}
