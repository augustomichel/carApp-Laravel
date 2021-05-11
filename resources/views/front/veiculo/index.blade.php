@extends('front.layout.main')

@section('content')

<?php $page = !isset($_GET['page']) ? 1 : $_GET['page']; ?>

<div class="container">

    <div class="card">
        <div class="card-header border-0">
        <h3 class="card-title">Meus Veículos </h3>
        <div class="card-tools">
            <label>
                <input type="search" class="form-control form-control-sm filtro" id="search"
                 placeholder="Pesquisar Placa" name="search">
            </label>
            <a class="btn btn-info" href="{{ action('Front\VeiculoController@create') }}" role="button">Novo Veículo</a>
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
                        Placa
                        <a class="order" href="?v=usv_placa&o=asc"><i class="fas fa-arrow-circle-up"></i></a>
                        <a class="order" href="?v=usv_placa&o=desc"><i class="fas fa-arrow-circle-down"></i></a>
                    </th>
                    <th>
                        MARCA
                        <a class="order" href="?v=usv_marca&o=asc"><i class="fas fa-arrow-circle-up"></i></a>
                        <a class="order" href="?v=usv_marca&o=desc"><i class="fas fa-arrow-circle-down"></i></a>
                    </th>
                    <th>
                        MODELO
                        <a class="order" href="?v=usv_modelo&o=asc"><i class="fas fa-arrow-circle-up"></i></a>
                        <a class="order" href="?v=usv_modelo&o=desc"><i class="fas fa-arrow-circle-down"></i></a>
                    </th>
                    <th>
                        KM 
                        <a class="order" href="?v=km_atual&o=asc"><i class="fas fa-arrow-circle-up"></i></a>
                        <a class="order" href="?v=km_atual&o=desc"><i class="fas fa-arrow-circle-down"></i></a>
                    </th>
                    
                    </tr>
                </thead>
                <tbody>
                @foreach ($veiculos as $usv)    
                    <tr>
                        <td>{{ $usv->usv_placa }}</td>
                        <td>
                            @if(!empty($usv->usv_marca))
                                @foreach ($usv->usv_marca as $mac)   
                                    {{ $mac['mac_nome'] }}
                                @endforeach                                
                            @else 
                                -
                            @endif
                        </td>
                        <td>
                            @if(!empty($usv->usv_modelo))
                                @foreach ($usv->usv_modelo as $mod)   
                                    {{ $mod['mod_nome'] }}
                                @endforeach
                            @else 
                                -
                            @endif    
                        </td>
                        <td>
                            @if(!empty($usv->km_atual))
                                {{ $usv->km_atual }}
                            @else 
                                -
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
        window.location.href = '?s=' + $("#search").val();
    });

</script>    

@endsection
