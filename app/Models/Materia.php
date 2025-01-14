<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $fillable = ['nombre'];

    public function cursos()
{
    return $this->belongsToMany(Curso::class, 'materia_curso')
                ->withPivot('cantidad_horas_mensuales')
                ->withTimestamps();
}


    public function docentes()
    {
        return $this->hasMany(Docente::class, 'materia_id');
    }
}
