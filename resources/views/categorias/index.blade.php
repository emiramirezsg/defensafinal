<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Categorías</title>
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

        /* Estilos para las tarjetas de categorías */
        .categorias {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .categoria-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.3s ease;
            position: relative;
            width: calc(33.333% - 20px); /* Ajustar el ancho y espacio entre tarjetas */
            box-sizing: border-box; /* Asegura que el padding no afecte al ancho total */
        }

        .categoria-card:hover {
            transform: translateY(-5px);
        }

        .categoria-info h3 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 1.2em;
            color: #333;
        }

        .categoria-info p {
            margin: 0;
            font-size: 1em;
            color: #666;
        }

        .botones {
            display: flex; /* Para alinear los botones en una fila */
            gap: 10px; /* Espacio entre los botones */
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

        .btn-agregar-categoria {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-agregar-categoria:hover {
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
        <h2>Lista de Categorías</h2>
        <div class="categorias">
            @foreach($categorias as $categoria)
            <div class="categoria-card">
                <div class="categoria-info">
                    <h3>{{ $categoria->nombre }}</h3>
                    <p><strong>Horas de Trabajo:</strong> {{ $categoria->hrs_trabajo }} horas</p>
                </div>
                <div class="botones">
                    <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-editar">Editar</a>
                    <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-eliminar" onclick="return confirm('¿Estás seguro de querer eliminar esta categoría?')">Eliminar</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        <a href="{{ route('categorias.create') }}" class="btn btn-agregar-categoria">Agregar Categoría</a>
    </div>
</body>
</html>
