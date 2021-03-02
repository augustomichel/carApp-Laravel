@extends('front.layout.manager')

@section('content')

<div class="login-box">
  <div class="login-logo">
    <a href="login">
      <img src="img/bravya-logo.png" alt="" class="brand-image " 
      style="opacity: .8">
    </a>
  </div>
  <div class="card">
    <div class="card-body login-card-body" style="background-color: #eaebeb;">
      <p class="login-box-msg">
        <b style="color:#728ed1; font-size:28px;">APP</b>
        <span  style="color:#294893; font-size:28px;">HICINA</span></p>
      <form id="frm-login" action="auth" method="POST">
        {!! csrf_field() !!}
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" value="">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="senha" class="form-control" placeholder="Password" value="">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Manter-me conectado
              </label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-success btn-block">Entrar</button>
          </div>
        </div>
      </form>

      <p class="mb-1">
        <a href="forgot">Esqueceu a Senha</a>
      </p>

      @include('admin.layout.alert')

    </div>
  </div>
</div>

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

@endsection
