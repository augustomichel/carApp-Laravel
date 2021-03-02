@extends('admin.layout.main')

@section('content')

<div class="col-md-6">
    <div class="card card-success">
      <div class="card-header">
        <div class="col-md-6">
          <h3 class="card-title">Edição de Usuário</h3>
        </div>
        <div class="col-md-6" style="float:right;">
          <a class="btn btn-info" href="{{ action('Admin\ServicoController@index') }}" role="button" style="float:right;">Relação</a>
        </div>
      </div>

      <form role="form" action="{{ action('Admin\ServicoController@update', $servico->ser_codigo) }}" method="post">
        {!! csrf_field() !!}
        {{ method_field('PUT') }}

        @include('admin.layout.validacao-error')
        @include('admin.layout.success')

        <div class="card-body">
          <div class="form-group">
              <label for="exampleInputNome">Nome</label>
              <input type="text" class="form-control" name="ser_descricao" placeholder="Descrição Serviço" value="{{ $servico->ser_descricao }}">
              <input type="hidden" class="form-control" name="ser_descricao_old" placeholder="Descrição Serviço" value="{{ $servico->ser_descricao }}">
          </div>

          <div class="form-group">
            <label for="exampleInputNome">Tipo de Serviço</label>
            <select name="ser_tipo_servico" class="form-control">
              <option value=""></option>
              <option value="1" @if($servico->ser_tipo_servico == '1') selected @endif>Revisão</option>
              <option value="2" @if($servico->ser_tipo_servico == '2') selected @endif>Mecânica</option>
              <option value="3" @if($servico->ser_tipo_servico == '3') selected @endif>Funilária</option>
              <option value="4" @if($servico->ser_tipo_servico == '4') selected @endif>Borracharia</option>
            </select> 
          </div>
          <div class="form-group">
              <label for="exampleInputNome">Tempo Execução (minutos)</label>
              <input type="number" class="form-control" name="ser_time_execucao"
              placeholder="Tempo Execução" value="{{ $servico->ser_time_execucao }}" min="1">
          </div>

          <div class="form-group">
            <label>Status</label><br>
            <select name="ser_status" class="form-control">
                <option value="S" @if($servico->ser_status == 'S') selected @endif>ATIVO</option>
                <option value="N" @if($servico->ser_status == 'N') selected @endif>INATIVO</option>
            </select> 
          </div>
          <div class="form-group">
            <label>Status Atual</label><br>
            @if($servico->ser_status == 'S')
              <span class="badge badge-success">ATIVO</span>
            @endif
              
            @if($servico->ser_status == 'N')
              <span class="badge badge-danger">INATIVO</span>
            @endif
          </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-info">Alterar</button>
        </div>
      </form>
    </div>
    <!-- /.card -->

  </div>

  @endsection