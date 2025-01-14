<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Cursos</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background: url('https://www.orientacionandujar.es/wp-content/uploads/2020/08/fondos-para-clases-virtuales-1.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }

        /* Estilos para las tarjetas de cursos */
        .cursos {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .curso-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.3s ease;
            position: relative;
            width: calc(33.333% - 20px);
            box-sizing: border-box;
        }

        .curso-card:hover {
            transform: translateY(-5px);
        }

        .curso-info h3 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 1.2em;
            color: #333;
        }

        .curso-info p {
            margin: 0;
            font-size: 1em;
            color: #666;
        }

        .botones {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            color: #fff;
            font-size: 0.9em;
            text-align: center;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .btn-editar {
            background-color: #28a745;
        }

        .btn-editar:hover {
            background-color: #218838;
        }

        .btn-eliminar {
            background-color: #dc3545;
        }

        .btn-eliminar:hover {
            background-color: #c82333;
        }

        .btn-agregar-paralelo {
            background-color: #ffc107;
        }

        .btn-agregar-paralelo:hover {
            background-color: #e0a800;
        }

        .btn-agregar-curso {
            background-color: #007bff;
        }

        .btn-agregar-curso:hover {
            background-color: #0056b3;
        }

        .btn-regresar, .btn-paralelos {
            background-color: #6c757d;
            font-size: 0.9em;
        }

        .btn-regresar {
            background-color: #6c757d;
            color: #fff;
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
        }

        .btn-regresar:hover, .btn-paralelos:hover {
            background-color: #5a6268;
        }

        .paralelos-list {
            margin-top: 10px;
        }

        .paralelo-item {
            background-color: #f8f9fa;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 5px;
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .btn-editar-paralelo, .btn-eliminar-paralelo {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: inline-block;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            transition: background-color 0.3s ease;
        }

        .btn-editar-paralelo {
            background-image: url('https://img.icons8.com/material-outlined/24/000000/edit--v1.png');
        }

        .btn-eliminar-paralelo {
            background-image: url('https://img.icons8.com/material-outlined/24/000000/delete-forever.png');
        }

        .btn-editar-paralelo:hover {
            background-color: #0056b3;
        }

        .btn-eliminar-paralelo:hover {
            background-color: #c82333;
        }

        /* Estilos para los modales */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 8px;
        }

        .modal-header, .modal-footer {
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .modal-header h2 {
            margin: 0;
        }

        .modal-footer {
            border-top: 1px solid #ddd;
            text-align: right;
        }

        .modal-close {
            float: right;
            font-size: 1.5em;
            cursor: pointer;
            color: #000;
        }

        .modal-close:hover {
            color: #dc3545;
        }

        .modal-body {
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <a href="{{ route('home') }}" class="btn btn-regresar">Inicio</a>

    <div class="container">
        <h2>Lista de Cursos</h2>
        <div class="cursos">
            @foreach($cursos as $curso)
            <div class="curso-card">
                <div class="curso-info">
                    <h3>{{ $curso->nombre }}</h3>
                    <p><strong>Paralelos:</strong></p>
                    <div class="paralelos-list">
                        @forelse($curso->paralelos as $paralelo)
                        <div class="paralelo-item">
                            {{ $paralelo->nombre }} - Cantidad de Estudiantes: {{ $paralelo->cantidad_est }}
                            <div class="botones">
                                <a href="#modalEditarParalelo" class="btn-editar-paralelo open-modal" data-paralelo-id="{{ $paralelo->id }}" data-paralelo-nombre="{{ $paralelo->nombre }}" data-paralelo-cantidad="{{ $paralelo->cantidad_est }}" title="Editar Paralelo"></a>
                                <form action="{{ route('paralelos.destroy', $paralelo->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-eliminar-paralelo" onclick="return confirm('¿Estás seguro de querer eliminar este paralelo?')" title="Eliminar Paralelo"></button>
                                </form>
                            </div>
                        </div>
                        @empty
                        <p>No hay paralelos asignados a este curso.</p>
                        @endforelse
                    </div>
                </div>
                <div class="botones">
                    <a href="#modalAgregarParalelo" class="btn btn-agregar-paralelo open-modal" data-curso-id="{{ $curso->id }}">Agregar Paralelo</a>
                    <a href="#modalEditarCurso" class="btn btn-editar open-modal" data-curso-id="{{ $curso->id }}" data-curso-nombre="{{ $curso->nombre }}">Editar Curso</a>
                    <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-eliminar" onclick="return confirm('¿Estás seguro de querer eliminar este curso?')">Eliminar Curso</button>
                    </form>
                    <a href="#modalAgregarMateria" class="btn btn-agregar-materia open-modal" data-curso-id="{{ $curso->id }}">Agregar Materia</a>
                </div>
            </div>
            @endforeach
        </div>
        <a href="#modalAgregarCurso" class="btn btn-agregar-curso open-modal">Agregar Curso</a>
    </div>

    <!-- Modal para agregar curso -->
    <div id="modalAgregarCurso" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-close">&times;</span>
                <h2>Agregar Curso</h2>
            </div>
            <div class="modal-body">
                <form action="{{ route('cursos.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre del Curso:</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-agregar-curso">Agregar Curso</button>
                        <button type="button" class="btn btn-cancelar modal-close">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Agregar Paralelo -->
    <div id="modalAgregarParalelo" class="modal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <div class="modal-header">
                <h2>Agregar Paralelo</h2>
            </div>
            <div class="modal-body">
                <form action="{{ route('paralelos.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="curso_id" id="curso-id">
                    <div class="form-group">
                        <label for="paralelo-nombre">Nombre del Paralelo:</label>
                        <input type="text" id="paralelo-nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="paralelo-cantidad">Cantidad de Estudiantes:</label>
                        <input type="number" id="paralelo-cantidad" name="cantidad_est" required>
                    </div>
                    <button type="submit" class="btn btn-agregar-curso">Agregar Paralelo</button>
                    <button type="button" class="btn btn-cancelar modal-close">Cancelar</button>
                </form>
            </div>
        </div>
    </div>

<!-- Modal Agregar Materia -->
<div id="modalAgregarMateria" class="modal">
    <div class="modal-content">
        <span class="modal-close">&times;</span>
        <div class="modal-header">
            <h2>Agregar Materia</h2>
        </div>
        <div class="modal-body">
            <form action="{{ route('materias.store') }}" method="POST">
                @csrf
                <input type="hidden" name="curso_id" id="curso-id-materia">
                <div class="form-group">
                    <label for="materia-nombre">Nombre de la Materia:</label>
                    <input type="text" id="materia-nombre" name="nombre" required>
                </div>
                <div>
                    <label for="horas_semana">Horas por Semana:</label>
                    <input type="number" name="horas_semana" id="horas_semana" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-agregar-curso">Agregar Materia</button>
                    <button type="button" class="btn btn-cancelar modal-close">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <!-- Modal Editar Curso -->
    <div id="modalEditarCurso" class="modal">
    <div class="modal-content">
        <span class="modal-close">&times;</span>
        <div class="modal-header">
            <h2>Editar Curso</h2>
        </div>
        <div class="modal-body">
            <form action="{{ route('cursos.update', ['curso' => 'CURSO_ID']) }}" method="POST" id="form-editar-curso">
                @csrf
                @method('PUT')
                <input type="hidden" name="curso_id" id="curso-id-editar">
                <div class="form-group">
                    <label for="curso-nombre">Nombre del Curso:</label>
                    <input type="text" id="curso-nombre" name="nombre" required>
                </div>
                <button type="submit" class="btn btn-editar">Actualizar Curso</button>
                <button type="button" class="btn btn-cancelar modal-close">Cancelar</button>
            </form>
        </div>
    </div>
</div>
  </div>
        </div>
    </div>

    <!-- Modal Editar Paralelo -->
    <div id="modalEditarParalelo" class="modal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <div class="modal-header">
                <h2>Editar Paralelo </h2>
            </div>
            <div class="modal-body">
            <form action="{{ route('paralelos.update', ['paralelo' => 'PARALELO_ID']) }}" method="POST" id="form-editar-paralelo">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="paralelo-nombre-editar">Nombre del Paralelo:</label>
                        <input type="text" id="paralelo-nombre-editar" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="paralelo-cantidad-editar">Cantidad de Estudiantes:</label>
                        <input type="number" id="paralelo-cantidad-editar" name="cantidad_est" required>
                    </div>
                    <button type="submit" class="btn btn-editar">Actualizar Paralelo</button>
                    <button type="button" class="btn btn-cancelar modal-close">Cancelar</button>
                </form>
            </div>
        </div>
    </div>


    <script>
    document.querySelectorAll('.open-modal').forEach(button => {
        button.addEventListener('click', event => {
            event.preventDefault();

            const targetModal = document.querySelector(button.getAttribute('href'));
            if (!targetModal) return;

            targetModal.style.display = 'block';

            const cursoId = button.getAttribute('data-curso-id');
            const paraleloId = button.getAttribute('data-paralelo-id');
            const paraleloNombre = button.getAttribute('data-paralelo-nombre');
            const paraleloCantidad = button.getAttribute('data-paralelo-cantidad');

            if (cursoId) {
                const cursoInput = targetModal.querySelector('#curso-id, #curso-id-asignar, #curso-id-materia');
                if (cursoInput) cursoInput.value = cursoId;
            }

            if (paraleloId) {
            const formEditarParalelo = document.getElementById('form-editar-paralelo');
            if (formEditarParalelo) {
                const actionUrl = formEditarParalelo.getAttribute('action').replace('PARALELO_ID', paraleloId);
                formEditarParalelo.setAttribute('action', actionUrl);
            }
        }
            if (paraleloId) {
                const paraleloIdInput = targetModal.querySelector('#paralelo-id-editar');
                const paraleloNombreInput = targetModal.querySelector('#paralelo-nombre-editar');
                const paraleloCantidadInput = targetModal.querySelector('#paralelo-cantidad-editar');
                if (paraleloIdInput) paraleloIdInput.value = paraleloId;
                if (paraleloNombreInput) paraleloNombreInput.value = paraleloNombre;
                if (paraleloCantidadInput) paraleloCantidadInput.value = paraleloCantidad;
            }
        });
    });

    document.querySelectorAll('.modal-close').forEach(closeButton => {
        closeButton.addEventListener('click', () => {
            const modal = closeButton.closest('.modal');
            if (modal) modal.style.display = 'none';
        });
    });

    window.addEventListener('click', event => {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    });
</script>
<script>
    document.querySelectorAll('.open-modal').forEach(button => {
        button.addEventListener('click', event => {
            event.preventDefault();

            const targetModal = document.querySelector(button.getAttribute('href'));
            if (!targetModal) return;

            // Muestra el modal
            targetModal.style.display = 'block';

            // Obtén los atributos de datos del botón
            const cursoId = button.getAttribute('data-curso-id');
            const cursoNombre = button.getAttribute('data-curso-nombre');
            const cursoDescripcion = button.getAttribute('data-curso-descripcion'); // Agregar otros campos si existen

            // Llena los campos del formulario en el modal
            if (cursoId) {
                const formEditarCurso = targetModal.querySelector('#form-editar-curso');
                if (formEditarCurso) {
                    const actionUrl = formEditarCurso.getAttribute('action').replace('CURSO_ID', cursoId);
                    formEditarCurso.setAttribute('action', actionUrl);
                }

                const cursoIdInput = targetModal.querySelector('#curso-id');
                const cursoNombreInput = targetModal.querySelector('#curso-nombre');
                const cursoDescripcionInput = targetModal.querySelector('#curso-descripcion'); // Si hay descripción
                
                if (cursoIdInput) cursoIdInput.value = cursoId;
                if (cursoNombreInput) cursoNombreInput.value = cursoNombre;
                if (cursoDescripcionInput) cursoDescripcionInput.value = cursoDescripcion;
            }
        });
    });

    // Cierra el modal al hacer clic en el botón de cerrar
    document.querySelectorAll('.modal-close').forEach(closeButton => {
        closeButton.addEventListener('click', () => {
            const modal = closeButton.closest('.modal');
            if (modal) modal.style.display = 'none';
        });
    });

    // Cierra el modal al hacer clic fuera del contenido
    window.addEventListener('click', event => {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    });
</script>

</body>
</html>
