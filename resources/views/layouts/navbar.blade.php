<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="/">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Users
            </a>
            <ul class="dropdown-menu">
              <li><a class="{{ Request::is('users') ? 'dropdown-item active' : 'dropdown-item' }}" href={{ route('users.index') }}>List</a></li>
              <li><a class="{{ Request::is('users/create') ? 'dropdown-item active' : 'dropdown-item'}}" href={{ route('users.create') }}>New User</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Posts
            </a>
            <ul class="dropdown-menu">
              <li><a class="{{ Request::is('posts') ? 'dropdown-item active' : 'dropdown-item' }}" href={{ route('posts.index') }}>List</a></li>
              <li><a class="{{ Request::is('posts/create') ? 'dropdown-item active' : 'dropdown-item'}}" href={{ route('posts.create') }}>New Post</a></li>
            </ul>
          </li>

          <li class="nav-item nav">
              
          </li>

          <li class="nav-item mx-5">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">
              @if(Auth::user())
                Welcome {{ Auth::user()->name }}
              @endif
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
