<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Livros</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1, h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .author {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<h1>Relatório de Livros</h1>
@foreach ($autores as $autor)
    <div class="author">Autor: {{ $autor->str_nome }}</div>
    <table>
        <thead>
        <tr>
            <th>Título</th>
            <th>Editora</th>
            <th>Ano</th>
            <th>Valor</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($autor->livros as $livro)
            <tr>
                <td>{{ $livro->str_titulo }}</td>
                <td>{{ $livro->str_editora }}</td>
                <td>{{ $livro->num_ano_publicacao }}</td>
                <td>R$ {{ number_format($livro->num_valor, 2, ',', '.') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endforeach
</body>
</html>
