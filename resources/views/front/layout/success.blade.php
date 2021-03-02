@if(isset($success) && $success == true) 
<br>
<div class="container">
    <div class="col-md-12">
        <div class="alert alert-success" role="alert">
            <b> Cadastro Realizado com Sucesso!</b>
        </div>
    </div>
</div>
@endif

@if(isset($_GET['edicao'])) 
<br>
<div class="container">
    <div class="col-md-12">
        <div class="alert alert-success" role="alert">
            @if($_GET['edicao'] == true) 
            <b> Alteração Realizada com Sucesso!</b>
            @endif
        </div>
    </div>
</div>
@endif