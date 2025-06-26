<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horario Escolar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('https://www.orientacionandujar.es/wp-content/uploads/2020/08/fondos-para-clases-virtuales-1.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            text-align: center;
            padding: 10px;
            font-size: 14px;
        }

        th {
            background-color: #f4f4f4;
        }

        small {
            color: #555;
        }
    </style>
</head>
<body>
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 20px; background-color: rgba(255, 255, 255, 0.9); border-radius: 0 0 10px 10px;">
        <!-- Botón Logout -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" style="background-color: #e74c3c; color: white; border: none; padding: 8px 12px; border-radius: 5px; cursor: pointer;">
                Cerrar sesión
            </button>
        </form>

        <!-- Nombre del usuario -->
        <div style="font-weight: bold; color: #333;">
            {{ Auth::user()->name }}
        </div>
    </div>

    <div class="container">
        
        <h1>Horario Escolar</h1>

        <table> 
            <thead>
                <tr>
                    <th>Hora / Día</th>
                    <th>Lunes</th>
                    <th>Martes</th>
                    <th>Miércoles</th>
                    <th>Jueves</th>
                    <th>Viernes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($horariosPorHora as $hora => $dias)
                    <tr>
                        <td><strong>{{ $hora }}</strong></td>
                        @foreach(['lunes', 'martes', 'miercoles', 'jueves', 'viernes'] as $dia)
                            <td>
                                @if($dias[$dia])
                                    {{ $dias[$dia]->docente->materia->nombre }}<br>
                                    <small>{{ $dias[$dia]->paralelo->curso->nombre }} ({{ $dias[$dia]->paralelo->nombre }})</small>
                                @else
                                    -
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>