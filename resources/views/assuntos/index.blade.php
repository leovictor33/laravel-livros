@extends('layouts.app')

@section('content')
    <h1>Lista de Assuntos</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('exception'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Detalhes da Exceção:</strong>
            <pre>{{ session('exception.message') }}</pre>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <a href="{{ route('assuntos.create') }}" class="btn btn-success mb-3">Adicionar Novo Assunto</a>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Descrição</th>
                <th class="text-center">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($assuntos as $assunto)
                <tr>
                    <td>{{ $assunto->str_descricao }}</td>
                    <td class="text-center">
                        <a href="{{ route('assuntos.show', $assunto->codigo) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('assuntos.edit', $assunto->codigo) }}" class="btn btn-primary btn-sm">Editar</a>

                        <form action="{{ route('assuntos.destroy', $assunto->codigo) }}" method="POST"
                              style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Tem certeza que deseja excluir este assunto?')">Excluir
                            </button>
                        </form>

                        <a href="{{ route('relatorios.assunto', $assunto->codigo) }}" class="btn btn-warning btn-sm">
                            Gerar Relatório de Livros
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
