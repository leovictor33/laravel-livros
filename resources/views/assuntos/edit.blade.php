@extends('layouts.app')

@section('content')
    <h1>Editar Assunto</h1>

    <div class="mt-4">
        <a href="{{ route('assuntos.index') }}" class="btn btn-secondary">Voltar à lista de assuntos</a>
    </div>

    <form action="{{ route('assuntos.update', $assunto->codigo) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="str_descricao" class="form-label">Descrição</label>
            <input type="text" class="form-control" id="str_descricao" name="str_descricao" value="{{ old('str_descricao', $assunto->str_descricao) }}" required>
            @error('str_descricao')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{ route('assuntos.index') }}" class="btn btn-secondary">Voltar</a>
    </form>
@endsection
