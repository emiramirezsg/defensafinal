<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Categoria;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DocenteController extends Controller
{
    public function index()
    {
        $docentes = Docente::with('categoria', 'materia', 'materia.cursos')->get();

        //dd($docentes);
        return view('docentes.index', compact('docentes',));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $materias = Materia::with('cursos')->get();
        return view('docentes.create', compact('categorias', 'materias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'categoria_id' => 'required|exists:categorias,id',
            'materia_id' => 'required|exists:materias,id',
        ]);

        // Crear el usuario
        $user = User::create([
            'name' => $request->nombre . ' ' . $request->apellido,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'docente', // Asignar rol de docente
        ]);

        // Crear el docente
        Docente::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'categoria_id' => $request->categoria_id,
            'materia_id' => $request->materia_id,
            'user_id' => $user->id,
        ]);

        return redirect()->route('docentes.index')->with('success', 'Docente creado exitosamente.');
    }


    public function show($id)
        {
            $docente = Docente::with('materias')->findOrFail($id);
            return view('docentes.show', compact('docente'));
        }

    public function edit(Docente $docente)
        {
            $categorias = Categoria::all();
            $materias = Materia::all();

            return view('docentes.edit', compact('docente', 'categorias', 'materias'));
        }

    public function update(Request $request, $id)
        {
            //dd($request->all());
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'email' => 'required|email|max:255',//|unique:users,email,' . $id, // Asegúrate de permitir el mismo email
                'categoria_id' => 'required|exists:categorias,id',
                'dias_libres' => 'array',
                'dias_libres.*' => 'nullable|string|max:255',
                'materia_id' => 'array',
                'materia_id.*' => 'nullable|exists:materias,id',
            ], [
                'email.unique' => 'El correo ya está en uso. Por favor, usa otro correo electrónico.',
            ]);

            /*
            try {
            */
                // Encuentra el usuario correspondiente
                $user = User::where('email', $validatedData['email'])->first();
                if (!$user) {
                    return back()->with('error', 'Usuario no encontrado');
                }

                // Actualiza el usuario en la tabla `users`
                $user->name = $validatedData['nombre'];
                $user->email = $validatedData['email'];
                // No actualizamos la contraseña aquí, pero podrías hacerlo si es necesario.
                $user->save();

                $docente = Docente::findOrFail($id);
                $docente->nombre = $validatedData['nombre'];
                $docente->apellido = $validatedData['apellido'];
                $docente->email = $validatedData['email'];
                $docente->categoria_id = $validatedData['categoria_id'];
                if(isset($request->dias_libres)){
                    $docente->dias_libres = json_encode($validatedData['dias_libres']);
                }else{
                    $docente->dias_libres = [];
                }

                if ($docente->save()) {
                    $materias_docente = Materia::where('docente_id', $docente->id)->get();
                    foreach($materias_docente as $materia_docente){
                        $materia_docente->docente_id = null;
                        $materia_docente->save();
                    }

                    foreach ($validatedData['materia_id'] as $materiaId) {
                        if ($materiaId) {
                            $materia = Materia::find($materiaId);
                            $materia->docente_id = $docente->id;
                            $materia->save();
                        }
                    }

                    return redirect()->route('docentes.index')->with('success', 'Docente actualizado correctamente');
                } else {
                    return back()->with('error', 'Error al guardar el docente');
                }
            /*
            } catch (\Exception $e) {
                return back()->with('error', 'Error: ' . $e->getMessage());
            }
            */
        }

        public function destroy($id)
    {
        try {
            $docente = Docente::findOrFail($id);

            if ($docente->user) {
                $docente->user->delete();
            }
            $docente->delete();

            return redirect()->route('docentes.index')->with('success', 'Docente y usuario eliminado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el docente: ' . $e->getMessage());
        }
    }

    public function horarios()
    {
        $user = Auth::user();
        $docente = Docente::where('user_id', $user->id)->first();

        if (!$docente) {
            return redirect()->route('home')->with('error', 'No se encontró el docente asociado.');
        }

        return view('docentevista.index', compact('docente'));
    }
}
