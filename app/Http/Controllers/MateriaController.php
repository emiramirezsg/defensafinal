<?php
namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Curso;
use App\Models\Docente;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::with('cursos')->get();
        $cursos = Curso::all();
        //dd($materias);
        return view('materias.index', compact('materias', 'cursos'));
    }

    public function create()
    {
        $cursos = Curso::all();
        return view('materias.create', compact('cursos'));
    }

    public function store(Request $request)
{
    // Validar los datos entrantes
    $request->validate([
        'nombre' => 'required|string|max:255',
        'horas_semana' => 'required|integer|min:1',
        'curso_id' => 'required|exists:cursos,id',
    ]);

    // Crear la materia
    $materia = Materia::create([
        'nombre' => $request->nombre,
    ]);

    // Asociar la materia con el curso en la tabla intermedia
    $materia->cursos()->attach($request->curso_id, [
        'cantidad_horas_mensuales' => $request->horas_semana,
    ]);

    // Redireccionar con mensaje de éxito
    return redirect()->route('materias.index')->with('success', 'Materia creada con éxito.');
}

    public function show(Materia $materia)
    {
        $materia->load('docente'); // Usa `load` para evitar consultas adicionales
        $docentes = Docente::all(); // Si necesitas mostrar todos los docentes

        return view('materias.show', compact('materia', 'docentes'));
    }

    public function edit(Materia $materia)
    {
        return view('materias.edit', compact('materia'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'horas_semana' => 'required|integer|min:1',
        'curso_id' => 'required|exists:cursos,id',
    ]);

    // Buscar la materia por ID
    $materia = Materia::findOrFail($id);

    // Actualizar el nombre de la materia
    $materia->nombre = $request->nombre;
    $materia->save();

    // Actualizar la relación en la tabla intermedia con los datos adicionales
    $materia->cursos()->sync([
        $request->curso_id => ['cantidad_horas_mensuales' => $request->horas_semana],
    ]);

    return redirect()->route('materias.index')->with('success', 'Materia actualizada con éxito.');
}

    public function destroy(Materia $materia)
    {
        $materia->delete();

        return redirect()->route('materias.index')->with('success', 'Materia eliminada exitosamente.');
    }
}
