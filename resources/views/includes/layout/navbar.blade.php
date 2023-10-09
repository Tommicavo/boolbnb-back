<nav class="navbar navbar-expand navbar-light bg-white shadow-sm">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('admin.estates.index')) active @endif"
                            href="{{ route('admin.estates.index') }}">Annunci</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('admin.estates.messages')) active @endif"
                            href="{{ route('admin.estates.messages') }}">Messaggi</a>
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
                        <a class="nav-link" href="{{ route('login') }}">Accedi</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registrati</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            @if (Auth::user()->name)
                                {{ Auth::user()->name }}
                            @else
                                <i class="fa-solid fa-gear"></i>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('admin.estates.index') }}">Pannello di Controllo</a>
                            <a class="dropdown-item" href="{{ url('profile') }}">Profilo</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                Esci
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
