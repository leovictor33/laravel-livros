@extends('layouts.app')

@section('content')
    <h1>Livros do Autor: {{ $autor->str_nome }}</h1>
    <a href="{{ route('autores.index') }}" class="btn btn-secondary mb-3">Voltar para Autores</a>

    @if ($livros->isEmpty())
        <p>Este autor ainda não possui livros cadastrados.</p>
    @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Título</th>
                <th>Editora</th>
                <th>Ano</th>
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
    @endif
@endsection
