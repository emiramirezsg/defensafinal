
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Periodos</title>
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        /* Estilos para las tarjetas de periodos */
        .periodo-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            transition: transform 0.3s ease;
        }

        .periodo-card:hover {
            transform: translateY(-5px);
        }

        .periodo-info h3 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 1.2em;
            color: #333;
        }

        .periodo-info p {
            margin: 0;
            font-size: 1em;
            color: #666;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            margin-right: 10px;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-editar {
            background-color: #28a745;
            color: #fff;
        }

        .btn-eliminar {
            background-color: #dc3545;
            color: #fff;
        }

        .btn:hover {
            background-color: #6c757d;
        }

        .btn-agregar-periodo {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-agregar-periodo:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Lista de Periodos</h2>
        <div class="periodos">
            @foreach($periodos as $periodo)
            <div class="periodo-card">
                <div class="periodo-info">
                    <h3>Periodo {{ $loop->iteration }}</h3>
                    <p><strong>Hora de Inicio:</strong> {{ $periodo->hora_inicio }}</p>
                    <p><strong>Hora de Fin:</strong> {{ $periodo->hora_fin }}</p>
                    <p><strong>Día:</strong> {{ $periodo->dia }}</p>
                </div>
                <div class="botones">
                    <a href="{{ route('periodos.edit', $periodo->id) }}" class="btn btn-editar">Editar</a>
                    <form action="{{ route('periodos.destroy', $periodo->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-eliminar" onclick="return confirm('¿Estás seguro de querer eliminar este periodo?')">Eliminar</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        <a href="{{ route('periodos.create') }}" class="btn btn-agregar-periodo">Agregar Periodo</a>
    </div>
</body>
</html>
