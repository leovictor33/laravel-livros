<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Livros sobre {{ $assunto->str_descricao }}</title>
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
    </style>
</head>
<body>
<h1>Livros sobre {{ $assunto->str_descricao }}</h1>
<table>
    <thead>
    <tr>
        <th>Título</th>
        <th>Editora</th>
        <th>Ano de Publicação</th>
        <th>Autores</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($livros as $livro)
        <tr>
            <td>{{ $livro->str_titulo }}</td>
            <td>{{ $livro->str_editora }}</td>
            <td>{{ $livro->num_ano_publicacao }}</td>
            <td>{{ $livro->autores->pluck('str_nome')->join(', ') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
