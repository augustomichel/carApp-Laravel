@extends('front.layout.main')

@section('content')

<div class="col-md-6">
    <div class="card card-success">
      <div class="card-header">
        <div class="col-md-6">
          <h3 class="card-title">Check-In</h3>
        </div>
        <div class="col-md-6" style="float:right;">
          <a class="btn btn-info" href="{{ action('Front\CheckinController@index') }}" role="button" style="float:right;">Relação</a>
        </div>
      </div>

      <form role="form" action="{{ action('Front\CheckinController@update', $usuarioservico->id) }}" method="post">
        {!! csrf_field() !!}
        {{ method_field('PUT') }}

        @include('front.layout.validacao-error')
        @include('front.layout.success')

        <div class="card-body">
          <div class="form-group">
              <label for="exampleInputNome">Placa</label>
              <input readonly = "true" type="text" class="form-control" name="usv_placa" placeholder="Placa do Veículo" value="{{ $usuarioservico->usv_placa }}">
              <input type="hidden" class="form-control" name="usv_placa_old" placeholder="Placa do Veículo" value="{{ $usuarioservico->usv_placa }}">
          </div>

          <div class="form-group">
              <label for="exampleInputNome">Nome</label>
              <input readonly = "true" type="text" class="form-control" name="ser_descricao" placeholder="Descrição Serviço" value="{{ $usuarioservico->ser_descricao }}">
              <input type="hidden" class="form-control" name="ser_descricao_old" placeholder="Descrição Serviço" value="{{ $usuarioservico->ser_descricao }}">
          </div>

          <div class="form-group">
              <label for="exampleInputNome">Tempo Estimado (minutos)</label>
              <input readonly = "true" type="number" class="form-control" name="ser_time_execucao"
              placeholder="Tempo Execução" value="{{ $usuarioservico->ser_time_execucao }}" min="1">
          </div>

          <div class="form-group">
              <label for="exampleInputMsg">Descrição</label>
              <input type="text" class="form-control" name="usi_descricao"
              placeholder="Descrição" value="{{ $usuarioservico->usi_descricao }}" >
          </div>

          <div class="form-group">
            <label>Status Atual</label><br>
            @if($usuarioservico->uss_status == 1)
              <span class="badge badge-success">Agendado</span>
            @endif
              
            @if($usuarioservico->uss_status == 2)
              <span class="badge badge-danger">Oficina</span>
            @endif

            @if($usuarioservico->uss_status == 3)
              <span class="badge badge-danger">Execução</span>
            @endif

            @if($usuarioservico->uss_status == 4)
              <span class="badge badge-danger">Pós-Execução</span>
            @endif

            @if($usuarioservico->uss_status == 5)
              <span class="badge badge-danger">Lavação</span>
            @endif
            
            @if($usuarioservico->uss_status == 6)
              <span class="badge badge-danger">Pré-Entrega</span>
            @endif

            @if($usuarioservico->uss_status == 7)
              <span class="badge badge-danger">Concluído</span>
            @endif
          </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-info">Check-In</button>
        </div>
      </form>
    </div>
    <!-- /.card -->

  </div>

  @endsection