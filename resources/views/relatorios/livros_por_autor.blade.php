<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Livros de {{ $autor->str_nome }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        /*Style utilizado para a quebra correta do thead para cada página necessária*/
        thead {
            display: table-header-group;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
<h1>Livros de {{ $autor->str_nome }}</h1>
<table>
    <thead>
    <tr>
        <th>Título</th>
        <th>Editora</th>
        <th>Ano de Publicação</th>
        <th>Assuntos</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($livros as $livro)
        <tr>
            <td>{{ $livro->str_titulo }}</td>
            <td>{{ $livro->str_editora }}</td>
            <td>{{ $livro->num_ano_publicacao }}</td>
            <td>{{ $livro->assuntos->pluck('str_descricao')->join(', ') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
