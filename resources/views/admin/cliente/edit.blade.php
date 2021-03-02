@extends('admin.layout.main')

@section('content')

<div class="col-md-6">
    <div class="card card-success">
      <div class="card-header">
        <div class="col-md-6">
          <h3 class="card-title">Edição de Cliente</h3>
        </div>
        <div class="col-md-6" style="float:right;">
          <a class="btn btn-info" href="{{ action('Admin\ClienteController@index') }}" role="button" style="float:right;">Relação</a>
        </div>
      </div>

      <form role="form" action="{{ action('Admin\ClienteController@update', $cliente->cli_codigo) }}" method="post">
        {!! csrf_field() !!}
        {{ method_field('PUT') }}

        @include('admin.layout.validacao-error')
        @include('admin.layout.success')

        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputCliente">Cliente</label><br>
            <input type="text" class="form-control" name="cli_nome" placeholder="Nome Cliente" value="{{ $cliente->cli_nome }}">
            <input type="hidden" class="form-control" name="cli_nome_old" placeholder="Nome Cliente" value="{{ $cliente->cli_nome }}">
          </div>
          <div class="form-group">
            <label for="exampleInputCnp">CNPJ</label><br>
            <input type="text" class="form-control" name="cli_cnp" placeholder="CNPJ" value="{{ $cliente->cli_cnp }}">
            <input type="hidden" class="form-control" name="cli_cnp_old" placeholder="CNPJ" value="{{ $cliente->cli_cnp }}">
          </div>
          <div class="form-group">
            <label for="matrixSelect">Matriz</label>
            <select class="custom-select" name="cli_matriz">
                <option value="">Selecione</option>
                @foreach ($matrizes as $matriz)   
                  @if($cliente->cli_matriz == $matriz->cli_codigo)               
                    <option value="{{ $matriz->cli_codigo }}" selected>{{ $matriz->cli_nome }}</option>
                  @else 
                    <option value="{{ $matriz->cli_codigo }}">{{ $matriz->cli_nome }}</option>
                  @endif
                @endforeach
            </select>
          </div>
        
          <div class="form-group">
            <label>Status</label><br>
            <select name="cli_status" class="form-control">
              <option value="S" @if($cliente->cli_status == 'S') selected @endif>ATIVO</option>
              <option value="N" @if($cliente->cli_status == 'N') selected @endif>INATIVO</option>
            </select> 
          </div>
          <div class="form-group">
            <label>Status Atual</label><br>
            @if($cliente->cli_status == 'S')
              <span class="badge badge-success">ATIVO</span>
            @endif
              
            @if($cliente->cli_status == 'N')
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