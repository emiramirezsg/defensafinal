<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: url('https://img.freepik.com/fotos-premium/escena-estilo-anime-patio-escuela-escaleras-arboles-generativo-ai_1034036-8145.jpg') no-repeat center center fixed;
            background-size: cover; /* Asegura que la imagen cubra todo el fondo */
            margin: 0;
            padding: 0;
            height: 100vh; /* Ocupa toda la altura de la ventana */
        }

        .user-bar {
            background-color: #3258ab;
            padding: 20px;
            color: #fff;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-info h2 {
            margin: 0;
            font-size: 1.8em;
            color: #fff;
            cursor: pointer;
            text-decoration: none; /* Elimina el subrayado */
            transition: transform 0.3s ease; /* Transición suave para el efecto de zoom */
        }

        .user-info h2:hover {
            transform: scale(1.1); /* Hace que el texto sea un 10% más grande al pasar el mouse */
        }

        .center-image {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .center-image img {
            max-height: 100px; /* Ajusta el tamaño según sea necesario */
            max-width: 100%;
            object-fit: contain;
        }

        .logout-btn {
            background-color: #dc3545; /* Color de fondo del botón */
            border: none;
            border-radius: 50%; /* Hace el botón circular */
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: absolute;
            right: 20px;
            top: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .logout-btn img {
            width: 30px;
            height: 30px;
        }

        .logout-btn:hover {
            background-color: #c82333; /* Color de fondo en hover */
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            position: relative;
            flex: 1 1 calc(33.333% - 40px);
            box-sizing: border-box;
            max-width: calc(33.333% - 40px);
            margin: 10px;
            overflow: hidden; /* Esconde el contenido que se sale del contenedor */
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .card img {
            width: 100%;
            height: 200px; /* Ajusta el tamaño según sea necesario */
            object-fit: cover;
            border-bottom: 2px solid #ddd; /* Agrega una línea debajo de la imagen */
        }

        .card-content {
            padding: 15px;
            position: relative;
            top: -20px; /* Ajusta el espacio según sea necesario */
            background: #fff;
            width: 100%;
            box-sizing: border-box;
        }

        .card h2 {
            margin: 15px 0;
            color: #333;
        }

        .card .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 10px 5px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            color: #fff;
            transition: background-color 0.3s ease;
        }

        .btn-view {
            background-color: #007bff;
        }

        .btn-view:hover {
            background-color: #0056b3;
        }

        .btn-manage {
            background-color: #28a745;
        }

        .btn-manage:hover {
            background-color: #218838;
        }

        .btn-edit {
            background-color: #ffc107;
        }

        .btn-edit:hover {
            background-color: #e0a800;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="user-bar">
        <div class="user-info">
            <h2 onclick="location.href='{{ route('user.profile') }}'">{{ Auth::user()->name }}</h2>
        </div>
        <div class="center-image">
            <img src="https://prendimientocordoba.com/wp-content/uploads/2020/08/CabeceradDonBosco.jpg" alt="Central Image">
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <button class="logout-btn" onclick="confirmLogout()">
            <img src="https://icons.veryicon.com/png/o/internet--web/website-icons/logout-8.png" alt="Cerrar sesión">
        </button>
    </div>

    <div class="container">
        <!-- Tarjeta de Materias -->
        <div class="card">
            <img src="https://img.freepik.com/vector-gratis/asignaturas-colegio_23-2147511892.jpg" alt="Materias">
            <div class="card-content">
                <h2>Materias</h2>
                <div class="card-actions">
                    <a href="{{ route('materias.index') }}" class="btn btn-view">Ver Todas</a>
                    <a href="{{ route('materias.create') }}" class="btn btn-manage">Agregar</a>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Cursos -->
        <div class="card">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSprcEU7okCTLN3-O_tUcakSyOYVb_ro4KCWw&s" alt="Cursos">
            <div class="card-content">
                <h2>Cursos</h2>
                <div class="card-actions">
                    <a href="{{ route('cursos.index') }}" class="btn btn-view">Ver Todos</a>
                    <a href="{{ route('cursos.create') }}" class="btn btn-manage">Agregar</a>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Docentes -->
        <div class="card">
            <img src="https://i.pinimg.com/originals/ca/60/f9/ca60f95392f03dced81fc7326fc8f5bb.jpg" alt="Docentes">
            <div class="card-content">
                <h2>Docentes</h2>
                <div class="card-actions">
                    <a href="{{ route('docentes.index') }}" class="btn btn-view">Ver Todos</a>
                    <a href="{{ route('docentes.create') }}" class="btn btn-manage">Agregar</a>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Aulas -->
        <div class="card">
            <img src="https://www.compartirpalabramaestra.org/sites/default/files/styles/articulos/public/field/image/el-aula-vacia.jpg?itok=BoQ5B1_c" alt="Aulas">
            <div class="card-content">
                <h2>Aulas</h2>
                <div class="card-actions">
                    <a href="{{ route('aulas.index') }}" class="btn btn-view">Ver Todas</a>
                    <a href="{{ route('aulas.create') }}" class="btn btn-manage">Agregar</a>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Horarios -->
        <div class="card">
            <img src="https://www.bizneo.com/blog/wp-content/uploads/2022/03/programa-de-control-horario.jpg" alt="Horarios">
            <div class="card-content">
                <h2>Horarios</h2>
                <div class="card-actions">
                    <a href="{{ route('horarios.index') }}" class="btn btn-view">Ver</a>
                    <a href="{{ route('horarios.generar') }}" class="btn btn-manage">Generar horario</a>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Categorías -->
        <div class="card">
            <img src="https://slideplayer.es/slide/4676983/14/images/4/ASCENSO+DOCENTE+A+B+C+D+E+F+G+H+I+J+Ascenso+Ordinario%3A.jpg" alt="Categorías">
            <div class="card-content">
                <h2>Categorías</h2>
                <div class="card-actions">
                    <a href="{{ route('categorias.index') }}" class="btn btn-view">Ver Todas</a>
                    <a href="{{ route('categorias.create') }}" class="btn btn-manage">Agregar</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmLogout() {
            if (confirm('¿Estás seguro de que quieres cerrar sesión?')) {
                document.getElementById('logout-form').submit();
            }
        }
    </script>
</body>
</html>
