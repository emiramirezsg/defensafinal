<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    protected $fillable = ['nombre', 'cantidad_sillas', 'cantidad_mesas'];

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}
