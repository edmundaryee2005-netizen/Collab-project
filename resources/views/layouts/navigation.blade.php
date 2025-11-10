<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <!-- Brand Logo -->
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">
            Shop Zone
        </a>
        
        <!-- Toggler for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#appNavbar" aria-controls="appNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="appNavbar">
            
            <!-- Search Bar (Responsive) -->
            <form class="d-flex mx-auto w-100 w-md-50 w-lg-25" role="search" action="{{ route('products.index') }}" method="GET">
                <input class="form-control rounded-pill me-2" type="search" name="search" placeholder="Search products..." aria-label="Search" value="{{ request('search') }}">
                <button class="btn btn-outline-success rounded-pill" type="submit">Search</button>
            </form>

            <!-- Main Nav Links -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                
                @guest
                    <!-- Show for guests -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @else
                    <!-- Show for logged-in users -->
                    <li class="nav-item">
                        <!-- MODIFIED: This link now clearly says "All Products" -->
                        <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                    </li>

                    <!-- User Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <!-- This link now goes to your new dashboard! -->
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">My Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">My Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <!-- Logout Button Form -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); this.closest('form').submit();">
                                        Log Out
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

