
<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a href="{{ route('dashboard.home.index', [], false) }}" class="navbar-brand navbar-brand-autodark">
            {{ config('app.name') }}
        </a>
        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                <li class="nav-item {{ request()->routeIs('dashboard.home.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dashboard.home.index', [], false) }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dashboard" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                               <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                               <path d="M12 13m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                               <path d="M13.45 11.55l2.05 -2.05"></path>
                               <path d="M6.4 20a9 9 0 1 1 11.2 0z"></path>
                            </svg>
                        </span>
                        <span class="nav-link-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('dashboard.product.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dashboard.product.index', [], false) }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-building-store" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                               <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                               <path d="M3 21l18 0"></path>
                               <path d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4"></path>
                               <path d="M5 21l0 -10.15"></path>
                               <path d="M19 21l0 -10.15"></path>
                               <path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4"></path>
                            </svg>
                        </span>
                        <span class="nav-link-title">Products</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('dashboard.category.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dashboard.category.index', [], false) }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-category" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                               <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                               <path d="M4 4h6v6h-6z"></path>
                               <path d="M14 4h6v6h-6z"></path>
                               <path d="M4 14h6v6h-6z"></path>
                               <path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                            </svg>
                        </span>
                        <span class="nav-link-title">Categories</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('dashboard.user.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dashboard.user.index', [], false) }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855"></path>
                            </svg>
                        </span>
                        <span class="nav-link-title">Users</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('auth.logout') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('auth.logout', [], false) }}" onclick="
                        event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                               <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                               <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                               <path d="M9 12h12l-3 -3"></path>
                               <path d="M18 15l3 -3"></path>
                            </svg>
                        </span>
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</aside>
