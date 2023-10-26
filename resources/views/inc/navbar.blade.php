<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('create.form') }}">FormAlchemy</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('create.form') ? 'active' : '' }}" href="{{ route('create.form') }}">Home</a>
                </li>
            @if (auth()->check() != '')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="#">Dashboard</a>
                </li>
            @endif
        </ul>
        <ul class="navbar-nav ml-auto">
            @if (auth()->check() == '')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Signup</a>
                </li>
            @else
                <p class="pr-2 pl-5 mb-0"><span class="nav-link" style="font-weight: bold">Hi,
                        {{ auth()->user()->name }}</span></p>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="btn nav-link">Logout</button>
                    </form>
                </li>
            @endif
        </ul>
    </div>
</nav>
