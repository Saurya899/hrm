<header class="top-navbar">
    <div class="navbar-left">
        <button class="sidebar-toggle-btn" id="sidebar-toggle">
            <i class="bi bi-justify"></i>
        </button>
        <div class="global-search-container d-none d-md-block">
            <i class="bi bi-search global-search-icon"></i>
            <input type="text" class="global-search-input" placeholder="Search Appointments, Dates, Doctors...">
        </div>
    </div>

    <div class="navbar-right">
        <button class="nav-icon-btn" id="theme-toggle">
            <i class="bi bi-moon-stars-fill"></i>
        </button>
        <div class="dropdown">
            <div class="profile-dropdown-trigger" data-bs-toggle="dropdown">
                <img src="{{Auth::check() ? Auth::user()->profile_photo_url :'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&q=80&w=100'}}"
                    alt="Admin" class="profile-avatar">
                <div class="profile-info d-none d-lg-flex">
                    <span class="profile-name">{{Auth::check() ? Auth::user()->name : 'Super Admin'}}</span>
                    <span class="profile-role">Super Admin</span>
                </div>
            </div>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-glass">
                <li><a class="dropdown-item dropdown-item-glass" href="{{route('super-admin.settings')}}"><i
                            class="bi bi-person-fill me-2"></i>My Profile</a></li>
                <li><a class="dropdown-item dropdown-item-glass" href="{{route('super-admin.settings')}}"><i
                            class="bi bi-gear-fill me-2"></i>System Settings</a></li>
                <li>
                    <hr class="dropdown-divider border-light border-opacity-10">
                </li>
                <li><a class="dropdown-item dropdown-item-glass text-danger" href="{{route('logout')}}"><i
                            class="bi bi-box-arrow-right me-2"></i>Sign Out</a></li>
            </ul>
        </div>
    </div>
</header>