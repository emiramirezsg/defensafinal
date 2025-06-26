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
        .tabla-wrapper {
            background-color: rgba(255, 255, 255, 0.6);
            padding: 10px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="{{ route('home') }}" class="btn btn-agregar">Inicio</a>
    </div>
    <h1>Horario Escolar</h1>
    <div id="data-container"
     data-periodos='@json($periodos)'
     data-horarios='@json($horarios)'
     data-paralelos='@json($paralelos)'>
</div>
<div class="action-buttons">
    <button id="generar-horarios" class="btn btn-agregar">Generar Horarios</button>

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
    <table>
        <thead>
            <tr>
                <th>Día</th>
                <th>Horario</th>
            </tr>
        </thead>
        <tbody id="horario-body" class="tabla-wrapper">
        </tbody>
    </table>

    <script>
    function renderTable(data) {
        const { periodos, horarios, paralelos } = data;

        const tableHead = document.querySelector('table thead tr');
        const tbody = document.getElementById('horario-body');

        tableHead.innerHTML = `
            <th>Día</th>
            <th>Horario</th>
        `;
        tbody.innerHTML = '';
        paralelos.forEach(paralelo => {
            const th = document.createElement('th');
            th.textContent = `${paralelo.curso.nombre} ${paralelo.nombre}`;
            tableHead.appendChild(th);
        });

        const dias = [...new Set(periodos.map(periodo => periodo.dia))];

        dias.forEach(dia => {
            const periodosDia = periodos.filter(p => p.dia === dia);
            const horariosUnicos = [...new Set(periodosDia.map(p => p.horario.id))];

            horariosUnicos.forEach((horarioId, index) => {
                const horario = horarios.find(h => h.id === horarioId);
                const fila = document.createElement('tr');

                if (index === 0) {
                    const tdDia = document.createElement('td');
                    tdDia.textContent = dia;
                    tdDia.rowSpan = horariosUnicos.length;
                    fila.appendChild(tdDia);
                }

                const tdHorario = document.createElement('td');
                tdHorario.textContent = `${horario.hora_inicio} - ${horario.hora_fin}`;
                fila.appendChild(tdHorario);

                paralelos.forEach(paralelo => {
                    const tdParalelo = document.createElement('td');
                    const periodo = periodosDia.find(p =>
                        p.paralelo.id === paralelo.id &&
                        p.horario.id === horarioId
                    );


                    if (periodo) {
                        tdParalelo.textContent = `${periodo.docente.materia.nombre} - ${periodo.docente.nombre} ${periodo.docente.apellido}`;
                    } else {
                        tdParalelo.textContent = '';
                    }

                    fila.appendChild(tdParalelo);
                });

                tbody.appendChild(fila);
            });
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
