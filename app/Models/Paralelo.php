<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paralelo extends Model
{
    protected $fillable = ['nombre', 'cantidad_est', 'curso_id'];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}