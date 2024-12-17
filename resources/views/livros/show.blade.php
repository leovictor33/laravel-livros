@extends('layouts.app')

@section('content')
    <h1>Detalhes do Livro</h1>

    <a href="{{ route('livros.index') }}" class="btn btn-secondary mb-3">Voltar à lista</a>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Título: {{ $livro->str_titulo }}</h5>
            <p class="card-text">Editora: {{ $livro->str_editora }}</p>
            <p class="card-text">Edição: {{ $livro->num_edicao }}</p>
            <p class="card-text">Ano de Publicação: {{ $livro->num_ano_publicacao }}</p>
            <p class="card-text">Valor: R$ {{ number_format($livro->num_valor, 2, ',', '.') }}</p>
            <p class="card-text">
                <strong>Autores:</strong>
                {{ $livro->autores->pluck('str_nome')->join(', ') }}
            </p>
            <p class="card-text">
                <strong>Assuntos:</strong>
                {{ $livro->assuntos->pluck('str_descricao')->join(', ') }}
            </p>
        </div>
    </div>

    <!-- Botão para excluir -->
    <form action="{{ route('livros.destroy', $livro->codigo) }}" method="POST" class="mt-3">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger"
                onclick="return confirm('Tem certeza que deseja excluir este livro?')">
            Excluir Livro
        </button>
    </form>
@endsection
