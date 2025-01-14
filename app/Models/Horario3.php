<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = ['horas', 'periodo_id', 'docente_materia_id', 'aula_id'];

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }
    
}
