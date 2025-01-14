<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocenteVIstaController extends Controller
{
    public function index()
    {
        return view('docentes.index', compact('docentes'));
    }
    
}
