<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        .titulo{
            border: 1px;
            background-color: #c2c2c2;
            text-align: center;
            width: 100%;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 25px;
        }
        .tabela{
            width: 100%;
        }
        .quebra-pagina{
            page-break-after: always;
        }
        table th{
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="titulo">Lista de Tarefas</div>
    
    <table class="tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tarefa</th>
                <th>Data Limite da Conclusão</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tarefas as $key => $tarefa)
                <tr>
                    <th>{{$tarefa->id}}</th>
                    <th>{{$tarefa->tarefa}}</th>
                    <th>{{date('d/m/Y', strtotime($tarefa->data_limite_conclusao))}}</th>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="quebra-pagina"></div>
    <h2>Página 2</h2>
</body>
</html>
