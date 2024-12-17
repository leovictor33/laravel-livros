@extends('layouts.app')

@section('content')
    <h1>Lista de Livros</h1>

    <!-- Exibir mensagem de sucesso se houver -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div style="display: inline;">
        <a href="{{ route('livros.create') }}" class="btn btn-success btn-sm mb-3">Adicionar Novo Livro</a>
        <a href="{{ route('relatorios.livros') }}" class="btn btn-warning btn-sm mb-3">Gerar Relatório</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Título</th>
                <th>Autores</th>
                <th>Editora</th>
                <th>Edição</th>
                <th>Ano</th>
                <th>Valor</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($livros as $livro)
                {{--                @if($livro->codigo == 19)--}}
                {{--                    @dd($livro->num_valor, number_format($livro->num_valor, 2, ',', '.'))--}}
                {{--                @endif--}}
                <tr>
                    <td>{{ $livro->str_titulo }}</td>
                    <td>{{ $livro->autores->implode('str_nome', ', ') }}</td>
                    <td>{{ $livro->str_editora }}</td>
                    <td>{{ $livro->num_edicao }}</td>
                    <td>{{ $livro->num_ano_publicacao }}</td>
                    <td id="num_valor">{{ number_format($livro->num_valor, 2, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('livros.show', $livro->codigo) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('livros.edit', $livro->codigo) }}" class="btn btn-primary btn-sm">Editar</a>

                        <form action="{{ route('livros.destroy', $livro->codigo) }}" method="POST"
                              style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Tem certeza que deseja excluir este livro?')">
                                Excluir
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
