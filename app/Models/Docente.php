<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $fillable = ['nombre', 'apellido', 'email', 'categoria_id', 'user_id', 'materia_id'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class,);
    }

    public function periodo()
    {
        return $this->hasMany(Periodo::class, 'docente_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
