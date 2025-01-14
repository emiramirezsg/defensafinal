<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Paralelos</title>
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

        /* Estilos para los botones */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin: 10px;
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

        .btn-agregar-paralelo {
            background-color: #007bff;
            color: #fff;
        }

        .btn-agregar-paralelo:hover {
            background-color: #0056b3;
        }

        .btn-editar {
            background-color: #28a745;
            color: #fff;
        }

        .btn-editar:hover {
            background-color: #218838;
        }

        .btn-eliminar {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-eliminar:hover {
            background-color: #c82333;
        }

        .btn-cancelar {
            background-color: #6c757d;
            color: #fff;
        }

        .btn-cancelar:hover {
            background-color: #5a6268;
        }

        .btn-submit {
            background-color: #007bff;
            color: #fff;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        /* Estilos para las tarjetas de paralelos */
        .paralelos {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .paralelo-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.3s ease;
            width: calc(33.333% - 20px); /* Ajustar el ancho y espacio entre tarjetas */
            box-sizing: border-box; /* Asegura que el padding no afecte al ancho total */
        }

        .paralelo-card:hover {
            transform: translateY(-5px);
        }

        .paralelo-info h3 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 1.2em;
            color: #333;
        }

        .paralelo-info p {
            margin: 0;
            font-size: 1em;
            color: #666;
        }

        .botones {
            display: flex;
            gap: 10px;
            margin-top: 10px;
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

        /* Ajustes para tamaños de pantalla más pequeñas */
        @media (max-width: 768px) {
            .paralelo-card {
                width: calc(50% - 20px);
            }
        }

        @media (max-width: 480px) {
            .paralelo-card {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <a href="{{ route('home') }}" class="btn btn-regresar">Inicio</a>
    
    <div class="container">
        <h2>Lista de Paralelos</h2>
        <a href="#modalAgregarParalelo" class="btn btn-agregar-paralelo open-modal" data-modal="modalAgregarParalelo">Crear Paralelo</a>
        <div class="paralelos">
            @foreach($paralelos as $paralelo)
            <div class="paralelo-card">
                <div class="paralelo-info">
                    <h3>{{ $paralelo->nombre }}</h3>
                    <p><strong>Cantidad de Estudiantes:</strong> {{ $paralelo->cantidad_est }}</p>
                    <p><strong>Curso:</strong> {{ $paralelo->curso->nombre }}</p>
                </div>
                <div class="botones">
                    <a href="#modalEditarParalelo" class="btn btn-editar open-modal" data-paralelo-id="{{ $paralelo->id }}" data-paralelo-nombre="{{ $paralelo->nombre }}" data-paralelo-cantidad="{{ $paralelo->cantidad_est }}" title="Editar Paralelo" data-modal="modalEditarParalelo">Editar</a>
                    <form action="{{ route('paralelos.destroy', $paralelo->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-eliminar" onclick="return confirm('¿Estás seguro de querer eliminar este paralelo?')" title="Eliminar Paralelo">Eliminar</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
         
    <!-- Modal Agregar Paralelo -->
    <div id="modalAgregarParalelo" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-close" onclick="closeModal('modalAgregarParalelo')">&times;</span>
                <h2>Agregar Paralelo</h2>
            </div>
            <div class="modal-body">
                <form id="formAgregarParalelo" method="POST" action="{{ route('paralelos.store') }}">
                    @csrf
                    <input type="hidden" id="curso-id" name="curso_id">
                    <div class="form-group">
                        <label for="nombre-paralelo">Nombre del Paralelo</label>
                        <input type="text" id="nombre-paralelo" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="cantidad-estudiantes">Cantidad de Estudiantes</label>
                        <input type="number" id="cantidad-estudiantes" name="cantidad_est" required>
                    </div>
                    <button type="submit" class="btn btn-submit">Agregar</button>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-cancelar" onclick="closeModal('modalAgregarParalelo')">Cancelar</button>
            </div>
        </div>
    </div>

    <!-- Modal Editar Paralelo -->
    <div id="modalEditarParalelo" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-close" onclick="closeModal('modalEditarParalelo')">&times;</span>
                <h2>Editar Paralelo</h2>
            </div>
            <div class="modal-body">
                <form id="formEditarParalelo" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit-paralelo-id" name="id">
                    <div class="form-group">
                        <label for="edit-nombre-paralelo">Nombre del Paralelo</label>
                        <input type="text" id="edit-nombre-paralelo" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-cantidad-estudiantes">Cantidad de Estudiantes</label>
                        <input type="number" id="edit-cantidad-estudiantes" name="cantidad_est" required>
                    </div>
                    <button type="submit" class="btn btn-submit">Actualizar</button>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-cancelar" onclick="closeModal('modalEditarParalelo')">Cancelar</button>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.open-modal').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const modalId = button.getAttribute('data-modal');
                const modal = document.getElementById(modalId);

                if (modalId === 'modalEditarParalelo') {
                    const paraleloId = button.getAttribute('data-paralelo-id');
                    const paraleloNombre = button.getAttribute('data-paralelo-nombre');
                    const paraleloCantidad = button.getAttribute('data-paralelo-cantidad');

                    document.getElementById('edit-paralelo-id').value = paraleloId;
                    document.getElementById('edit-nombre-paralelo').value = paraleloNombre;
                    document.getElementById('edit-cantidad-estudiantes').value = paraleloCantidad;
                    document.getElementById('formEditarParalelo').action = `/paralelos/${paraleloId}`;
                } else if (modalId === 'modalAgregarParalelo') {
                    document.getElementById('formAgregarParalelo').reset();
                }

                modal.style.display = 'block';
            });
        });

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }
    </script>
</body>
</html>
