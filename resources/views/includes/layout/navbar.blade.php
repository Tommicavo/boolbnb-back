<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('admin.home')) active @endif"
                            href="{{ route('admin.home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('admin.estates.index')) active @endif"
                            href="{{ route('admin.estates.index') }}">Index</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('admin.estates.trash')) active @endif"
                            href="{{ route('admin.estates.trash') }}">Trash</a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('admin.estates.create')) active @endif"
                            href="{{ route('admin.estates.create') }}">Aggiungi</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('guest.home')) active @endif"
                            href="{{ route('guest.home') }}">Home</a>
                    </li>
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('admin.home') }}">Dashboard</a>
                            <a class="dropdown-item" href="{{ url('profile') }}">Profile</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
