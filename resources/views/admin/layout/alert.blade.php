@if(isset($_GET['error'])) 
    @if($_GET['error'] == 1) 
        <p class="mb-0 alert alert-danger text-center">
        Dados de acesso Inválido!
        </p>
    @endif
    
    @if($_GET['error'] == 2)
        <p class="mb-0 alert alert-danger text-center">
        Usuário ou Senha Inválido!
        </p>
    @endif
        
    @if($_GET['error'] != 1 && $_GET['error'] != 2)
        <br>
        <p class="mb-0 alert alert-danger text-center">
        <?=$_GET['error'];?>
        </p>
    @endif

@endif

@if(isset($_GET['success'])) 
    @if($_GET['success'] == 1) 
        <p class="mb-0 alert alert-success text-center">
            Dados de Recuperação de Senha enviado para o Email informado!
        </p>
    @endif
@endif    
