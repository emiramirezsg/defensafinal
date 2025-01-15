<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horario Escolar Dinámico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
        }

        th, td {
            border: 1px solid #ccc;
            text-align: center;
            padding: 8px;
            font-size: 14px;
        }

        th {
            background-color: #f4f4f4;
        }

        .paralelo {
            font-size: 12px;
            line-height: 1.2;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .horario-table {
            margin-top: 20px;
        }

        .horario-table th {
            background-color: #dddddd;
        }

        .action-buttons {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .action-buttons form {
            display: flex;
            gap: 10px;
        }

        .action-buttons button {
            margin-left: 10px;
        }

        select {
            padding: 5px;
            font-size: 14px;
        }

        .regresar-button {
            background-color: #f44336; /* Rojo */
        }

        .regresar-button:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
    <h1>Horario Escolar</h1>

    <div class="action-buttons">
        <!-- Botón Generar Horarios -->
        <button id="generar-horarios">Generar Horarios</button>

        <!-- Filtro de Docente -->
        <form method="GET" action="{{ route('horarios.index') }}">
            <label for="docente">Seleccionar Docente:</label>
            <select name="docente_id" id="docente">
                <option value="">Seleccionar Docente</option>
                @foreach($docentes as $docente)
                    <option value="{{ $docente->id }}" {{ request('docente_id') == $docente->id ? 'selected' : '' }}>
                        {{ $docente->nombre }} {{ $docente->apellido }}
                    </option>
                @endforeach
            </select>
            <button type="submit">Filtrar</button>
        </form>
    </div>

    <div id="data-container"
         data-periodos='@json($periodos)'
         data-horarios='@json($horarios)'
         data-paralelos='@json($paralelos)'>
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
            </tbody>
        </table>
    </div>

    <script>
    function renderTable(data) {
        const { periodos, horarios, paralelos } = data;

        const tbody = document.getElementById('horario-body');
        tbody.innerHTML = '';

        // Crear un objeto para almacenar los horarios por día
        const horariosPorDia = {
            lunes: [],
            martes: [],
            miercoles: [],
            jueves: [],
            viernes: []
        };

        periodos.forEach(periodo => {
            const dia = periodo.dia.toLowerCase(); // 'Lunes', 'Martes', etc.
            const horario = horarios.find(h => h.id === periodo.horario.id);
            const paralelo = paralelos.find(p => p.id === periodo.paralelo.id);

            if (horariosPorDia[dia]) {
                horariosPorDia[dia].push({
                    hora: `${horario.hora_inicio} - ${horario.hora_fin}`,
                    materia: periodo.docente.materia.nombre,
                    curso: paralelo.curso.nombre,
                    paralelo: paralelo.nombre, // Mostrar el nombre del paralelo
                    docente: `${periodo.docente.nombre} ${periodo.docente.apellido}`
                });
            }
        });

        // Rellenar la tabla con los datos
        const horasUnicas = [...new Set(periodos.map(p => p.horario.id))];
        horasUnicas.forEach(horaId => {
            const horario = horarios.find(h => h.id === horaId);
            const fila = document.createElement('tr');

            const tdHora = document.createElement('td');
            tdHora.textContent = `${horario.hora_inicio} - ${horario.hora_fin}`;
            fila.appendChild(tdHora);

            // Agregar cada día de la semana
            ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'].forEach(dia => {
                const tdDia = document.createElement('td');
                const periodosDia = horariosPorDia[dia].filter(p => p.hora === `${horario.hora_inicio} - ${horario.hora_fin}`);

                if (periodosDia.length > 0) {
                    const periodo = periodosDia[0];  // Tomamos el primer periodo
                    tdDia.innerHTML = `${periodo.materia} (${periodo.curso})<br><small>${periodo.paralelo}</small>`;
                } else {
                    tdDia.textContent = '';
                }

                fila.appendChild(tdDia);
            });

            tbody.appendChild(fila);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('data-container');
        const data = {
            periodos: JSON.parse(container.getAttribute('data-periodos')),
            horarios: JSON.parse(container.getAttribute('data-horarios')),
            paralelos: JSON.parse(container.getAttribute('data-paralelos')),
        };
        renderTable(data);
    });

    document.getElementById('generar-horarios').addEventListener('click', function () {
        fetch("{{ route('generar.horarios') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                renderTable(data);
            } else {
                console.error('Error al generar horarios:', data);
            }
        })
        .catch(error => console.error('Error:', error));
    });
    </script>
</body>
</html>
