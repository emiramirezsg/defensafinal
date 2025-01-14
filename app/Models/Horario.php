<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = ['hora_inicio', 'hora_fin' ];


    public function periodo()
    {
        return $this->hasMany(Periodo::class, 'horario_id');
    }


}
