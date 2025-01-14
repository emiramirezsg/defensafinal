<h1>Detalles del Docente</h1>
<p>Docente: {{ $docente->name }}</p>

<h2>Materias Asociadas</h2>
<ul>
    @foreach($materias as $materia)
        <li>{{ $materia->name }}</li>
    @endforeach
</ul>
