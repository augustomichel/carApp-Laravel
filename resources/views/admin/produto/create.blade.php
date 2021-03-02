@extends('admin.layout.main')

@section('content')

<div class="col-md-6">
    <!-- general form elements -->
    <div class="card card-success">
      <div class="card-header">
        <div class="col-md-6">
          <h3 class="card-title">Novo Produto</h3>
        </div>
        <div class="col-md-6" style="float:right;">
          <a class="btn btn-info" href="{{ action('Admin\ProdutoController@index') }}" role="button" style="float:right;">Relação</a>
        </div>
      </div>
      <form role="form" action="{{ action('Admin\ProdutoController@store') }}" method="post">
        {!! csrf_field() !!}

        @include('admin.layout.validacao-error')
        @include('admin.layout.success')

        <div class="card-body">
          <div class="form-group">
              <label for="exampleInputNome">Nome</label>
              <input type="text" class="form-control" name="pro_nome" placeholder="Nome Produto" value="{{ old('pro_nome') }}">
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