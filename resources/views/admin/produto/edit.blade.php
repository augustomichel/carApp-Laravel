@extends('admin.layout.main')

@section('content')

<div class="col-md-6">
    <div class="card card-success">
      <div class="card-header">
        <div class="col-md-6">
          <h3 class="card-title">Edição de Usuário</h3>
        </div>
        <div class="col-md-6" style="float:right;">
          <a class="btn btn-info" href="{{ action('Admin\ProdutoController@index') }}" role="button" style="float:right;">Relação</a>
        </div>
      </div>

      <form role="form" action="{{ action('Admin\ProdutoController@update', $produto->pro_codigo) }}" method="post">
        {!! csrf_field() !!}
        {{ method_field('PUT') }}

        @include('admin.layout.validacao-error')
        @include('admin.layout.success')

        <div class="card-body">
          <div class="form-group">
              <label for="exampleInputNome">Nome</label>
              <input type="text" class="form-control" name="pro_nome" placeholder="Nome Produto" value="{{ $produto->pro_nome }}">
              <input type="hidden" class="form-control" name="pro_nome_old" placeholder="Nome Produto" value="{{ $produto->pro_nome }}">
          </div>
          <div class="form-group">
            <label>Status</label><br>
            <select name="pro_status" class="form-control">
                <option value="S" @if($produto->pro_status == 'S') selected @endif>ATIVO</option>
                <option value="N" @if($produto->pro_status == 'N') selected @endif>INATIVO</option>
            </select> 
          </div>
          <div class="form-group">
            <label>Status Atual</label><br>
            @if($produto->pro_status == 'S')
              <span class="badge badge-success">ATIVO</span>
            @endif
              
            @if($produto->pro_status == 'N')
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