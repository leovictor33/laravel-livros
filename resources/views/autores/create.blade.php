@extends('layouts.app')

@section('content')
    <h1>Adicionar Novo Autor(a)</h1>

    <div class="mt-3">
        <a href="{{ route('autores.index') }}" class="btn btn-secondary">Voltar à lista de autores</a>
    </div>

    <form action="{{ route('autores.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="str_nome">Nome do Autor(a)</label>
            <input type="text" id="str_nome" name="str_nome" class="form-control" value="{{ old('str_nome') }}" required>
            @error('str_nome')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success mt-3">Salvar</button>
    </form>
@endsection
