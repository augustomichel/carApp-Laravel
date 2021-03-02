@extends('admin.layout.main')

@section('content')

<?php $page = !isset($_GET['page']) ? 1 : $_GET['page']; ?>

<div class="container">

    <div class="card">
        <div class="card-header border-0">
        <h3 class="card-title">Relação de Serviços</h3>
        <div class="card-tools">
            <label>
                <input type="search" class="form-control form-control-sm filtro" id="search"
                 placeholder="Pesquisar Descrição" name="search">
            </label>
            <label>
                <select name="status" id="status" class="form-control form-control-sm filtro">
                    <option value=""></option>
                    <option value="S">ATIVO</option>
                    <option value="N">INATIVO</option>
                </select> 
            </label>
            <a class="btn btn-info" href="{{ action('Admin\ServicoController@create') }}" role="button">Novo Serviço</a>
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
                        Descrição
                        <a class="order" href="?c=ser_descricao&o=asc"><i class="fas fa-arrow-circle-up"></i></a>
                        <a class="order" href="?c=ser_descricao&o=desc"><i class="fas fa-arrow-circle-down"></i></a>
                    </th>
                    <th class="center">
                        Tipo de Serviço
                        <a class="order" href="?c=ser_tipo_servico&o=asc"><i class="fas fa-arrow-circle-up"></i></a>
                        <a class="order" href="?c=ser_tipo_servico&o=desc"><i class="fas fa-arrow-circle-down"></i></a>
                    </th>
                    <th class="center">
                        Tempo Execução
                        <a class="order" href="?c=ser_time_execucao&o=asc"><i class="fas fa-arrow-circle-up"></i></a>
                        <a class="order" href="?c=ser_time_execucao&o=desc"><i class="fas fa-arrow-circle-down"></i></a>
                    </th>
                    <th>
                        Status
                        <a class="order" href="?c=ser_status&o=asc"><i class="fas fa-arrow-circle-up"></i></a>
                        <a class="order" href="?c=ser_status&o=desc"><i class="fas fa-arrow-circle-down"></i></a>
                    </th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($servicos as $servico)    
                    <tr>
                        <td>{{ $servico->ser_descricao }}</td>
                        <td class="center">
                            @if($servico->ser_tipo_servico == '1')
                                Revisão
                            @endif

                            @if($servico->ser_tipo_servico == '2')
                                Mecânica
                            @endif

                            @if($servico->ser_tipo_servico == '3')
                                Funilária
                            @endif

                            @if($servico->ser_tipo_servico == '4')
                                Borracharia
                            @endif
                        </td>
                        <td class="center">{{ $servico->ser_time_execucao }}</td>
                        <td>
                            @if($servico->ser_status == 'S')
                                <span class="badge badge-success">ATIVO</span>
                            @endif
                                
                            @if($servico->ser_status == 'N')
                                <span class="badge badge-danger">INATIVO</span>
                            @endif
                        </td>
                        <td>
                            @if($servico->ser_status == 'N')
                            <a href="servico/status/{{ $servico->id }}&page={{ $page }}" class="text-muted"><i class="fas fa-plus-circle blue" title="Ativar"></i></a>
                            @endif
                            
                            @if($servico->ser_status == 'S')
                                <a href="{{ route('servico.edit', $servico->id) }}" class="text-muted"><i class="fas fa-edit blue" title="Editar"></i></a>
                                <a href="servico/status/{{ $servico->id }}&page={{ $page }}" class="text-muted"><i class="fas fa-times-circle red" title="Inativar"></i></a>
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