@extends('admin.layout.main')

@section('content')

<div class="col-md-6">
    <!-- general form elements -->
    <div class="card card-success">
      <div class="card-header">
        <div class="col-md-6">
          <h3 class="card-title">Novo Usuário</h3>
        </div>
        <div class="col-md-6" style="float:right;">
          <a class="btn btn-info" href="{{ action('Admin\UsuarioController@index') }}" role="button" style="float:right;">Relação</a>
        </div>
      </div>
      <form role="form" action="{{ action('Admin\UsuarioController@store') }}" method="post">
        {!! csrf_field() !!}

        @include('admin.layout.validacao-error')
        @include('admin.layout.success')

        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputPassword1">Nome</label>
          <input type="text" class="form-control" name="usu_nome" placeholder="Nome Completo" value="{{ old('usu_nome') }}">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Login</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                </div>
                <input type="email" name="usu_email" class="form-control" placeholder="Email"  value="{{ old('usu_email') }}">
              </div>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Senha</label>
              <input type="password" name="usu_senha" class="form-control" placeholder="Password"  value="{{ old('usu_senha') }}">
            </div>
            <div class="form-group">
              <label>Nível de Acesso</label>
              <select class="custom-select" name="usu_nivel">
                <option value="">Selecione</option>
                @foreach ($niveis as $nivel)                  
                <option value="{{ $nivel->usn_codigo }}">{{ $nivel->usn_descricao }}</option>
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