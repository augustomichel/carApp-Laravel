@extends('admin.layout.main')

@section('content')

<div class="col-md-6">
    <!-- general form elements -->
    <div class="card card-success">
      <div class="card-header">
        <div class="col-md-6">
          <h3 class="card-title">Novo Cliente</h3>
        </div>
        <div class="col-md-6" style="float:right;">
          <a class="btn btn-info" href="{{ action('Admin\ClienteController@index') }}" role="button" style="float:right;">Relação</a>
        </div>
      </div>
      <form role="form" action="{{ action('Admin\ClienteController@store') }}" method="post">
        {!! csrf_field() !!}

        @include('admin.layout.validacao-error')
        @include('admin.layout.success')

        <div class="card-body">
          <div class="form-group">
            <label for="nomeInput">Nome</label>
            <input type="text" class="form-control" name="cli_nome" placeholder="Nome Cliente" value="{{ old('cli_nome') }}">
          </div>
          <div class="form-group">
            <label for="cnpjInput">CNPJ</label>
            <input type="text" class="form-control" name="cli_cnp" placeholder="CNPJ" value="{{ old('cli_cnp') }}">
          </div>
          <div class="form-group">
            <label for="matrixSelect">Matriz</label>
            <select class="custom-select" name="cli_matriz">
                <option value="">Selecione</option>
                @foreach ($matrizes as $matriz)                  
                <option value="{{ $matriz->cli_codigo }}">{{ $matriz->cli_nome }}</option>
                @endforeach
            </select>
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