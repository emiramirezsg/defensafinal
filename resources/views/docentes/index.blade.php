<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Docentes</title>
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

        /* Estilos para las tarjetas de docentes */
        .docentes {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .docente-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.3s ease;
            position: relative;
            width: calc(33.333% - 20px); /* Ajustar el ancho y espacio entre tarjetas */
            box-sizing: border-box;
        }

        .docente-card:hover {
            transform: translateY(-5px);
        }

        .docente-info h3 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 1.2em;
            color: #333;
        }

        .docente-info p {
            margin: 0;
            font-size: 1em;
            color: #666;
        }

        .cursos-list {
            margin-top: 10px;
            font-size: 0.9em;
            color: #555;
        }

        .botones {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s ease;
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

        .btn-agregar-docente {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-agregar-docente:hover {
            background-color: #0056b3;
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

        .btn-regresar:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <a href="{{ route('home') }}" class="btn btn-regresar">Inicio</a>

    <div class="container">
        <h2>Lista de Docentes</h2>
        <div class="docentes">
            @foreach($docentes as $docente)
            <div class="docente-card">
                <div class="docente-info">
                    <h3>{{ $docente->nombre }} {{ $docente->apellido }}</h3>
                    <p><strong>Email:</strong> {{ $docente->email }}</p>
                    <p><strong>Categoría:</strong> {{ $docente->categoria ? $docente->categoria->nombre : 'Categoría no asignada' }}</p>

                    <div class="materia-info">
                        <p><strong>Materia Asignada:</strong></p>
                        @if($docente->materia)
                                <p>{{ $docente->materia->nombre }}</p>
                        @else
                            <p>No hay materias asignadas</p>
                        @endif
                    </div>
                </div>

                <div class="botones">
                    <a href="{{ route('docentes.edit', $docente->id) }}" class="btn btn-editar">Editar</a>
                    <form action="{{ route('docentes.destroy', $docente->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este docente?');">Eliminar</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        <a href="{{ route('docentes.create') }}" class="btn btn-agregar-docente">Agregar Docente</a>
    </div>
</body>
</html>
