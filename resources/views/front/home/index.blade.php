@extends('front.layout.main')

@section('content')

<div class="container-fluid">
    <div class="row">

        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        Meus Veículos
                    </h2>
                </div>
                <div class="card-body">
                    <span>{{ $veiculoscadastrados }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        Serviços
                    </h2>
                </div>
                <div class="card-body">
                    <span>{{ $servicos }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        Mensagens
                    </h2>
                </div>
                <div class="card-body">
                    <span></span>
                </div>
            </div>
        </div>


    </div>
</div>

@endsection

