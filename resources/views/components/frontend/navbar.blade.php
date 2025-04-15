<nav id="navmenu" class="navmenu">
    <ul>
        <li><a href="/" class="active">Home</a></li>
        <li><a href="{{ route('about') }}">About</a></li>
        @php
            $categories = \App\Models\Category::where('status', 'Active')->get();
        @endphp
        <li class="dropdown"><span>Categories</span> <i class="bi bi-chevron-down toggle-dropdown"></i>
            <ul>
                @foreach ($categories as $cat)
                    <li><a href="{{ route('cat.dropdown', $cat->id) }}">{{ $cat->name }}</a></li>
                @endforeach
            </ul>
        </li>
        <li><a href="{{ route('contact') }}">Contact</a></li>

        @auth
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <li> <button type="submit" class="pt-3 bg-transparent border-0">Logout</button> </li>
            </form>

            <li><a href="{{ route('profile') }}">Your Profile</a></li>
        @else
            <a href="{{ route('register') }}">
                Register
            </a>
            <a href="{{ route('login') }}">
                login
            </a>
        @endauth

    </ul>
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>
