<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $fillable = ['hora_inicio', 'hora_fin', 'dia',
        'paralelo_id', 'horario_id', 'docente_id', 'curso_id', 'aula_id', 'paralelo_id', 'materia_id'];

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    public function paralelo()
    {
        return $this->hasMany(Paralelo::class, 'id', 'paralelo_id');
    }

    public function docente()
    {
        return $this->hasMany(Docente::class, 'id', 'docente_id');
    }

    public function horario()
    {
        return $this->hasMany(Horario::class, 'id', 'horario_id');
    }
}
