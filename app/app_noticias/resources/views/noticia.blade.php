<table>
    <thead>
        <tr>
            <td>Titulo</td>
            <td>Noticia</td>
        </tr>
    </thead>

    <tbody>
        @foreach($noticias as $noticia)
        <tr>
            <td>{{ $noticia->titulo }}</td>
            <td>{{ $noticia->noticia }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
