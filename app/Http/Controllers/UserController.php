<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docente;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Método para crear un usuario docente
    public function createDocente(Request $request)
    {
        // Validar los datos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'docente_nombre' => 'required|string|max:255',
            'docente_apellido' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        // Crear el usuario
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'is_docente' => true,
        ]);

        // Crear el docente asociado
        Docente::create([
            'user_id' => $user->id,
            'nombre' => $request->input('docente_nombre'),
            'apellido' => $request->input('docente_apellido'),
            'categoria_id' => $validated['categoria_id'],
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Docente creado con éxito.');
    }

    // Método para mostrar el perfil del usuario
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    // Método para actualizar el perfil del usuario
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('user.profile')->with('success', 'Perfil actualizado correctamente.');
    }
}
