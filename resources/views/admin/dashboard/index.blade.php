@extends('admin.layout.main')

@section('content')

<div class="container-fluid">
    <div class="row">

        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        Usuários Cadastrados
                    </h2>
                </div>
                <div class="card-body">
                    <span>{{ $usuariosCadastrados }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        Concessionárias Cadastradas
                    </h2>
                </div>
                <div class="card-body">
                    <span>{{ $concessionariasCadastradas }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        Serviços Cadastrados
                    </h2>
                </div>
                <div class="card-body">
                    <span>{{ $servicosCadastrados }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        Produtos Cadastrados
                    </h2>
                </div>
                <div class="card-body">
                    <span>{{ $produtosCadastrados }}</span>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

