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
          <b style="color:#728ed1; font-size:28px;">CAR</b>
          <span  style="color:#294893; font-size:28px;">APP</span></p>
        <form id="frm-login" action="forgot-pass" method="POST" onsubmit="return validaDados();">
          {!! csrf_field() !!}
          <div class="input-group mb-3">
            <input type="text" id="email" name="email" class="form-control" placeholder="Digite seu Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>        
          <div class="row">
            <div class="col-6">
              
            </div>
            <div class="col-6">
              <button type="submit" class="btn btn-success btn-block">Recuperar Senha</button>
            </div>
          </div>
        </form>

        <p class="mb-1">
          <a href="manager">Login</a>
        </p>
  
        <div class="container">
          <div class="col-md-12">
              <div class="alert alert-danger" id="error" style="display: none;" role="alert">
              </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

  <script>
    function validaDados()
    {
      var email = $("#email").val();

      if (email.trim() == '') {
        $("#error").html('Email não Informado!');
        $("#error").show();
        
        setTimeout(function(){ 
          $("#error").hide();
          $("#error").html('');
          clearTimeout(0);
        }, 3000);

        return false;
      }

      return true;
    }
  </script>  


@endsection
