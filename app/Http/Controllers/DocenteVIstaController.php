<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Docente;


class DocenteVistaController extends Controller
{
    public function index()
    {
        $docente = Auth::user();
        $docentes = Docente::all();
        $horarios = $docente->horarios;
        return view('docentevista.index', compact('docentes'));
    }
    
}
