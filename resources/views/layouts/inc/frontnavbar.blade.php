<nav class="navbar navbar-expand-xxl navbar-dark effect ">
    <div class="container-fluid">
        <div class="navbar-header ms-3">
            <a class="navbar-brand mt-4" href="{{ url('/') }}">
                <img src="../../assets/logo/image.png" alt="" width="55" height="55"
                    class="d-inline-block align-text-top">
            </a>
        </div>
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse justify-content-end" id="navbarContent">
            <ul class="navbar-nav me-4">
                <li class="nav-item">
                    <a class="menu-title nav-link {{ Request::is('/') ? 'active' : '' }}" aria-current="page"
                        href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="menu-title nav-link {{ Request::is('category') ? 'active' : '' }}"
                        href="{{ url('category') }}">Categorías</a>
                </li>

                <li class="nav-item">
                    <a class="menu-title nav-link {{ Request::is('forum') ? 'active' : '' }}"
                        href="{{ url('forum') }}">Foro</a>
                </li>

                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link menu-title {{ Request::is('login') ? 'active' : '' }}"
                                href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link menu-title {{ Request::is('register') ? 'active' : '' }}"
                                href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                        </li>
                    @endif
                @endguest
                @auth
                    <li class="nav-item">
                        @if (Auth::user()->role_as == '1')
                            <a class="menu-title nav-link" href="{{ route('admin.dashboard') }}">Administrador</a>
                        @endif
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        @php
                            $active = request()->route('username') == $user->username ? 'active' : '';
                        @endphp
                        <li class="nav-item dropdown">
                            <a class="menu-title nav-link dropdown-toggle {{ $active }}" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('assets/uploads/user/' . Auth::user()->image) }}"
                                    alt="{{ Auth::user()->name }}" width="25" height="25" class="rounded-circle">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('user', $user->username) }}">
                                        <img src="{{ asset('assets/uploads/user/' . Auth::user()->image) }}"
                                            alt="{{ Auth::user()->name }}" width="25" height="25"
                                            class="rounded-circle">
                                        Perfil</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                <li>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i style="font-size:18px" class="fa">&#xf08b;</i>
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form-2" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>

                            </ul>
                        </li>
                    </form>
                @endauth
            </ul>
        </div>

        <div class="position-absolute left-50 translate-middle-x mb-2">
            <a class="titlepage navbar-brand" href="{{ url('/') }}">
                The Rap Room
            </a>
        </div>
    </div>
</nav>
<nav>
