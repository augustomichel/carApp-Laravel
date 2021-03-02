@extends('admin.layout.main')

@section('content')

<?php $page = !isset($_GET['page']) ? 1 : $_GET['page']; ?>

<div class="container">

    <div class="card">
        <div class="card-header border-0">
        <h3 class="card-title">Relação de Concessionárias</h3>
        <div class="card-tools">
            <label>
                <input type="search" class="form-control form-control-sm filtro" id="search"
                 placeholder="Pesquisar Nome" name="search">
            </label>
            <label>
                <select name="status" id="status" class="form-control form-control-sm filtro">
                    <option value=""></option>
                    <option value="S">ATIVO</option>
                    <option value="N">INATIVO</option>
                </select> 
            </label>
            <a class="btn btn-info" href="{{ action('Admin\ClienteController@create') }}" role="button">Nova Concessionária</a>
            <a href="#" class="btn btn-tool btn-sm">
            <i class="fas fa-bars"></i>
            </a>
        </div>
        </div>
        <div class="card-body table-responsive p-0">

            <table class="table table-striped table-valign-middle">
                <thead>
                <tr>
                    <th>
                        Nome
                        <a class="order" href="?c=cli_nome&o=asc"><i class="fas fa-arrow-circle-up"></i></a>
                        <a class="order" href="?c=cli_nome&o=desc"><i class="fas fa-arrow-circle-down"></i></a>
                    </th>
                    <th>
                        CNPJ
                        <a class="order" href="?c=cli_cnp&o=asc"><i class="fas fa-arrow-circle-up"></i></a>
                        <a class="order" href="?c=cli_cnp&o=desc"><i class="fas fa-arrow-circle-down"></i></a>
                    </th>
                    <th>
                        Matriz
                        <a class="order" href="?c=cli_matriz&o=asc"><i class="fas fa-arrow-circle-up"></i></a>
                        <a class="order" href="?c=cli_matriz&o=desc"><i class="fas fa-arrow-circle-down"></i></a>
                    </th>
                    <th>
                        Status
                        <a class="order" href="?c=cli_status&o=asc"><i class="fas fa-arrow-circle-up"></i></a>
                        <a class="order" href="?c=cli_status&o=desc"><i class="fas fa-arrow-circle-down"></i></a>
                    </th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($clientes as $cli)    
                    <tr>
                        <td>
                            @if(!empty($cli->cli_matriz))
                                <span class="badge blue" title="Filial">(F)</span>
                                {{ $cli->cli_nome }}
                            @else 
                                <span class="badge green" title="Matriz">(M)</span>
                                {{ $cli->cli_nome }}
                                @endif
                        </td>
                        <td>{{ $cli->cli_cnp }}</td>
                        <td>
                            @if(!empty($cli->cli_matriz))
                                {{ $matrizes[$cli->cli_matriz] }}
                            @else 
                                -
                            @endif
                        </td>
                        <td>
                            @if($cli->cli_status == 'S')
                                <span class="badge badge-success">ATIVO</span>
                            @endif
                                
                            @if($cli->cli_status == 'N')
                                <span class="badge badge-danger">INATIVO</span>
                            @endif
                        </td>
                        <td>
                            
                            @if($cli->cli_status == 'N')
                            <a href="cliente/status/{{ $cli->id }}&page={{ $page }}" class="text-muted"><i class="fas fa-plus-circle blue" title="Ativar"></i></a>
                            @endif
                            
                            @if($cli->cli_status == 'S')
                                <a href="{{ route('cliente.edit', $cli->id) }}" class="text-muted"><i class="fas fa-edit blue" title="Editar"></i></a>
                                <a href="cliente/status/{{ $cli->id }}&page={{ $page }}" class="text-muted"><i class="fas fa-times-circle red" title="Inativar"></i></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr class="links">
                    <td colspan="5">
                        @include('admin.layout.total-registros')
                        @include('admin.layout.pagination')
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>

<script>
    $("#search").change(function(){
        window.location.href = '?s=' + $("#search").val() + '&f=' + $("#status").val();
    });

    $("#status").change(function(){
        window.location.href = '?f=' + $("#status").val() + '&s=' + $("#search").val();;
    });
</script>    

@endsection