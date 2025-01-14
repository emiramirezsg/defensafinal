<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = ['nombre', 'hrs_trabajo', 'dias_libres'];

    public function docentes()
    {
        return $this->hasMany(Docente::class);
    }
}
