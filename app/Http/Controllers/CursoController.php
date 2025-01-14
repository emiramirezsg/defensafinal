<?php
namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Materia;
use App\Models\Paralelo;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        $materias = Materia::all();
        $cursos = Curso::with('paralelos')->get();
        return view('cursos.index', compact('cursos','materias'));
    }

    public function create()
    {
        return view('cursos.create');
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|unique:cursos|max:255',
        ]);

        // Crear un nuevo curso
        $curso = new Curso();
        $curso->nombre = $request->input('nombre');
        $curso->save();

        return redirect()->route('cursos.index')->with('success', 'Curso creado exitosamente.');
    }

    public function show(Curso $curso)
    {
        // Cargar el curso con paralelos
        $curso->load('paralelos');
        return view('cursos.show', compact('curso'));
    }

    public function edit(Curso $curso)
    {
        return view('cursos.edit', compact('curso'));
    }

    public function update(Request $request, Curso $curso)
    {
        $validated = $request->validate([
            'nombre' => 'string|max:255',
        ]);

        $curso->update($validated);

        return redirect()->route('cursos.index');
    }

    public function destroy($id)
{
    $curso = Curso::findOrFail($id);
    
    // Eliminar todos los paralelos asociados
    $curso->paralelos()->delete();
    
    // Ahora eliminar el curso
    $curso->delete();
    
    return redirect()->route('cursos.index')->with('success', 'Curso y sus paralelos eliminados exitosamente.');
}
    public function asignarMaterias(Request $request)
    {
        $curso = Curso::findOrFail($request->input('curso_id'));
        $curso->materias()->sync($request->input('materias')); // Sincroniza las materias asociadas al curso

        return redirect()->route('cursos.index')->with('success', 'Materias asignadas correctamente.');
    }
}
