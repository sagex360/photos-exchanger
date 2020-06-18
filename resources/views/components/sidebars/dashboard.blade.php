<div class="nav-left-sidebar sidebar-dark">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="d-xl-none d-lg-none" href="{{ route('dashboard.home') }}">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-divider">
                        Menu
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @ifroute('dashboard.home') active @endifroute"
                           href="{{ route('dashboard.home') }}">
                            <i class="fas fa-tachometer-alt"></i>
                            Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @ifroute('dashboard.files') active @endifroute"
                           href="{{ route('dashboard.files.index') }}" data-toggle="collapse"
                           aria-expanded="false"
                           data-target="#submenu-1" aria-controls="submenu-1">
                            <i class="fas fa-stream"></i>
                            Files</a>
                        <div id="submenu-1" class="submenu collapse @ifroute('dashboard.files') show @endifroute">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link @ifroute('dashboard.files.index') active @endifroute"
                                       href="{{ route('dashboard.files.index') }}">All files</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @ifroute('dashboard.files.create') active @endifroute"
                                       href="{{ route('dashboard.files.create') }}">Add new</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           target="_self"
                           href="{{ route('auth.logout.perform') }}"
                           onclick="event.preventDefault(); document.getElementById('admin-logout-post-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout</a>
                        <form id="admin-logout-post-form" action="{{ route('auth.logout.perform') }}" method="post"
                              style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
