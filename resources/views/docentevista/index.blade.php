<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horario Escolar</title>
    <style>
        /* Estilos */
        body {
            font-family: Arial, sans-serif;
            background: url('https://www.orientacionandujar.es/wp-content/uploads/2020/08/fondos-para-clases-virtuales-1.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 16px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .btn-agregar {
            background-color: #007bff;
            color: #fff;
        }

        .btn-agregar:hover {
            background-color: #0056b3;
        }

        .header {
            display: flex;
            justify-content: flex-end;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Horario Escolar</h1>

        <!-- Filtro de Docente -->
        <form method="GET" action="{{ route('horarios.index') }}" style="margin-top: 20px;">
            <label for="docente">Seleccionar Docente:</label>
            <select name="docente_id" id="docente">
                <option value="">Seleccionar Docente</option>
                @foreach($docentes as $docente)
                    <option value="{{ $docente->id }}" {{ request('docente_id') == $docente->id ? 'selected' : '' }}>
                        {{ $docente->nombre }} {{ $docente->apellido }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-agregar">Filtrar</button>
        </form>

        <!-- Tabla de Horarios -->
        <div class="horario-table">
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
                    @foreach($horariosPorDia as $dia => $horarios)
                        @foreach($horarios as $horario)
                            <tr>
                                <td>{{ $horario['hora'] }}</td>
                                <td>{{ $dia == 'lunes' ? $horario['materia'].'<br><small>'.$horario['curso'].' ('.$horario['paralelo'].')</small>' : '' }}</td>
                                <td>{{ $dia == 'martes' ? $horario['materia'].'<br><small>'.$horario['curso'].' ('.$horario['paralelo'].')</small>' : '' }}</td>
                                <td>{{ $dia == 'miercoles' ? $horario['materia'].'<br><small>'.$horario['curso'].' ('.$horario['paralelo'].')</small>' : '' }}</td>
                                <td>{{ $dia == 'jueves' ? $horario['materia'].'<br><small>'.$horario['curso'].' ('.$horario['paralelo'].')</small>' : '' }}</td>
                                <td>{{ $dia == 'viernes' ? $horario['materia'].'<br><small>'.$horario['curso'].' ('.$horario['paralelo'].')</small>' : '' }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
