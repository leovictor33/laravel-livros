<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livros sobre {{ $strAssunto }}</title>
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
<h1>Livros sobre {{ $strAssunto }}</h1>
    <table>
        <thead>
        <tr>
            <th>Título</th>
            <th>Editora</th>
            <th>Ano de Publicação</th>
            <th>Valor</th>
            <th>Autores</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($livros as $livro)
            <tr>
                <td>{{ $livro->str_titulo }}</td>
                <td>{{ $livro->str_editora }}</td>
                <td>{{ $livro->num_ano_publicacao }}</td>
                <td>R$ {{ number_format($livro->num_valor, 2, ',', '.') }}</td>
                <td>{{ $livro->autores }}</td> <!-- Exibindo os autores -->
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
