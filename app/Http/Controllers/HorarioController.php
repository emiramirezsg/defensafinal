<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Horario;
use App\Models\Materia;
use App\Models\Paralelo;
use App\Models\Periodo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HorarioController extends Controller
{
    public function index(Request $request)
{
    $docenteId = $request->input('docente_id'); // Obtener el docente seleccionado del filtro

    // Obtener los periodos filtrados si se selecciona un docente
    $periodos = Periodo::with(['paralelo.curso', 'docente', 'docente.materia', 'horario']);

    if ($docenteId) {
        $periodos = $periodos->where('docente_id', $docenteId); // Filtrar por docente si se selecciona uno
    }

    $periodos = $periodos->get(); // Obtener los periodos

    $horarios = Horario::all();
    $paralelos = Paralelo::with(['curso'])->get();
    $docentes = Docente::all(); // Obtener todos los docentes para el filtro

    return view('horarios.index', [
        'periodos' => $periodos,
        'horarios' => $horarios,
        'paralelos' => $paralelos,
        'docentes' => $docentes // Pasar los docentes para el filtro
    ]);
}


    public function generarPeriodos($materia, $paralelo, $horasPorSemana, &$horariosOcupadosGlobales)
    {
        $horarios = DB::table('horarios')->orderBy('hora_inicio')->get();
        $docente = DB::table('docentes')->where('materia_id', $materia->id)->first();

        if (!$docente) {
            throw new Exception("No se encontró un docente para la materia especificada.");
        }

        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
        $periodos = [];
        $horasRestantes = $horasPorSemana;

        foreach ($dias as $dia) {
            if ($horasRestantes <= 0) break;

            $horariosDia = $horarios->reject(function ($horario) use ($dia, &$horariosOcupadosGlobales, $docente, $paralelo) {

                $ocupadoEnParalelo = isset($horariosOcupadosGlobales[$dia]['paralelo'][$paralelo->id]) &&
                    in_array($horario->id, $horariosOcupadosGlobales[$dia]['paralelo'][$paralelo->id]);
                    $ocupadoPorDocente = isset($horariosOcupadosGlobales[$dia]['docente'][$docente->id]) &&
                    in_array($horario->id, $horariosOcupadosGlobales[$dia]['docente'][$docente->id]);

                return $ocupadoEnParalelo || $ocupadoPorDocente;
            });

            $periodosPorDia = 0;
            foreach ($horariosDia as $horario) {

                if ($horasRestantes <= 0 || $periodosPorDia >= 2) break; // Máximo 2 periodos consecutivos por día

                $duracion = (strtotime($horario->hora_fin) - strtotime($horario->hora_inicio)) / 3600;

                if ($horasRestantes > 0) {
                    $periodos[] = [
                        'docente_id' => $docente->id,
                        'paralelo_id' => $paralelo->id,
                        'dia' => $dia,
                        'horario_id' => $horario->id,
                    ];
                    $horasRestantes -= $duracion;
                    $horariosOcupadosGlobales[$dia]['paralelo'][$paralelo->id][] = $horario->id; // Marcar horario como ocupado en el paralelo
                    $horariosOcupadosGlobales[$dia]['docente'][$docente->id][] = $horario->id; // Marcar horario como ocupado por el docente
                    $periodosPorDia++;
                }
            }
        }

        DB::table('periodos')->insert($periodos);

        return $periodos;
    }
public function generarHorarios(Request $request)
{
    Periodo::truncate();
    try {
        $materias = Materia::all();
        $paralelos = Paralelo::with('curso')->get();
        $horariosOcupadosGlobales = [];

        foreach ($paralelos as $paralelo) {
            foreach ($materias as $materia) {
                $registroMateriaCurso = DB::table('materia_curso')
                    ->where('materia_id', $materia->id)
                    ->where('curso_id', $paralelo->curso->id)
                    ->first();

                if ($registroMateriaCurso && $registroMateriaCurso->cantidad_horas_mensuales > 0) {
                    $horasMensuales = $registroMateriaCurso->cantidad_horas_mensuales;
                    $horasPorSemana = ceil($horasMensuales / 4);
                    $this->generarPeriodos($materia, $paralelo, $horasPorSemana, $horariosOcupadosGlobales);
                }
            }
        }

        $periodos = Periodo::with(['paralelo.curso', 'docente', 'docente.materia', 'horario'])->get();
        $horarios = Horario::all();
        $paralelos = Paralelo::with(['curso'])->get();
        return response()->json(['status' => 'success', 'periodos' => $periodos, 'horarios'=> $horarios, 'paralelos'=> $paralelos]);
    } catch (Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}
}
