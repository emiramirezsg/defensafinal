<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horario Escolar Dinámico</title>
    <style>
        /* Fondo y estilo general */
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

        /* Tabla de horarios */
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

        /* Botones */
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

        .btn-regresar {
            background-color: #6c757d;
            color: #fff;
            margin-bottom: 20px;
            display: block;
            width: fit-content;
        }

        .btn-regresar:hover {
            background-color: #5a6268;
        }

        /* Diseño del encabezado */
        .header {
            display: flex;
            justify-content: flex-end;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="{{ route('home') }}" class="btn btn-regresar">Inicio</a>
    </div>

    <div class="container">
        <h1>Horario Escolar</h1>

        <div class="action-buttons">
            <a href="#" class="btn btn-agregar">Generar Horarios</a>

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
        </div>

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
                <tbody id="horario-body">
                    <!-- Sección dinámica de horarios -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // JavaScript para manejar datos dinámicos
        document.addEventListener('DOMContentLoaded', () => {
            const tbody = document.getElementById('horario-body');
            const periodos = @json($periodos);
            const horarios = @json($horarios);
            const paralelos = @json($paralelos);

            const horariosPorDia = { lunes: [], martes: [], miercoles: [], jueves: [], viernes: [] };

            periodos.forEach(periodo => {
                const dia = periodo.dia.toLowerCase();
                const horario = horarios.find(h => h.id === periodo.horario.id);
                const paralelo = paralelos.find(p => p.id === periodo.paralelo.id);

                if (horariosPorDia[dia]) {
                    horariosPorDia[dia].push({
                        hora: `${horario.hora_inicio} - ${horario.hora_fin}`,
                        materia: periodo.docente.materia.nombre,
                        curso: paralelo.curso.nombre,
                        paralelo: paralelo.nombre
                    });
                }
            });

            horarios.forEach(h => {
                const fila = document.createElement('tr');
                const tdHora = document.createElement('td');
                tdHora.textContent = `${h.hora_inicio} - ${h.hora_fin}`;
                fila.appendChild(tdHora);

                ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'].forEach(dia => {
                    const td = document.createElement('td');
                    const periodoDia = horariosPorDia[dia].find(p => p.hora === `${h.hora_inicio} - ${h.hora_fin}`);
                    td.innerHTML = periodoDia
                        ? `${periodoDia.materia} (${periodoDia.curso})<br><small>${periodoDia.paralelo}</small>`
                        : '';
                    fila.appendChild(td);
                });

                tbody.appendChild(fila);
            });
        });
    </script>
</body>
</html>
