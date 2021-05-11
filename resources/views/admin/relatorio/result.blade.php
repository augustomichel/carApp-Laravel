@extends('admin.layout.main')

@section('content')

<div class="container">

    <div class="card">
        <div class="card-header border-0">
        
           <h3 class="card-title">Relação de Serviços</h3>
           <h3> {{ $datede }} até {{ $dateate }} </h3>
     
        </div>
        <div class="card-body table-responsive p-0">

            <table class="table table-striped table-valign-middle">
                <thead>
                <tr>
                    <th>
                        Placa
                        <!--<a class="order" href="?c=usv_placa&o=asc"><i class="fas fa-arrow-circle-up"></i></a>
                        <a class="order" href="?c=usv_placa&o=desc"><i class="fas fa-arrow-circle-down"></i></a>
                        -->
                    </th>
                    <th>
                        Descrição
                        <!--<a class="order" href="?c=ser_descricao&o=asc"><i class="fas fa-arrow-circle-up"></i></a>
                        <a class="order" href="?c=ser_descricao&o=desc"><i class="fas fa-arrow-circle-down"></i></a>
                        -->
                    </th>
                    <th class="center">
                        Tipo de Serviço
                        <!--<a class="order" href="?c=ser_tipo_servico&o=asc"><i class="fas fa-arrow-circle-up"></i></a>
                        <a class="order" href="?c=ser_tipo_servico&o=desc"><i class="fas fa-arrow-circle-down"></i></a>
                        -->
                    </th>
                    <th class="center">
                        Tempo Previsto
                        <!--<a class="order" href="?c=ser_time_execucao&o=asc"><i class="fas fa-arrow-circle-up"></i></a>
                        <a class="order" href="?c=ser_time_execucao&o=desc"><i class="fas fa-arrow-circle-down"></i></a>
                        -->
                    </th>
                    <th class="center">
                        Observação
                    </th>
                    <th class="center">
                        Inicio
                    </th>
                    <th class="center">
                        Fim
                    </th>
                    <th class="center">
                        Responsável
                    </th>
                    <th>
                        Status
                        <!--<a class="order" href="?c=ser_status&o=asc"><i class="fas fa-arrow-circle-up"></i></a>
                        <a class="order" href="?c=ser_status&o=desc"><i class="fas fa-arrow-circle-down"></i></a>
                        -->
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
                        <td class="center">
                            {{ $servico->usi_datetime }}   
                        </td>   
                        <td class="center">
                            {{ $servico->usi_datetime_fim }}   
                        </td>   
                        <td class="center">
                            {{ $servico->usu_nome }}   
                        </td>                       
                        <td>
                            @if($servico->usi_status_checkin == 1)
                                <span class="badge badge-success">AGENDADO</span>
                            @endif
                                
                            @if($servico->usi_status_checkin == 2)
                                <span class="badge badge-danger">OFICINA</span>
                            @endif

                            @if($servico->usi_status_checkin == 3)
                                <span class="badge badge-danger">EXECUÇÃO</span>
                            @endif

                            @if($servico->usi_status_checkin == 4)
                                <span class="badge badge-danger">PÓS-EXECUÇÃO</span>
                            @endif
                            
                            @if($servico->usi_status_checkin == 5)
                                <span class="badge badge-danger">LAVAÇÃO</span>
                            @endif
                            
                            @if($servico->usi_status_checkin == 6)
                                <span class="badge badge-danger">PRÉ-ENTREGA</span>
                            @endif

                            @if($servico->usi_status_checkin == 7)
                                <span class="badge badge-danger">CONCLUÍDO</span>
                            @endif
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        
                    </tr>
                @endforeach
                <tr class="links">
                    <td colspan="8">
                        @include('admin.layout.total-registros')
                        @include('admin.layout.pagination')
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>

 
@endsection