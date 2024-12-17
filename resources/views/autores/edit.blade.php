@extends('layouts.app')

@section('content')
    <h1>Editar Autor(a)</h1>

    <div class="mt-3">
        <a href="{{ route('autores.index') }}" class="btn btn-secondary">Voltar à lista de autores</a>
    </div>

    <form action="{{ route('autores.update', $autor->codigo) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="str_nome">Nome do Autor(a)</label>
            <input type="text" id="str_nome" name="str_nome" class="form-control" value="{{ old('str_nome', $autor->str_nome) }}" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Atualizar</button>
    </form>
@endsection
