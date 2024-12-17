@extends('layouts.app')

@section('content')
    <h1>Detalhes do Assunto: {{ $assunto->str_descricao }}</h1>

    <div class="mt-4">
        <a href="{{ route('assuntos.index') }}" class="btn btn-secondary">Voltar à lista de assuntos</a>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            Informações do Assunto
        </div>
        <div class="card-body">
            <h5 class="card-title">Nome: {{ $assunto->str_descricao }}</h5>
            <p><strong>Criado em:</strong> {{ $assunto->created_at->format('d/m/Y') }}</p>
            <p><strong>Atualizado em:</strong> {{ $assunto->updated_at->format('d/m/Y') }}</p>
        </div>
    </div>

    <h3 class="mt-4">Livros relacionados</h3>
    @if ($livros->isEmpty())
        <p>Este assunto não está relacionado a nenhum livro.</p>
    @else
        <table class="table table-striped mt-3">
            <thead>
            <tr>
                <th>Título</th>
                <th>Editora</th>
                <th>Ano de Publicação</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($livros as $livro)
                <tr>
                    <td>{{ $livro->str_titulo }}</td>
                    <td>{{ $livro->str_editora }}</td>
                    <td>{{ $livro->num_ano_publicacao }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
