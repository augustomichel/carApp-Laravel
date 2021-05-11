<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ action('Front\HomeController@index') }}" class="brand-link">
      <img src="{{ asset('img/carapp-logo.png') }}" alt="Apphicina" class="brand-image "
           style="opacity: .8">
      <span class="brand-text font-weight-light">&nbsp;</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        </div>
        <div class="info">
          <a href="" class="d-block"><i class="fas fa-user-circle"></i>&nbsp&nbsp
            @if(Session::has('user-nome'))
              {{ Session::get('user-nome')}}
            @endif
          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @include('front.layout.menu')          
        </ul>
      </nav>
    </div>
</aside>