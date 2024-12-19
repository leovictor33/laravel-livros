@extends('layouts.app')

@section('title', 'Erro ao Gerar Relatório')

@section('content')
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
