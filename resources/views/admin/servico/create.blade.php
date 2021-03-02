@extends('admin.layout.main')

@section('content')

<div class="col-md-6">
    <!-- general form elements -->
    <div class="card card-success">
      <div class="card-header">
        <div class="col-md-6">
          <h3 class="card-title">Novo Serviço</h3>
        </div>
        <div class="col-md-6" style="float:right;">
          <a class="btn btn-info" href="{{ action('Admin\ServicoController@index') }}" role="button" style="float:right;">Relação</a>
        </div>
      </div>
      <form role="form" action="{{ action('Admin\ServicoController@store') }}" method="post">
        {!! csrf_field() !!}

        @include('admin.layout.validacao-error')
        @include('admin.layout.success')

        <div class="card-body">
          <div class="form-group">
              <label for="exampleInputNome">Descrição</label>
              <input type="text" class="form-control" name="ser_descricao" placeholder="Descrição Serviço" value="{{ old('ser_descricao') }}">
          </div>
          <div class="form-group">
              <label for="exampleInputNome">Tipo de Serviço</label>
              <select name="ser_tipo_servico" class="form-control">
                <option value=""></option>
                <option value="1">Revisão</option>
                <option value="2">Mecânica</option>
                <option value="3">Funilária</option>
                <option value="4">Borracharia</option>
              </select> 
          </div>
          <div class="form-group">
              <label for="exampleInputNome">Tempo Execução (minutos)</label>
              <input type="number" class="form-control" name="ser_time_execucao"
               placeholder="Tempo Execução" value="{{ old('ser_time_execucao') }}" min="1">
          </div>     
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-info">Adicionar</button>
        </div>
      </form>
    </div>
    <!-- /.card -->

  </div>

  @endsection