@extends('front.layout.main')

@section('content')
   
<div class="content" style="padding-top: 30px;">
  <div class="container-fluid">
      <div class="row">

        <!-- Cadastro de Novo Condutor -->
        <div class="col-md-12">
          <div class="card card-success">
            <div class="card-header">
              <div class="col-md-6">
                <h3 class="card-title">Inscrever-se</h3>
              </div>
            </div>
            <form role="form" action="{{ action('Front\HomeController@condutorStore') }}" method="post" onsubmit="return validaData();">
              {!! csrf_field() !!}

              @include('front.layout.validacao-error')
              @include('front.layout.success')

              <div class="card-body row">
                <div class="col-md-3">
                  <h5 class="inscricao alert-info">Seus Dados</h5>
                  <div class="form-group">
                    <label for="exampleInputNome">Nome<span class="obrig">*</span></label>
                    <input type="text" class="form-control" id="usu_nome" name="usu_nome" placeholder="" value="{{ old('usu_nome') }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputNome">Email<span class="obrig">*</span></label>
                      <input type="text" class="form-control" id="usu_email" name="usu_email" placeholder="" value="{{ old('usu_email') }}">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputNome">Confirme seu Email<span class="obrig">*</span></label>
                      <input type="text" class="form-control" id="conf_email" name="conf_email" placeholder="" value="{{ old('cli_cnp') }}">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputNome">Senha<span class="obrig">*</span></label>
                      <input type="password" class="form-control" id="usu_senha" name="usu_senha" placeholder="" value="{{ old('cli_cnp') }}">
                    </div>
                    <span class="obrig">* Campos obrigatórios</span>
                  </div>
                  <div class="col-md-3">
                    <h5 class="inscricao alert-info">Adicionar Veículo</h5>
                    <div class="form-group">
                      <div>
                        <div class="form-group">
                          <label for="exampleInputNome">Marca<span class="obrig">*</span></label>
                          <select class="form-control" id="marca" name="usv_marca">
                            <option value="0">Selecione uma Marca</option>
                            @foreach($marcas as $marca)
                              <option value="{{ $marca->mac_codigo }}">{{ $marca->mac_nome }}</option>
                            @endforeach
                          </select>  
                        </div>

                        <div class="form-group">
                          <label for="exampleInputNome">Modelo<span class="obrig">*</span></label>
                          <select class="form-control" id="modelo" name="usv_modelo">
                            <option></option>
                          </select>  
                        </div>
                          
                        <div class="form-group">
                          <label for="exampleInputNome">Placa<span class="obrig">*</span></label>
                          <input type="text" class="form-control" id="placa" name="usv_placa" value="{{ old('cli_cnp') }}">
                        </div>
                          
                        <div class="form-group">
                          <label for="exampleInputNome">KM Atual</label>
                          <input type="text" class="form-control" id="km" name="km_atual" value="{{ old('cli_cnp') }}">
                        </div>

                        <div id="add" class="btn btn-info" style="">Adicionar Veiculo</div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <h5 class="inscricao alert-info">Veículos</h5>
                      <div>
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">Marca</th>
                              <th scope="col">Modelo</th>
                              <th scope="col">Placa</th>
                              <th scope="col">KM Atual</th>
                              <th scope="col"></th>
                            </tr>
                          </thead>
                          <tbody id="veiculos">

                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer right">
                <button type="submit" class="btn btn-info" style="">Confirmar Inscrição</button>
              </div>
            </form>
          </div>
          <!-- /.card -->
          </div>
        </div>
      </div>    
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    
  <script>
    $("#add").click(function(){
      error = false;
      $("#error").html('');

      var marca  = $( "#marca" ).val();
      var modelo = $( "#modelo" ).val();
      var placa  = $( "#placa" ).val();

      if (marca == 0) {
        $("#error").append('<li>Marca deve ser selecionada!</li>');
        error = true;
      }

      if (modelo == 0) {
        $("#error").append('<li>Modelo deve ser selecionada!</li>');
        error = true;
      }

      if (placa.trim() == '') {
        $("#error").append('<li>Placa deve ser informada!</li>');
        error = true;
      }

      if (error) {
        $("#error").show();
        setTimeout(function(){ 
          $("#error").hide();
          $("#error").html('');
          clearTimeout(0);
        }, 3000);
        return false;
      }

      var veiculo = '<tr>' +
                        '<th scope="row">'+ $("#marca option:selected").html() +'</th>' +
                        '<td>'+ $("#modelo option:selected").html()  +'</td>' +
                        '<td>'+ $("#placa").val() +'</td>' +
                        '<td>'+ $("#km").val() +'</td>' +
                        '<td><a class="remove" onclick="$(this).parent().parent().remove();">X</a></td>' +
                        '<input type="hidden" name="marca[]" value="'+$("#marca").val()+'">' +
                        '<input type="hidden" name="modelo[]" value="'+$("#modelo").val()+'">' +
                        '<input type="hidden" name="placa[]" value="'+$("#placa").val()+'">' +
                        '<input type="hidden" name="km[]" value="'+$("#km").val()+'"> ' +
                    '</tr>';

      $("tbody#veiculos").append(veiculo);              
    });

    $("#marca").change(function(){
      let xhr = new XMLHttpRequest();
      xhr.open('GET', "modelo/" + $("#marca").val(), true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
          if (xhr.status = 200) {
            result = JSON.parse(xhr.responseText);
            var option = '';

            for(var k in result) {
              option += '<option value="'+ result[k].mod_codigo +'">'+ result[k].mod_nome +'</option>';
            }

            $("#modelo").html(option);
          }
	      }
      }

      xhr.send();      
    });

    function validaData()
    {
      error = false;
      $("#error").html('');

      var nome  = $("#usu_nome").val();
      var email = $("#usu_email").val();
      var conf  = $("#conf_email").val();
      var senha = $("#usu_senha").val();
      var veiculos = $( "#veiculos" ).html();

      if (nome.trim() == '') {
        $("#error").append('<li>Nome deve ser informado!</li>');
        error = true;
      }

      if (email.trim() == '') {
        $("#error").append('<li>Email deve ser informado!</li>');
        error = true;
      }

      if (conf.trim() == '') {
        $("#error").append('<li>Confirmação do Email deve ser informado!</li>');
        error = true;
      }

      if (email.trim() != conf.trim()) {
        $("#error").append('<li>Confirmação do Email diferente do Email!</li>');
      }

      if (senha.trim() == '') {
        $("#error").append('<li>Senha deve ser informada!</li>');
        error = true;
      }

      if (veiculos.trim() == '') {
        $("#error").append('<li>Você precisa adicionar pelo menos 1 Veículo!</li>');
        error = true;
      }

      if (error) {
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