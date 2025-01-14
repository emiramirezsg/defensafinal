<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Docente</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('https://www.orientacionandujar.es/wp-content/uploads/2020/08/fondos-para-clases-virtuales-1.jpg') no-repeat center center fixed;
            background-size: cover;
            background-position: center;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.8); /* Fondo blanco con opacidad */
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 500px;
            margin: 0 auto;
            margin-top: 50px; /* Espacio superior para centrar verticalmente */
        }

        .form-container h2 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 1.5em;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 1em;
            color: #333;
            margin-bottom: 5px;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-submit {
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: inline-block;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background-color: #218838;
        }

        .btn-back {
            padding: 10px 20px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: inline-block;
            margin-top: 10px;
            margin-left: 10px;
        }

        .btn-back:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Editar Docente</h2>
        <form action="{{ route('docentes.update', $docente->id) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- Campos para el docente -->
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{ $docente->nombre }}" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" value="{{ $docente->apellido }}" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" value="{{ $docente->email }}" required>
            </div>
            <div class="form-group">
                <label for="categoria_id">Categoría</label>
                <select id="categoria_id" name="categoria_id" required>
                    @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ $docente->categoria_id == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                @for ($i = 1; $i <= 2; $i++)
                    <div style="margin-bottom: 15px;">
                        <label for="dia_libre_{{ $i }}">Día libre {{ $i }}</label>
                        <select name="dias_libres[]" id="dia_libre_{{ $i }}" class="form-control">
                            <option value="" selected disabled>Selecciona un día</option>
                            <option value="Lunes">Lunes</option>
                            <option value="Martes">Martes</option>
                            <option value="Miércoles">Miércoles</option>
                            <option value="Jueves">Jueves</option>
                            <option value="Viernes">Viernes</option>
                        </select>
                    </div>
                @endfor
            </div>
            @for ($i = 1; $i <= 6; $i++)
                <div class="materia-container">
                    <div class="form-group">
                        <label for="materia_id_{{ $i }}">Materia {{ $i }}:</label>
                        <select name="materia_id[]" id="materia_id_{{ $i }}" class="form-control" onchange="updateCursos({{ $i }})">
                            <option value="">Seleccione una materia</option>
                            @foreach($materias as $materia)
                                <option value="{{ $materia->id }}" data-cursos="{{ $materia->cursos->pluck('nombre')->join(', ') }}">{{ $materia->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="cursos{{ $i }}" class="cursos-list"></div>
                </div>
            @endfor

            <button type="submit" class="btn-submit">Guardar Cambios</button>
            <a href="{{ route('docentes.index') }}" class="btn-back">Cancelar</a>
        </form>
    </div>
    <script>
        function updateCursos(index) {
            const selectElement = document.getElementById(`materia_id_${index}`);
            const cursosDiv = document.getElementById(`cursos${index}`);

            if (selectElement.selectedOptions.length > 0) {
                const cursosMateria = selectElement.selectedOptions[0].getAttribute('data-cursos');
                cursosDiv.textContent = cursosMateria ? `Curso: ${cursosMateria}` : 'No hay cursos disponibles';
            } else {
                cursosDiv.textContent = '';
            }
        }
    </script>
</body>
</html>
