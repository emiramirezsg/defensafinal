<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DocenteMateria extends Pivot
{
    protected $table = "docente_materia";
    protected $fillable = ['docente_id', 'materia_id'];

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
    
}
