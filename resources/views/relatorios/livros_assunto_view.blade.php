<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Livros por Assunto</title>
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
        .assunto {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
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
<h1>Relatório de Livros por Assunto</h1>

@foreach ($livros as $livro)
    <div class="assunto">Assunto: {{ $livro->assunto_nome }}</div>
    <table>
        <thead>
        <tr>
            <th>Título</th>
            <th>Editora</th>
            <th>Ano</th>
            <th>Valor</th>
            <th>Autores</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $livro->str_titulo }}</td>
            <td>{{ $livro->str_editora }}</td>
            <td>{{ $livro->num_ano_publicacao }}</td>
            <td>R$ {{ number_format($livro->num_valor, 2, ',', '.') }}</td>
            <td>{{ $livro->autores }}</td> <!-- Exibindo os autores -->
        </tr>
        </tbody>
    </table>
@endforeach

</body>
</html>
