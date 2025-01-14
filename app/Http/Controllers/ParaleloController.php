<?php
namespace App\Http\Controllers;

use App\Models\Paralelo;
use App\Models\Curso;
use Illuminate\Http\Request;

class ParaleloController extends Controller
{
    public function index()
    {
        $paralelos = Paralelo::with('curso')->get();
        return view('paralelos.index', compact('paralelos'));
    }

    public function create()
    {
        $cursos = Curso::all();
        return view('paralelos.create', compact('cursos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad_est' => 'required|integer',
            'curso_id' => 'required|exists:cursos,id',
        ]);

        Paralelo::create($validated);

        return redirect()->route('cursos.index');
    }

    public function show(Paralelo $paralelo)
    {
        return view('paralelos.show', compact('paralelo'));
    }

    public function edit(Paralelo $paralelo)
    {
        return view('paralelos.edit', compact('paralelo'));
    }

    public function update(Request $request, Paralelo $paralelo)
    {
        if (!$paralelo) {
            return redirect()->route('cursos.index')->with('error', 'Paralelo no encontrado.');
        }

        $validated = $request->validate([
            'nombre' => 'string|max:255',
            'cantidad_est' => 'integer',
        ]);

        $paralelo->update($validated);

        return redirect()->route('cursos.index')->with('success', 'Paralelo actualizado con éxito.');
    }


    public function destroy(Paralelo $paralelo)
    {
        $paralelo->delete();

        return redirect()->route('cursos.index');
    }
}
