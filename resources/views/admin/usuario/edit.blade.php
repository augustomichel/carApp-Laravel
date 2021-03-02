@extends('admin.layout.main')

@section('content')

<div class="col-md-6">
    <div class="card card-success">
      <div class="card-header">
        <div class="col-md-6">
          <h3 class="card-title">Edição de Usuário</h3>
        </div>
        <div class="col-md-6" style="float:right;">
          <a class="btn btn-info" href="{{ action('Admin\UsuarioController@index') }}" role="button" style="float:right;">Relação</a>
        </div>
      </div>

      <form role="form" action="{{ action('Admin\UsuarioController@update', $usuarioed->usu_codigo) }}" method="post">
        {!! csrf_field() !!}
        {{ method_field('PUT') }}

        @include('admin.layout.validacao-error')
        @include('admin.layout.success')

        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputPassword1">Nome</label><br>
            {{ $usuarioed->usu_nome }}
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Login</label>
            <div class="input-group mb-3">
                {{ $usuarioed->usu_email }}
             </div>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Senha</label><br>
            ****************
            <input type="password" name="usu_senha" class="form-control" placeholder="Se deseja alterar sua senha, Digite!">
            <input type="hidden" name="usu_senha_ant" class="form-control" placeholder="Password" value="{{ $usuarioed->usu_senha }}">
          </div>
          <div class="form-group">
            <label>Nível de Acesso</label>
            <select class="custom-select" name="usu_nivel">
              @if ($usuarioed->usu_nivel == 6)
                <option value="{{ $usuarioed->usu_nivel }}" selected>CONDUTOR</option>
              @else
                @foreach ($niveis as $nivel)
                  @if($nivel->usn_codigo == $usuarioed->usu_nivel)                  
                    <option value="{{ $nivel->usn_codigo }}" selected>{{ $nivel->usn_descricao }}</option>
                  @else
                    <option value="{{ $nivel->usn_codigo }}">{{ $nivel->usn_descricao }}</option>
                  @endif
                @endforeach
              @endif

            </select>
          </div>
          <div class="form-group">
            <label>Status</label><br>
            <select name="usu_status" class="form-control">
              <option value="S" @if($usuarioed->usu_status == 'S') selected @endif>ATIVO</option>
              <option value="N" @if($usuarioed->usu_status == 'N') selected @endif>INATIVO</option>
            </select> 
          </div>
          <div class="form-group">
            <label>Status Atual</label><br>
            @if($usuarioed->usu_status == 'S')
              <span class="badge badge-success">ATIVO</span>
            @endif
              
            @if($usuarioed->usu_status == 'N')
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