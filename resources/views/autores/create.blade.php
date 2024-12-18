@extends('layouts.app')

@section('content')
    <h1>Adicionar Novo Autor(a)</h1>

    <div class="mt-3">
        <a href="{{ route('autores.index') }}" class="btn btn-secondary">Voltar à lista de autores</a>
    </div>

    <form action="{{ route('autores.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="str_nome" class="form-label">Título</label>
            <input type="text" name="str_nome" id="str_nome" class="form-control" value="{{ old('str_nome') }}"
                   required>
            @error('str_nome')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success mt-3">Salvar</button>
    </form>
@endsection
