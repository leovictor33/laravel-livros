@extends('layouts.app')

@section('title', 'Erro ao Gerar Relatório')

@section('content')
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
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-danger text-white">
                        <h4 class="mb-0">Erro ao Gerar Relatório</h4>
                    </div>
                    <div class="card-body text-center">
                        <p class="fs-5">
                            @if(isset($message))
                                {{ $message }}
                            @else
                                Pedimos desculpas, mas ocorreu um erro ao processar a sua solicitação. Por favor, tente
                                novamente mais tarde.
                                Você também pode navegar pelos menus disponíveis acima.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
