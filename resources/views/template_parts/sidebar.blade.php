<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ url('/') }}" class="brand-link">
    <img src="{{ asset('img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light"> {{ config('app.name', 'Laravel') }}</span>
  </a>
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Alexander Pierce</a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
       
        <li class="nav-item">
          <router-link  to="/home"  class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Inicio
            </p>
          </router-link>
        </li>
        <!--li :class="{'nav-item':true,' menu-open':$router.history.current.path=='/visitas' || $router.history.current.path=='/visitaprogramada' } ">
          <a href="#" :class="{'nav-link':true ,'active':$router.history.current.path=='/visitas' || $router.history.current.path=='/visitaprogramada' }">
            <i class="nav-icon fas fa-eye"></i>
            <p>
              Visita Contenido
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview " :style="{display:$router.history.current.path=='/visitas' || $router.history.current.path=='/visitaprogramada'  ? 'block' : 'none'}">
            
            
    
          </ul>
        </li-->

        <li class="nav-item">
          <router-link  to="/visitas"  class="nav-link " >
            <i class="nav-icon fas fa-eye"></i>
            <p>
              Visitas
            </p>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link  to="/visitaprogramada"  class="nav-link " >
            <i class="nav-icon fas fa-eye"></i>
            <p>
              Visitas Programadas
            </p>
          </router-link>
        </li>
        @role('Administrator')
          <li class="nav-item">
            <router-link  to="/oficinas"  class="nav-link">
              <i class="nav-icon fas fa-laptop-house"></i>
              <p>
                Oficinas
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link  to="/users"  class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Usuarios
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link  to="/motivos"  class="nav-link">
              <i class="nav-icon fas fa-bookmark"></i>
              <p>
                Motivos
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link  to="/sedes"  class="nav-link">
              <i class="nav-icon fas fa-building"></i>
              <p>
                Sedes
              </p>
            </router-link>
          </li>
        @endrole

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>