<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Document</title>
    <style>
        .page-break {
            page-break-after: always;
        }

        .titulo {
            border: 1px;
            background-color: #c2c2c2;
            text-align: center;
            width: 100%;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .tabela {
            border: 1px;
            width: 100%;
            text-align: center;
        }

        .tabela th {
            border: 1px;
            background-color: #c2c2c2;
            text-align: center;
            width: 100%;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 25px;
        }
    </style>
</head>

<body>
    <h2 class="titulo">Lista de tarefas</h2>
    <table class="tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tarefa</th>
                <th>Data limite conclusão</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tarefas as $key => $tarefa)
                <tr>
                    <td>{{ $tarefa['id'] }}</td>
                    <td>{{ $tarefa['tarefa'] }}</td>
                    <td>{{ date('d/m/Y', strtotime($tarefa['data_limite_conclusao'])) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="page-break"></div>
    <h2>pagina2</h2>

    <div class="page-break"></div>
    <h2>pagina3</h2>


</body>

</html>
