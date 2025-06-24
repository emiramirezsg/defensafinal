<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< HEAD
use Illuminate\Support\Facades\Auth;
use App\Models\Horario;
use App\Models\Docente;
use App\Models\Paralelo;
use App\Models\Periodo;

class DocenteVistaController extends Controller
{
    public function index(Request $request)
    {
        // Obtener el docente seleccionado del filtro
        $docenteId = $request->input('docente_id');
        
        // Obtener los periodos con las relaciones necesarias
        $periodos = Periodo::with(['paralelo.curso', 'docente', 'docente.materia', 'horario'])
            ->when($docenteId, function($query) use ($docenteId) {
                return $query->where('dgitocente_id', $docenteId);
            })
            ->get();
    
        // Obtener todos los docentes para el filtro
        $docentes = Docente::all();
    
        // Organizar los periodos por días (Lunes a Viernes)
        $horariosPorDia = ['lunes' => [], 'martes' => [], 'miercoles' => [], 'jueves' => [], 'viernes' => []];
    
        foreach ($periodos as $periodo) {
            $dia = strtolower($periodo->dia); // 'lunes', 'martes', etc.
            $horario = $periodo->horario;
            $paralelo = $periodo->paralelo;
            
            // Agregar el periodo al día correspondiente
            $horariosPorDia[$dia][] = [
                'hora' => $horario->hora_inicio . ' - ' . $horario->hora_fin,
                'materia' => $periodo->docente->materia->nombre,
                'curso' => $paralelo->curso->nombre,
                'paralelo' => $paralelo->nombre,
            ];
        }
    
        return view('docentevista.index', [
            'docentes' => $docentes,
            'horariosPorDia' => $horariosPorDia,
        ]);
    }
    


}

=======

class DocenteVIstaController extends Controller
{
    public function index()
    {
        return view('docentevista.index');
    }

}
>>>>>>> 49e2db9 (cambios)
