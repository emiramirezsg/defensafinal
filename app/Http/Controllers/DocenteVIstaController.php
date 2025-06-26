<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Horario;
use App\Models\Docente;
use App\Models\Paralelo;
use App\Models\Periodo;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class DocenteVistaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $docente = Docente::where('user_id', $user->id)->first();

        if (!$docente) {
            return view('docentevista.index', [
                'horariosPorDia' => [],
                'docente' => null,
                'mensaje' => 'No se encontró un docente asociado al usuario actual.'
            ]);
        }

        $periodos = Periodo::with(['paralelo.curso', 'docente.materia', 'horario'])
            ->where('docente_id', $docente->id)
            ->get();

        $mapaDias = [
            'lunes' => 'lunes',
            'martes' => 'martes',
            'miércoles' => 'miercoles',
            'miercoles' => 'miercoles',
            'jueves' => 'jueves',
            'viernes' => 'viernes'
        ];

        $horariosPorHora = [];

        foreach ($periodos as $periodo) {
            $diaOriginal = strtolower($periodo->dia);
            $diaNormalizado = Str::ascii($diaOriginal);
            $dia = $mapaDias[$diaNormalizado] ?? null;

            if (!$dia) continue;

            $horaInicio = $periodo->horario->hora_inicio;
            $horaFin = $periodo->horario->hora_fin;

            $horaKey = $horaInicio . ' - ' . $horaFin;

            if (!isset($horariosPorHora[$horaKey])) {
                $horariosPorHora[$horaKey] = [
                    'hora_inicio' => $horaInicio,
                    'hora_fin' => $horaFin,
                    'lunes' => null,
                    'martes' => null,
                    'miercoles' => null,
                    'jueves' => null,
                    'viernes' => null,
                ];
            }

            $horariosPorHora[$horaKey][$dia] = $periodo;
        }

        // Ordenar por hora de inicio
        $horariosOrdenados = collect($horariosPorHora)->sortBy(function ($item) {
            return Carbon::parse($item['hora_inicio']);
        });

        return view('docentevista.index', [
            'docente' => $docente,
            'horariosPorHora' => $horariosOrdenados,
        ]);
    }
}
