<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodoSeeder extends Seeder
{
    public function run()
    {
        DB::table('periodos')->insert([
            //Lunes
            ['dia' => 'lunes', 'hora_inicio' => '07:30', 'hora_fin' => '08:10'],
            ['dia' => 'lunes', 'hora_inicio' => '08:10', 'hora_fin' => '08:50'],
            ['dia' => 'lunes', 'hora_inicio' => '09:05', 'hora_fin' => '09:45'],
            ['dia' => 'lunes', 'hora_inicio' => '09:45', 'hora_fin' => '10:25'],
            ['dia' => 'lunes', 'hora_inicio' => '11:00', 'hora_fin' => '11:40'],
            ['dia' => 'lunes', 'hora_inicio' => '11:40', 'hora_fin' => '12:20'],
            ['dia' => 'lunes', 'hora_inicio' => '12:20', 'hora_fin' => '13:00'],
            //Martes
            ['dia' => 'martes', 'hora_inicio' => '07:30', 'hora_fin' => '08:10'],
            ['dia' => 'martes', 'hora_inicio' => '08:10', 'hora_fin' => '08:50'],
            ['dia' => 'martes', 'hora_inicio' => '09:05', 'hora_fin' => '09:45'],
            ['dia' => 'martes', 'hora_inicio' => '09:45', 'hora_fin' => '10:25'],
            ['dia' => 'martes', 'hora_inicio' => '11:00', 'hora_fin' => '11:40'],
            ['dia' => 'martes', 'hora_inicio' => '11:40', 'hora_fin' => '12:20'],
            ['dia' => 'martes', 'hora_inicio' => '12:20', 'hora_fin' => '13:00'],
            //miercoles
            ['dia' => 'miercoles', 'hora_inicio' => '07:30', 'hora_fin' => '08:10'],
            ['dia' => 'miercoles', 'hora_inicio' => '08:10', 'hora_fin' => '08:50'],
            ['dia' => 'miercoles', 'hora_inicio' => '09:05', 'hora_fin' => '09:45'],
            ['dia' => 'miercoles', 'hora_inicio' => '09:45', 'hora_fin' => '10:25'],
            ['dia' => 'miercoles', 'hora_inicio' => '11:00', 'hora_fin' => '11:40'],
            ['dia' => 'miercoles', 'hora_inicio' => '11:40', 'hora_fin' => '12:20'],
            ['dia' => 'miercoles', 'hora_inicio' => '12:20', 'hora_fin' => '13:00'],
            //jueves
            ['dia' => 'jueves', 'hora_inicio' => '07:30', 'hora_fin' => '08:10'],
            ['dia' => 'jueves', 'hora_inicio' => '08:10', 'hora_fin' => '08:50'],
            ['dia' => 'jueves', 'hora_inicio' => '09:05', 'hora_fin' => '09:45'],
            ['dia' => 'jueves', 'hora_inicio' => '09:45', 'hora_fin' => '10:25'],
            ['dia' => 'jueves', 'hora_inicio' => '11:00', 'hora_fin' => '11:40'],
            ['dia' => 'jueves', 'hora_inicio' => '11:40', 'hora_fin' => '12:20'],
            ['dia' => 'jueves', 'hora_inicio' => '12:20', 'hora_fin' => '13:00'],
            //viernes
            ['dia' => 'viernes', 'hora_inicio' => '07:30', 'hora_fin' => '08:10'],
            ['dia' => 'viernes', 'hora_inicio' => '08:10', 'hora_fin' => '08:50'],
            ['dia' => 'viernes', 'hora_inicio' => '09:05', 'hora_fin' => '09:45'],
            ['dia' => 'viernes', 'hora_inicio' => '09:45', 'hora_fin' => '10:25'],
            ['dia' => 'viernes', 'hora_inicio' => '11:00', 'hora_fin' => '11:40'],
            ['dia' => 'viernes', 'hora_inicio' => '11:40', 'hora_fin' => '12:20'],
            ['dia' => 'viernes', 'hora_inicio' => '12:20', 'hora_fin' => '13:00'],
            //sabado
            ['dia' => 'sabado', 'hora_inicio' => '07:30', 'hora_fin' => '08:10'],
            ['dia' => 'sabado', 'hora_inicio' => '08:10', 'hora_fin' => '08:50'],
            ['dia' => 'sabado', 'hora_inicio' => '09:05', 'hora_fin' => '09:45'],
            ['dia' => 'sabado', 'hora_inicio' => '09:45', 'hora_fin' => '10:25'],
            ['dia' => 'sabado', 'hora_inicio' => '11:00', 'hora_fin' => '11:40'],
            ['dia' => 'sabado', 'hora_inicio' => '11:40', 'hora_fin' => '12:20'],
            ['dia' => 'sabado', 'hora_inicio' => '12:20', 'hora_fin' => '13:00'],
        ]);
    }
}
