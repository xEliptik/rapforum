<div class="sidebar" data-color="azure" data-background-color="azure" data-image="../assets/img/sidebar-1.jpg">
    <div class="logo"><a href="{{ url('dashboard') }}" class="simple-text logo-normal">
            ADMINISTRACION DE DATOS
        </a></div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('dashboard') }}">
                    <i class="material-icons">dashboard</i>
                    <p>Panel de Control</p>
                </a>
            </li>
            <li class="nav-item {{ Request::is('categories') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('categories') }}">
                    <i class="material-icons">content_paste</i>
                    <p>Categorías</p>
                </a>
            </li>

            <li class="nav-item {{ Request::is('sections') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('sections') }}">
                    <i class="material-icons">content_paste</i>
                    <p>Secciones</p>
                </a>
            </li>

            <li class="nav-item {{ Request::is('forum-admin') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('forum-admin') }}">
                    <i class="material-icons">content_paste</i>
                    <p>Foro</p>
                </a>
            </li>

            <li class="nav-item {{ Request::is('videoclips') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('videoclips') }}">
                    <i class="material-icons">videocam</i>
                    <p>Videoclips</p>
                </a>
            </li>
            <li class="nav-item active-pro ">
                <a class="nav-link" href="{{ url('/') }}">
                    <i class="material-icons">arrow_back_ios</i>
                    <p>Volver al Home</p>
                </a>
            </li>
            <hr>
            <li class="nav-item {{ Request::is('add-category') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('add-category') }}">
                    <i class="material-icons">add</i>
                    <p>Añadir Categorías</p>
                </a>
            </li>
            <li class="nav-item {{ Request::is('add-sections') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('add-sections') }}">
                    <i class="material-icons">add</i>
                    <p>Añadir Secciones</p>
                </a>
            </li>
            <li class="nav-item {{ Request::is('add-videoclip') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('add-videoclip') }}">
                    <i class="material-icons">add</i>
                    <p>Añadir Videoclips</p>
                </a>
            </li>
            <hr>
            <li class="nav-item {{ Request::is('users') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('users') }}">
                    <i class="material-icons">person</i>
                    <p>Usuarios</p>
                </a>
            </li>
        </ul>
    </div>
</div>
