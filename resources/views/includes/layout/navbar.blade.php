{{--    <nav id="fixed" class="navbar navbar-expand">
        <a class="ms-5" href="http://localhost:5173/">
            <div class="logo flex-shrink-0 d-none d-sm-block my-3 mx-3">
                <img src="{{ url('/boolBNB-logo.png') }}" alt="Logo BoolBnB" class="logo">
            </div>
        </a>

        <div class="container">


            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">


                </ul>

                <!-- Right Side Of Navbar -->

            </div>
        </div>
        <ul class="navbar-nav ml-auto me-5 d-flex align-items-center">
            @auth
                <li class="nav-item">
                    <a id="nav-link" class="nav-link  @if (request()->routeIs('admin.estates.index')) active @endif"
                        href="{{ route('admin.estates.index') }}"><i class="fa-solid fa-building-user fa-xl"></i>
                        <br>
                        I miei alloggi
                    </a>
                </li>
                <li class="nav-item">
                    <a id="nav-link" class="nav-link @if (request()->routeIs('admin.estates.messages')) active @endif"
                        href="{{ route('admin.estates.messages') }}">
                        <i class="fa-solid fa-envelope fa-xl"></i>
                        <br>
                        Messaggi</a>
                </li>
            @else
                {{--   <li class="nav-item">
            <a class="nav-link @if (request()->routeIs('guest.home')) active @endif"
                href="{{ route('guest.home') }}">Home</a>
        </li> --}}
{{--  @endauth --}}
<!-- Authentication Links -->
{{--    @guest --}}
{{-- 
            <i class="fa-solid fa-user-gear fa-2xl"></i> --}}

{{--   <li class="nav-item" id="login">
                    <a class="nav-link " id="nav-link" href="{{ route('login') }}">Accedi</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" id="nav-link" href="{{ route('register') }}">Registrati</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="fa-solid fa-circle-user fa-xl"></i>
                        <br>
                        @if (Auth::user()->name)
                            {{ Auth::user()->name }}
                        @else
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
        </ul> --}}
{{--  </nav> --}}


<header class="d-flex align-items-center justify-content-between container-fluid">
    <a href="http://localhost:5173/">
        <div class="flex-shrink-0 d-none d-sm-block">
            <img src="{{ url('/BOOLlogo.svg') }}" alt="Logo BoolBnB" class="logo">
        </div>
    </a>

    <nav role='navigation'>
        <div id="menuToggle" class="hamburger">
            <input type="checkbox" />
            <span></span>
            <span></span>
            <span></span>
            <ul id="menu">

                @auth
                    <a href="{{ url('profile') }}">
                        <li>
                            @if (Auth::user()->name)
                                {{ Auth::user()->name }}
                            @else
                                User
                            @endif
                        </li>
                    </a>
                @endauth

                @guest
                    <a href="http://127.0.0.1:8000/register">
                        <li class="hamburger_li">Registrati</li>
                    </a>
                    <a href="http://127.0.0.1:8000/login">
                        <li class="hamburger_li">Accedi</li>
                    </a>

                @endguest
                <a href="http://127.0.0.1:8000/admin/estates">
                    <li class="hamburger_li">I miei Appartamenti</li>
                </a>
                <a href="http://127.0.0.1:8000/admin/estates/messages">
                    <li class="hamburger_li">Messaggi</li>
                </a>
                <a href="http://localhost:5173/SearchPage">
                    <li class="hamburger_li">Ricerca avanzata</li>
                </a>
                @auth
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
                        <li>
                            Esci
                        </li>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endauth
            </ul>
        </div>
    </nav>
</header>
