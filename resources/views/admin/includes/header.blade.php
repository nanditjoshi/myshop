

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
    </ul>

   
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- User Account: style can be found in dropdown.less -->
      <li class="nav-link dropdown user user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <img src="https://via.placeholder.com/150" class="user-image" alt="User Image">
            <span class="hidden-xs">{{ auth()->user()->name }}</span>
        </a>
        <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
                <img src="https://via.placeholder.com/150" class="img-circle" alt="User Image">

                <p>{{ auth()->user()->name }}</p>
            </li>
            
            <li class="user-footer">
                <div class="btn-group">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();" class="btn btn-default  float-right">Sign out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                
            </li>
        </ul>
    </li>
      
    </ul>
  </nav>
  <!-- /.navbar -->