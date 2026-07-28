<div class="navbar-right">
    <button class="nav-icon-btn" id="theme-toggle">
        <i class="bi bi-moon-stars-fill"></i>
    </button>
    <div class="dropdown">
        <div class="profile-dropdown-trigger" data-bs-toggle="dropdown">
            @if(Auth::user()->patient->profile)
            <img src="{{asset('uploads/profile/' . Auth::user()->patient->profile)}}" alt="Patient"
                class="profile-avatar">
                 @else
                 <img src="https://ui-avatars.com/api/?name={{Auth::user()->name}}background=0D8ABC&color=fff" alt="patient" class="profile-avatar">
            @endif
            <div class="profile-info d-none d-lg-flex">
                <span class="profile-name">{{Auth::user()->name}}</span>
                <span class="profile-role">ID: #PT-{{Auth::user()->id}}</span>
            </div>
        </div>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-glass">
            <li><a class="dropdown-item dropdown-item-glass" href="{{route('patient.settings')}}"><i
                        class="bi bi-person-badge me-2"></i>My Profile</a></li>
            <li><a class="dropdown-item dropdown-item-glass" href="{{route('patient.settings')}}"><i
                        class="bi bi-shield-lock me-2"></i>Security Settings</a></li>
            <li>
                <hr class="dropdown-divider border-light border-opacity-10">
            </li>
            <li><a class="dropdown-item dropdown-item-glass text-danger" href="{{route('logout')}}"><i
                        class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
        </ul>
    </div>
</div>