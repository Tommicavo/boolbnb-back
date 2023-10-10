<header id="header" class="d-flex align-items-center justify-content-between container-fluid ps-4">
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
                @auth

                    <a href="http://127.0.0.1:8000/admin/estates">
                        <li class="hamburger_li">I miei Appartamenti</li>
                    </a>
                    <a href="http://127.0.0.1:8000/admin/estates/messages">
                        <li class="hamburger_li">Messaggi</li>
                    </a>
                @endauth

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
