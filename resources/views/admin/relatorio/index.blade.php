
@extends('admin.layout.main')

@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>

<div class="col-md-6">
    <div class="card card-success">
      <div class="card-header">
        <div class="col-md-6">
          <h3 class="card-title">Relatórios</h3>
        </div>
      </div>

      <form  action="{{ action('Admin\RelatorioController@result',) }}" method="post">
        {!! csrf_field() !!}
        
        @include('admin.layout.validacao-error')
        @include('admin.layout.success')

        <div class="card-body">
          <div class="form-group">
            <label for="exampleInputDatede">De</label>
            <input class="date form-control" type="text" id="datede" name="datede">  
            <label for="exampleInputDateate">Até</label>
            <input class="date form-control" type="text" id="dateate" name="dateate">  
          </div>
          <div class="form-group">
            <label>Mecânico</label><br>
            <select name="mecanico" id="mecanico" class="form-control form-control-sm filtro">
                <option value=""></option>
                @foreach ($mecanicos as $mecanico)
                <option value="{{ $mecanico->usu_codigo }}">{{ $mecanico->usu_nome }}</option>
                @endforeach
            </select> 
          </div>
          
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-info">Gerar</button>
        </div>
      </form>
    </div>
    <!-- /.card -->

  </div>

<script type="text/javascript">
    $('.date').datepicker({  
       format: 'dd-mm-yyyy',
       locate: 'pt-br'    
     });  
    
</script>
@endsection