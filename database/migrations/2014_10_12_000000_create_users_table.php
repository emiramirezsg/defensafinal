<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('user');
            $table->rememberToken();
            $table->timestamps();
        });
        DB::table('users')->insert([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password'), // Cambia 'password' por la contraseña que prefieras
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear 17 usuarios con rol 'docente'
        $docentes = [
            ['name' => 'Alice.Smith', 'email' => 'alicesmith@example.com'],
            ['name' => 'Bob.Johnson', 'email' => 'bobjohnson@example.com'],
            ['name' => 'Charlie.Brown', 'email' => 'charliebrown@example.com'],
            ['name' => 'David.Wilson', 'email' => 'davidwilson@example.com'],
            ['name' => 'Eva.Davis', 'email' => 'evadavis@example.com'],
            ['name' => 'Frank.Miller', 'email' => 'frankmiller@example.com'],
            ['name' => 'Grace.Lee', 'email' => 'gracelee@example.com'],
            ['name' => 'Hannah.Walker', 'email' => 'hannahwalker@example.com'],
            ['name' => 'Ian.Hall', 'email' => 'ianhall@example.com'],
            ['name' => 'Jane.Allen', 'email' => 'janeallen@example.com'],
            ['name' => 'Kyle.Young', 'email' => 'kyleyoung@example.com'],
            ['name' => 'Laura.King', 'email' => 'lauraking@example.com'],
            ['name' => 'Mike.Scott', 'email' => 'mikescott@example.com'],
            ['name' => 'Nina.Wright', 'email' => 'ninawright@example.com'],
            ['name' => 'Oscar.Harris', 'email' => 'oscarharris@example.com'],
            ['name' => 'Paul.Green', 'email' => 'paulgreen@example.com'],
            ['name' => 'Quinn.Turner', 'email' => 'quinnturner@example.com'],
        ];

        foreach ($docentes as $docente) {
            DB::table('users')->insert([
                'name' => $docente['name'],
                'email' => $docente['email'],
                'password' => Hash::make('password'), // Cambia 'password' por la contraseña que prefieras
                'role' => 'docente',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        Schema::create('aulas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('cantidad_sillas');
            $table->string('cantidad_mesas');
            $table->timestamps();
        });

        $aulas = [];

        for ($i = 1; $i <= 12; $i++) {
            $aulas[] = [
                'nombre' => 'Aula ' . $i,
                'cantidad_sillas' => 30,
                'cantidad_mesas' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('aulas')->insert($aulas);

        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('hrs_trabajo');
            $table->timestamps();
        });

        DB::table('categorias')->insert([
            ['nombre' => 'merito', 'hrs_trabajo' => '120'],
            ['nombre' => 'primera', 'hrs_trabajo' => '116'],
            ['nombre' => 'segunda', 'hrs_trabajo' => '112'],
            ['nombre' => 'tercera', 'hrs_trabajo' => '108'],
            ['nombre' => 'cuarta', 'hrs_trabajo' => '104'],
            ['nombre' => 'quinta', 'hrs_trabajo' => '100'],
        ]);



        Schema::create('materias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        DB::table('materias')->insert([
            ['nombre' => 'Ciencias Sociales'],
            ['nombre' => 'Biologia Geografia'],
            ['nombre' => 'Matematicas'],
            ['nombre' => 'Lengua Castellana y Originaria'],
            ['nombre' => 'Educacion Musical'],
            ['nombre' => 'Educacion fisica'],
            ['nombre' => 'Fisica'],
            ['nombre' => 'Quimica'],
            ['nombre' => 'Cosmos Visiones, Filosofia y Psicologia'],
            ['nombre' => 'Tecnica tecnologica general'],
            ['nombre' => 'Tecnica tecnologica especializada'],
            ['nombre' => 'Artes Plasticas y Visuales'],
            ['nombre' => 'Valores Espirituales y Religiones'],
            ['nombre' => 'Lengua Extranjera'],
        ]);

        Schema::create('docentes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('email');
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('materia_id')->constrained('materias')->onDelete('cascade');
            $table->timestamps();
        });

        $categoriaId = DB::table('categorias')->where('nombre', 'merito')->value('id');
        $materias = [
            'Lengua Castellana y Originaria' => DB::table('materias')->where('nombre', 'Lengua Castellana y Originaria')->value('id'),
            'Ciencias Sociales' => DB::table('materias')->where('nombre', 'Ciencias Sociales')->value('id'),
            'Matemáticas' => DB::table('materias')->where('nombre', 'Matematicas')->value('id'),
            'Biologia Geografia' => DB::table('materias')->where('nombre', 'Biologia Geografia')->value('id'),
            'Educacion Musical' => DB::table('materias')->where('nombre', 'Educacion Musical')->value('id'),
            'Educacion fisica' => DB::table('materias')->where('nombre', 'Educacion fisica')->value('id'),
            'Fisica' => DB::table('materias')->where('nombre', 'Fisica')->value('id'),
            'Quimica' => DB::table('materias')->where('nombre', 'Quimica')->value('id'),
            'Cosmos Visiones, Filosofia y Psicologia' => DB::table('materias')->where('nombre', 'Cosmos Visiones, Filosofia y Psicologia')->value('id'),
            'Tecnica tecnologica general' => DB::table('materias')->where('nombre', 'Tecnica tecnologica general')->value('id'),
            'Tecnica tecnologica especializada' => DB::table('materias')->where('nombre', 'Tecnica tecnologica especializada')->value('id'),
            'Artes Plasticas y Visuales' => DB::table('materias')->where('nombre', 'Artes Plasticas y Visuales')->value('id'),
            'Valores Espirituales y Religiones' => DB::table('materias')->where('nombre', 'Valores Espirituales y Religiones')->value('id'),
            'Lengua Extranjera' => DB::table('materias')->where('nombre', 'Lengua Extranjera')->value('id'),
        ];

        // Lista de usuarios docentes (ID de usuarios)
        $docenteUserIds = [
            2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18
        ];

        // Asignar 2 docentes a las primeras 3 materias
        $asignaciones = [
            ['materia_id' => $materias['Lengua Castellana y Originaria'], 'docentes' => [0, 1]],
            ['materia_id' => $materias['Ciencias Sociales'], 'docentes' => [2, 3]],
            ['materia_id' => $materias['Matemáticas'], 'docentes' => [4, 5]],
        ];

        // Asignar 1 docente a las demás materias
        $indexOffset = 6;
        foreach (array_slice(array_values($materias), 3) as $index => $materia_id) {
            $asignaciones[] = ['materia_id' => $materia_id, 'docentes' => [$index + $indexOffset]];
        }

        // Insertar los registros de docentes
        $nombres = [
            'Alice', 'Bob', 'Charlie', 'David', 'Eva', 'Frank', 'Grace', 'Hannah', 'Ian', 'Jane', 'Kyle', 'Laura', 'Mike', 'Nina', 'Oscar', 'Paul', 'Quinn'
        ];

        $apellidos = [
            'Smith', 'Johnson', 'Brown', 'Wilson', 'Davis', 'Miller', 'Lee', 'Walker', 'Hall', 'Allen', 'Young', 'King', 'Scott', 'Wright', 'Harris', 'Green', 'Turner'
        ];

        foreach ($asignaciones as $asignacion) {
            foreach ($asignacion['docentes'] as $index) {
                DB::table('docentes')->insert([
                    'nombre' => $nombres[$index],
                    'apellido' => $apellidos[$index],
                    'email' => strtolower($nombres[$index]) . strtolower($apellidos[$index]) . '@example.com',
                    'categoria_id' => $categoriaId,
                    'user_id' => $docenteUserIds[$index],
                    'materia_id' => $asignacion['materia_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        DB::table('cursos')->insert([
            ['nombre' => '1ro'],
            ['nombre' => '2do'],
            ['nombre' => '3ro'],
            ['nombre' => '4to'],
            ['nombre' => '5to'],
            ['nombre' => '6to'],
        ]);

        Schema::create('materia_curso', function (Blueprint $table){
            $table->id();
            $table->integer('cantidad_horas_mensuales');
            $table->foreignId('materia_id')->constrained('materias');
            $table->foreignId('curso_id')->constrained('cursos');
            $table->timestamps();
        });

        DB::table('materia_curso')->insert([
            // Primer curso - 112 horas
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '1', 'curso_id' => '1'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '2', 'curso_id' => '1'],
            ['cantidad_horas_mensuales' => '12', 'materia_id' => '3', 'curso_id' => '1'],
            ['cantidad_horas_mensuales' => '16', 'materia_id' => '4', 'curso_id' => '1'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '5', 'curso_id' => '1'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '6', 'curso_id' => '1'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '9', 'curso_id' => '1'],
            ['cantidad_horas_mensuales' => '16', 'materia_id' => '10', 'curso_id' => '1'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '13', 'curso_id' => '1'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '14', 'curso_id' => '1'],

            // Segundo curso - 114 horas
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '1', 'curso_id' => '2'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '2', 'curso_id' => '2'],
            ['cantidad_horas_mensuales' => '12', 'materia_id' => '3', 'curso_id' => '2'],
            ['cantidad_horas_mensuales' => '16', 'materia_id' => '4', 'curso_id' => '2'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '5', 'curso_id' => '2'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '6', 'curso_id' => '2'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '9', 'curso_id' => '2'],
            ['cantidad_horas_mensuales' => '16', 'materia_id' => '10', 'curso_id' => '2'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '13', 'curso_id' => '2'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '14', 'curso_id' => '2'],

            // Tercer curso - 116 horas
            ['cantidad_horas_mensuales' => '12', 'materia_id' => '1', 'curso_id' => '3'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '2', 'curso_id' => '3'],
            ['cantidad_horas_mensuales' => '12', 'materia_id' => '3', 'curso_id' => '3'],
            ['cantidad_horas_mensuales' => '16', 'materia_id' => '4', 'curso_id' => '3'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '5', 'curso_id' => '3'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '6', 'curso_id' => '3'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '7', 'curso_id' => '3'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '8', 'curso_id' => '3'],
            ['cantidad_horas_mensuales' => '16', 'materia_id' => '10', 'curso_id' => '3'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '13', 'curso_id' => '3'],

            // Cuarto curso - 118 horas
            ['cantidad_horas_mensuales' => '12', 'materia_id' => '1', 'curso_id' => '4'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '2', 'curso_id' => '4'],
            ['cantidad_horas_mensuales' => '12', 'materia_id' => '3', 'curso_id' => '4'],
            ['cantidad_horas_mensuales' => '12', 'materia_id' => '4', 'curso_id' => '4'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '5', 'curso_id' => '4'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '6', 'curso_id' => '4'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '7', 'curso_id' => '4'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '8', 'curso_id' => '4'],
            ['cantidad_horas_mensuales' => '32', 'materia_id' => '10', 'curso_id' => '4'],

            // Quinto curso - 120 horas
            ['cantidad_horas_mensuales' => '22', 'materia_id' => '1', 'curso_id' => '5'],
            ['cantidad_horas_mensuales' => '14', 'materia_id' => '2', 'curso_id' => '5'],
            ['cantidad_horas_mensuales' => '20', 'materia_id' => '3', 'curso_id' => '5'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '5', 'curso_id' => '5'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '6', 'curso_id' => '5'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '7', 'curso_id' => '5'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '8', 'curso_id' => '5'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '9', 'curso_id' => '5'],
            ['cantidad_horas_mensuales' => '28', 'materia_id' => '11', 'curso_id' => '5'],

            // Sexto curso - 120 horas
            ['cantidad_horas_mensuales' => '22', 'materia_id' => '1', 'curso_id' => '6'],
            ['cantidad_horas_mensuales' => '14', 'materia_id' => '2', 'curso_id' => '6'],
            ['cantidad_horas_mensuales' => '20', 'materia_id' => '3', 'curso_id' => '6'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '5', 'curso_id' => '6'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '6', 'curso_id' => '6'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '7', 'curso_id' => '6'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '8', 'curso_id' => '6'],
            ['cantidad_horas_mensuales' => '8', 'materia_id' => '9', 'curso_id' => '6'],
            ['cantidad_horas_mensuales' => '28', 'materia_id' => '11', 'curso_id' => '6'],
        ]);

        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->timestamps();
        });

        DB::table('horarios')->insert([
            ['hora_inicio' => '07:30', 'hora_fin' => '08:10'],
            ['hora_inicio' => '08:10', 'hora_fin' => '08:50'],
            ['hora_inicio' => '09:05', 'hora_fin' => '09:45'],
            ['hora_inicio' => '09:45', 'hora_fin' => '10:25'],
            ['hora_inicio' => '11:00', 'hora_fin' => '11:40'],
            ['hora_inicio' => '11:40', 'hora_fin' => '12:20'],
            ['hora_inicio' => '12:20', 'hora_fin' => '13:00'],
        ]);

        Schema::create('paralelos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('cantidad_est')->default(0);
            $table->foreignId('curso_id')->constrained('cursos');
            $table->timestamps();
        });
        DB::table('paralelos')->insert([
            ['nombre' => 'A','cantidad_est' => 24, 'curso_id' => 1],
            ['nombre' => 'B','cantidad_est' => 24, 'curso_id' => 1],
            ['nombre' => 'A','cantidad_est' => 24, 'curso_id' => 2],
            ['nombre' => 'B','cantidad_est' => 24, 'curso_id' => 2],
            ['nombre' => 'A','cantidad_est' => 24, 'curso_id' => 3],
            ['nombre' => 'B','cantidad_est' => 24, 'curso_id' => 3],
            ['nombre' => 'A','cantidad_est' => 24, 'curso_id' => 4],
            ['nombre' => 'B','cantidad_est' => 24, 'curso_id' => 4],
            ['nombre' => 'A','cantidad_est' => 24, 'curso_id' => 5],
            ['nombre' => 'B','cantidad_est' => 24, 'curso_id' => 5],
            ['nombre' => 'A','cantidad_est' => 24, 'curso_id' => 6],
            ['nombre' => 'B','cantidad_est' => 24, 'curso_id' => 6],
        ]);


        Schema::create('periodos', function (Blueprint $table) {
            $table->id();
            $table->string('dia');
            $table->foreignId('horario_id')->constrained('horarios')->onDelete('cascade');
            $table->foreignId('docente_id')->constrained('docentes')->onDelete('cascade');
            $table->foreignId('paralelo_id')->constrained('paralelos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('periodos');
        Schema::dropIfExists('paralelos');
        Schema::dropIfExists('horarios');
        Schema::dropIfExists('materia_curso');
        Schema::dropIfExists('cursos');
        Schema::dropIfExists('docentes');
        Schema::dropIfExists('materias');
        Schema::dropIfExists('categorias');
        Schema::dropIfExists('aulas');
        Schema::dropIfExists('users');
    }
}
