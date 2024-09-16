<header>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('welcome') }}">{{ config('app.name') }}</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Dashboard</a>
                        </li>
                        @if (Auth::user()->hasRole('Landlord'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('rentals.index') }}">My Rentals</a>
                            </li>
                        @elseif (Auth::user()->hasRole('Tenant'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('rentals.houses.tenants.show', ['rentalUuid' => Auth::user()->tenant->house->rental->uuid, 'houseUuid' => Auth::user()->tenant->house->uuid, 'tenantUuid' => Auth::user()->tenant->uuid]) }}">{{ Auth::user()->tenant->house->name }}</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.edit', ['userUuid' => auth()->user()->uuid]) }}" title="My Profile">
                                @php
                                    $fullNameArray = explode(' ', Auth::user()->name);
                                    echo $fullNameArray[0];
                                @endphp
                            </a>
                        </li>
                        @canany(['roles.index', 'users.index'])
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Access Control
                                </a>
                                <ul class="dropdown-menu">
                                    @can('roles.index')
                                        <li>
                                            <a class="dropdown-item" href="{{ route('roles.index') }}">Roles</a>
                                        </li>
                                    @endcan
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="#">Users</a>
                                    </li>
                                </ul>
                            </li>
                        @endcanany
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @else
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link"href="{{ route('login') }}">Login</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link"href="{{ route('register') }}">Create Account</a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</header>
