<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $fillable = ['dia','horario_id', 'docente_id', 'paralelo_id'];

    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }
    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }
    public function paralelo()
    {
        return $this->belongsTo(Paralelo::class);
    }

}
