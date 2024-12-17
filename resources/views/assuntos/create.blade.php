@extends('layouts.app')

@section('content')
    <h1>Adicionar Novo Assunto</h1>

    <div class="mt-4">
        <a href="{{ route('assuntos.index') }}" class="btn btn-secondary">Voltar à lista de assuntos</a>
    </div>

    <form action="{{ route('assuntos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="str_descricao" class="form-label">Descrição</label>
            <input type="text" class="form-control" id="str_descricao" name="str_descricao" required>
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="{{ route('assuntos.index') }}" class="btn btn-secondary">Voltar</a>
    </form>
@endsection
