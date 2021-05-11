@extends('front.layout.main')

@section('content')

<div class="container">
  <div class="col-md-10">
    <!-- general form elements -->
    <div class="card card-success">
      <div class="card-header">
        <div class="col">
          <h3 class="card-title">Novo Veículo</h3>  
          <div>
            <a class="btn btn-info" href="{{ action('Front\VeiculoController@index') }}" role="button" style="float:right; margin-top: -45px;">Relação</a>
          </div> 
        </div>
      </div>
   
      <form role="form" action="{{ action('Front\VeiculoController@store') }}" method="post">
        {!! csrf_field() !!}

        @include('front.layout.validacao-error')
        @include('front.layout.success')

        <div class="card-body">
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
                <input type="text" class="form-control" style="text-transform:uppercase" id="placa" name="usv_placa" value="{{ old('usv_placa') }}">
              </div>
                
              <div class="form-group">
                <label for="exampleInputNome">KM Atual</label>
                <input type="text" class="form-control" id="km" name="km_atual" value="{{ old('usv_kmatual') }}">
              </div>
            </div>
          </div>
        </div>                  
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-info" >Cadastrar</button>
        </div>
      </form>
    </div>
    <!-- /.card -->

  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>

  $("#marca").change(function(){
    let xhr = new XMLHttpRequest();
    xhr.open('GET', "/modelo/" + $("#marca").val(), true);
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
</script>  
@endsection
