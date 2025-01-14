<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\ParaleloController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HorarioController;

Route::get('/', function () {
    return view('welcome');
});
Route::view('/login', "login")->name('login');
Route::view('/register', "register")->name('register');
Route::view('/home', "home")->middleware('auth')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/profile', [UserController::class, 'update'])->name('user.update');
    Route::post('/docentes', [UserController::class, 'createDocente'])->name('docentes.store');
});

Route::post('/validar_registro', [LoginController::class, 'register'])->name('validar_registro');
Route::post('/inicio_sesion', [LoginController::class, 'login'])->name('inicio_sesion');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/logout', [Logincontroller::class, 'logout'])->name('logout');
// Docentes Routes
Route::resource('docentes', DocenteController::class);

Route::get('/horarios', [DocenteController::class, 'horarios'])->name('docente.horarios');
Route::get('/docentes', [DocenteController::class, 'index'])->name('docentes.index');
Route::get('/docentes/create', [DocenteController::class, 'create'])->name('docentes.create');
Route::post('/docentes', [DocenteController::class, 'store'])->name('docentes.store');
Route::get('/docentes/{docente}', [DocenteController::class, 'show'])->name('docentes.show');
Route::get('/docentes/{docente}/edit', [DocenteController::class, 'edit'])->name('docentes.edit');
Route::put('/docentes/{docente}', [DocenteController::class, 'update'])->name('docentes.update');
Route::delete('/docentes/{docente}', [DocenteController::class, 'destroy'])->name('docentes.destroy');

// Cursos Routes
Route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index');
Route::get('/cursos/create', [CursoController::class, 'create'])->name('cursos.create');
Route::post('/cursos', [CursoController::class, 'store'])->name('cursos.store');
Route::get('/cursos/{curso}', [CursoController::class, 'show'])->name('cursos.show');
Route::get('/cursos/{curso}/edit', [CursoController::class, 'edit'])->name('cursos.edit');
Route::put('/cursos/{curso}', [CursoController::class, 'update'])->name('cursos.update');
Route::delete('/cursos/{curso}', [CursoController::class, 'destroy'])->name('cursos.destroy');

// Materias Routes
Route::get('/materias', [MateriaController::class, 'index'])->name('materias.index');
Route::get('/materias/create', [MateriaController::class, 'create'])->name('materias.create');
Route::post('/materias', [MateriaController::class, 'store'])->name('materias.store');
Route::get('/materias/{materia}', [MateriaController::class, 'show'])->name('materias.show');
Route::get('/materias/{materia}/edit', [MateriaController::class, 'edit'])->name('materias.edit');
Route::put('/materias/{materia}', [MateriaController::class, 'update'])->name('materias.update');
Route::delete('/materias/{materia}', [MateriaController::class, 'destroy'])->name('materias.destroy');

// Aulas Routes
Route::get('/aulas', [AulaController::class, 'index'])->name('aulas.index');
Route::get('/aulas/create', [AulaController::class, 'create'])->name('aulas.create');
Route::post('/aulas', [AulaController::class, 'store'])->name('aulas.store');
Route::get('/aulas/{aula}', [AulaController::class, 'show'])->name('aulas.show');
Route::get('/aulas/{aula}/edit', [AulaController::class, 'edit'])->name('aulas.edit');
Route::put('/aulas/{aula}', [AulaController::class, 'update'])->name('aulas.update');
Route::delete('/aulas/{aula}', [AulaController::class, 'destroy'])->name('aulas.destroy');

// Paralelos Routes
Route::resource('paralelos', ParaleloController::class);
Route::get('/paralelos', [ParaleloController::class, 'index'])->name('paralelos.index');
Route::get('/paralelos/create', [ParaleloController::class, 'create'])->name('paralelos.create');
Route::post('/paralelos', [ParaleloController::class, 'store'])->name('paralelos.store');
Route::get('/paralelos/{paralelo}', [ParaleloController::class, 'show'])->name('paralelos.show');
Route::get('/paralelos/{paralelo}/edit', [ParaleloController::class, 'edit'])->name('paralelos.edit');
Route::put('/paralelos/{paralelo}', [ParaleloController::class, 'update'])->name('paralelos.update');
Route::delete('/paralelos/{paralelo}', [ParaleloController::class, 'destroy'])->name('paralelos.destroy');

// Categorias Routes
Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
Route::get('/categorias/create', [CategoriaController::class, 'create'])->name('categorias.create');
Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
Route::get('/categorias/{categoria}', [CategoriaController::class, 'show'])->name('categorias.show');
Route::get('/categorias/{categoria}/edit', [CategoriaController::class, 'edit'])->name('categorias.edit');
Route::put('/categorias/{categoria}', [CategoriaController::class, 'update'])->name('categorias.update');
Route::delete('/categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');

// Horarios Routes
Route::get('/horarios', [HorarioController::class, 'index'])->name('horarios.index');
Route::get('/horarios/generar', [HorarioController::class, 'generar']);


Route::middleware(['auth', 'is_docente'])->group(function () {
    Route::get('/docente/horarios', [DocenteController::class, 'horarios'])->name('docente.horarios');
});
Route::middleware(['auth', 'is_docente'])->group(function () {
    Route::get('/docente/hours', [DocenteController::class, 'index'])->name('docente.hours');
    // Otras rutas para docentes
});

Route::post('/cursos/asignar-materias', [CursoController::class, 'asignarMaterias'])->name('cursos.asignarMaterias');
Route::post('/generate-schedules', [HorarioController::class, 'generateSchedules'])->name('generate.schedules');

Route::get('/mis-horarios', [DocenteController::class, 'showHorarios'])->name('mis.horarios');
Route::post('/generar-horarios', [HorarioController::class, 'generarHorarios'])->name('generar.horarios');
Route::get('/exportar-horarios', [HorarioController::class, 'exportarHorarios'])->name('exportar.horarios');
Route::get('/docentevista', [DocenteController::class, 'index'])->name('docentevista.index');
Route::get('/horarios/generar', [HorarioController::class, 'generar'])->name('horarios.generar');
