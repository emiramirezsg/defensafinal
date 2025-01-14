<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Horarios</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #e0f7fa;
            margin: 0;
            padding: 0;
        }

        .user-bar {
            background-color: #00796b;
            padding: 20px;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .user-info h2 {
            margin: 0;
            font-size: 1.8em;
            color: #fff;
        }

        .btn-logout {
            background-color: #d32f2f;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-logout:hover {
            background-color: #c62828;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #00796b;
            margin-bottom: 20px;
            font-size: 2em;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th {
            background-color: #00796b;
            color: #fff;
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
            background-color: #e0f2f1;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #b2dfdb;
        }

        .table tbody tr:hover {
            background-color: #80cbc4;
        }
    </style>
</head>
<body>
    <div class="user-bar">
        <div class="user-info">
            <h2>{{ Auth::user()->gmail }}</h2>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">Cerrar Sesión</button>
        </form>
    </div>

    <div class="container">
        <h1>Mis Horarios</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Hora</th>
                    <th>Materia</th>
                    <th>Aula</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach 
                    <tr>
                        <td>{{ $horario->hora }}</td>
                        <td>{{ $horario->materia->nombre }}</td>
                        <td>{{ $horario->aula->nombre }}</td>
                        <td>{{ $horario->fecha }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
