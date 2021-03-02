<div class="menu">
  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="#">Logo Carapp</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="{{ action('Front\HomeController@index') }}">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
          <a class="nav-link" href="{{ action('Front\HomeController@contato') }}">Contato</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ action('Front\HomeController@condutor') }}">Inscrever-se</a>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <a href="manager" class="btn btn-secondary my-2 my-sm-0" type="submit">Manager</a>
        </form>
      </div>
  </nav>
</div>