@extends('layouts.app')

@section('content')
    <h1>Adicionar Novo Livro</h1>

    <a href="{{ route('livros.index') }}" class="btn btn-secondary mb-3">Voltar à lista</a>

    <form action="{{ route('livros.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="str_titulo" class="form-label">Título</label>
            <input type="text" name="str_titulo" id="str_titulo" class="form-control" value="{{ old('str_titulo') }}" required>
        </div>

        <div class="mb-3">
            <label for="str_editora" class="form-label">Editora</label>
            <input type="text" name="str_editora" id="str_editora" class="form-control" value="{{ old('str_editora') }}" required>
        </div>

        <div class="mb-3">
            <label for="num_edicao" class="form-label">Edição</label>
            <input type="number" name="num_edicao" id="num_edicao" class="form-control" value="{{ old('num_edicao') }}" required>
        </div>

        <div class="mb-3">
            <label for="num_ano_publicacao" class="form-label">Ano de Publicação</label>
            <input type="number" name="num_ano_publicacao" id="num_ano_publicacao" class="form-control" value="{{ old('num_ano_publicacao') }}" required>
        </div>

        <div class="mb-3">
            <label for="num_valor" class="form-label">Valor</label>
            <input type="numeric" class="form-control" id="num_valor" name="num_valor" value="{{ old('num_valor') }}" required>
        </div>

        <div class="mb-3">
            <label for="autores" class="form-label">Autores</label>
            <select name="autores[]" id="autores" class="form-select" multiple required>
                @foreach ($autores as $autor)
                    <option value="{{ $autor->codigo }}">{{ $autor->str_nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="assuntos" class="form-label">Assuntos</label>
            <select name="assuntos[]" id="assuntos" class="form-select" multiple required>
                @foreach ($assuntos as $assunto)
                    <option value="{{ $assunto->codigo }}">{{ $assunto->str_descricao }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
@endsection

