<!-- TOP NAVBAR -->
            <header class="top-navbar">
                <div class="navbar-left">
                    <button class="sidebar-toggle-btn" id="sidebar-toggle">
                        <i class="bi bi-justify"></i>
                    </button>
                    <div class="global-search-container d-none d-md-block">
                        <i class="bi bi-search global-search-icon"></i>
                        <input type="text" class="global-search-input"
                            placeholder="Search my scheduled slots, patients...">
                    </div>
                </div>

                <div class="navbar-right">
                    <button class="nav-icon-btn" id="theme-toggle">
                        <i class="bi bi-moon-stars-fill"></i>
                    </button>
                    <div class="dropdown">
                        <div class="profile-dropdown-trigger" data-bs-toggle="dropdown">
                            
                        @if($doctor->profile_photo)
                                    <img src="{{asset('doctors/profile/' .$doctor->profile_photo)}}" alt="Doctor"
                                        class="profile-avatar">
                                        @else
                                        <img src="https://ui-avatars.com/api/?name={{Auth::user()->name}}background=0D8ABC&color=fff" alt="patient" class="profile-avatar">
                                    @endif
                            <div class="profile-info d-none d-lg-flex">
                                <span class="profile-name">{{Auth::user()->name}}</span>
                                <span class="profile-role">{{Auth::user()->doctor->department }}</span>
                            </div>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-glass">
                            <li><a class="dropdown-item dropdown-item-glass" href="{{route('doctor.settings')}}"><i
                                        class="bi bi-person-fill me-2"></i>My Profile</a></li>
                            <li><a class="dropdown-item dropdown-item-glass" href="{{route('doctor.settings')}}"><i
                                        class="bi bi-calendar-event me-2"></i>Shift Settings</a></li>
                            <li>
                                <hr class="dropdown-divider border-light border-opacity-10">
                            </li>
                            <li><a class="dropdown-item dropdown-item-glass text-danger" href="{{route('logout')}}"><i
                                        class="bi bi-box-arrow-right me-2"></i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </header>