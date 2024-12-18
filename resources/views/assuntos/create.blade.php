@extends('layouts.app')

@section('content')
    <h1>Adicionar Novo Assunto</h1>

    <div class="mt-4">
        <a href="{{ route('assuntos.index') }}" class="btn btn-secondary">Voltar à lista de assuntos</a>
    </div>

    <form action="{{ route('assuntos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="str_descricao" class="form-label">Título</label>
            <input type="text" name="str_descricao" id="str_descricao" class="form-control" value="{{ old('str_descricao') }}"
                   required>
            @error('str_descricao')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="{{ route('assuntos.index') }}" class="btn btn-secondary">Voltar</a>
    </form>
@endsection
