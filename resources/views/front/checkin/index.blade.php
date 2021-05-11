@extends('front.layout.main')

@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>




<?php $page = !isset($_GET['page']) ? 1 : $_GET['page']; ?>
<?php $dataFiltro = !isset($_GET['f']) ? "" : $_GET['f']; ?>
<?php $statusFiltro = !isset($_GET['s']) ? "" : $_GET['s']; ?>

<div class="container">

    <div class="card">
        <div class="card-header border-0">
        
        <h3 class="card-title">Relação de Serviços</h3>
        <h3> {{ $data }} </h3>
        <div class="card-tools">
            <label>
                <input class="date form-control" type="text" id="date" value= {{$dataFiltro}}>
            </label>    
            <label>            
                <select name="status" id="status" class="form-control form-control-sm filtro">
                    <option value=""></option>
                    <option value=1 @if($statusFiltro == 1) selected @endif>AGENDADO</option>
                    <option value=2 @if($statusFiltro == 2) selected @endif>OFICINA</option>
                    <option value=3 @if($statusFiltro == 3) selected @endif>EXECUÇÃO</option>
                    <option value=1 @if($statusFiltro == 4) selected @endif>PÓS-EXECUÇÃO</option>
                    <option value=2 @if($statusFiltro == 5) selected @endif>LAVAÇÃO</option>
                    <option value=3 @if($statusFiltro == 6) selected @endif>PRÉ-ENTREGA</option>
                    <option value=3 @if($statusFiltro == 7) selected @endif>FINALIZADO</option>
                </select> 
            </label>
            <!--<a class="btn btn-info" href="{{ action('Admin\ServicoController@create') }}" role="button">Novo Serviço</a>-->
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
                        <a class="order" href="?c=usv_placa&o=asc"><i class="fas fa-arrow-circle-up"></i></a>
                        <a class="order" href="?c=usv_placa&o=desc"><i class="fas fa-arrow-circle-down"></i></a>
                    </th>
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
                        Tempo Previsto
                        <a class="order" href="?c=ser_time_execucao&o=asc"><i class="fas fa-arrow-circle-up"></i></a>
                        <a class="order" href="?c=ser_time_execucao&o=desc"><i class="fas fa-arrow-circle-down"></i></a>
                    </th>
                    <th class="center">
                        Observação
                    </th>
                    <th>
                        Status
                        <a class="order" href="?c=ser_status&o=asc"><i class="fas fa-arrow-circle-up"></i></a>
                        <a class="order" href="?c=ser_status&o=desc"><i class="fas fa-arrow-circle-down"></i></a>
                    </th>
                    <th></th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($usuarioservicos as $servico)    
                    <tr>
                        <td>                            
                            {{ $servico->usv_placa }}                       
                        </td>
                        <td>                            
                            {{ $servico->ser_descricao }}                       
                        </td>
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

                        <td class="center">
                            {{ $servico->ser_time_execucao }}   
                        </td> 
                        <td class="center">
                            {{ $servico->uss_observacao }}   
                        </td> 
                        <td>
                            @if($servico->uss_status == 1)
                                <span class="badge badge-success">AGENDADO</span>
                            @endif
                                
                            @if($servico->uss_status == 2)
                                <span class="badge badge-danger">OFICINA</span>
                            @endif

                            @if($servico->uss_status == 3)
                                <span class="badge badge-danger">EXECUÇÃO</span>
                            @endif

                            @if($servico->uss_status == 4)
                                <span class="badge badge-danger">PÓS-EXECUÇÃO</span>
                            @endif
                            
                            @if($servico->uss_status == 5)
                                <span class="badge badge-danger">LAVAÇÃO</span>
                            @endif
                            
                            @if($servico->uss_status == 6)
                                <span class="badge badge-danger">PRÉ-ENTREGA</span>
                            @endif

                            @if($servico->uss_status == 7)
                                <span class="badge badge-danger">CONCLUÍDO</span>
                            @endif
                        </td>
                        <td>
                        </td>
                        <td>
                            @if($servico->uss_status <> 7)
                            <a href="{{ route('checkin.edit', $servico->id) }}" class="text-muted"><i class="fas fa-door-open" title="CheckIn"></i></a>
                            @endif                            
                        </td> 
                    </tr>
                @endforeach
                <tr class="links">
                    <td colspan="8">
                        @include('front.layout.total-registros')
                        @include('front.layout.pagination')
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>

<script>
    $("#status").change(function(){
        window.location.href = '?f=' + $("#date").val() + '&s=' + $("#status").val();
    });

</script>    
<script type="text/javascript">
    $('.date').datepicker({  
       format: 'dd-mm-yyyy',
       locate: 'pt-br'    
     });  
    
     $("#date").change(function(){
        window.location.href =  '?f=' + $("#date").val() + '&s=' + $("#status").val();;
    });
</script>
@endsection