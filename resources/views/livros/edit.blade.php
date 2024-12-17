@extends('layouts.app')

@section('content')
    <h1>Editar Livro</h1>

    <!-- Botão Voltar -->
    <a href="{{ route('livros.index') }}" class="btn btn-secondary mb-3">Voltar à lista</a>

    <form action="{{ route('livros.update', $livro->codigo) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="str_titulo" class="form-label">Título</label>
            <input type="text" name="str_titulo" id="str_titulo" class="form-control"
                   value="{{ old('str_titulo', $livro->str_titulo) }}">
        </div>

        <div class="mb-3">
            <label for="str_editora" class="form-label">Editora</label>
            <input type="text" name="str_editora" id="str_editora" class="form-control"
                   value="{{ old('str_editora', $livro->str_editora) }}">
        </div>

        <div class="mb-3">
            <label for="num_edicao" class="form-label">Edição</label>
            <input type="number" name="num_edicao" id="num_edicao" class="form-control"
                   value="{{ old('num_edicao', $livro->num_edicao) }}">
        </div>

        <div class="mb-3">
            <label for="num_ano_publicacao" class="form-label">Ano de Publicação</label>
            <input type="number" name="num_ano_publicacao" id="num_ano_publicacao" class="form-control
           @error('num_ano_publicacao') is-invalid @enderror"
                   value="{{ old('num_ano_publicacao', $livro->num_ano_publicacao ?? '') }}" required>
            @error('num_ano_publicacao')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="num_valor" class="form-label">Valor</label>
            <input type="text" class="form-control" id="num_valor" name="num_valor" value="{{ old('num_valor', $livro->num_valor ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="autores" class="form-label">Autores</label>
            <select name="autores[]" id="autores" class="form-control" multiple>
                @foreach($autores as $autor)
                    <option value="{{ $autor->codigo }}"
                        {{ $livro->autores->contains('codigo', $autor->codigo) ? 'selected' : '' }}>
                        {{ $autor->str_nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="assuntos" class="form-label">Assuntos</label>
            <select name="assuntos[]" id="assuntos" class="form-control" multiple>
                @foreach($assuntos as $assunto)
                    <option value="{{ $assunto->codigo }}"
                        {{ $livro->assuntos->contains('codigo', $assunto->codigo) ? 'selected' : '' }}>
                        {{ $assunto->str_descricao }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
@endsection
