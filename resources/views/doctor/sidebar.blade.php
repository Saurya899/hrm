<!-- SIDEBAR -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-logo">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>
                <span class="sidebar-brand-name">AuraHMS</span>
            </div>

            <ul class="sidebar-menu">
                <li class="menu-item {{request()->routeIs('doctor.dashboard') ? 'active' : ''}}">
                    <a href="{{route('doctor.dashboard')}}" class="menu-item-link">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>My Dashboard</span>
                    </a>
                </li>
                <li class="menu-item {{request()->routeIs('doctor.appointments') ? 'active' : ''}}">
                    <a href="{{route('doctor.appoinments')}}" class="menu-item-link">
                        <i class="bi bi-calendar2-check-fill"></i>
                        <span>My Appointments</span>
                    </a>
                </li>
                <li class="menu-item {{request()->routeIs('doctor.patients') ? 'active' : ''}}">
                    <a href="{{route('doctor.patients')}}" class="menu-item-link">
                        <i class="bi bi-people-fill"></i>
                        <span>My Patients</span>
                    </a>
                </li>
                <li class="menu-item {{request()->routeIs('doctor.settings') ? 'active' : ''}}">
                    <a href="{{route('doctor.settings')}}" class="menu-item-link">
                        <i class="bi bi-clock-fill"></i>
                        <span>My Schedule Shift</span>
                    </a>
                </li>

                <li class="menu-item mt-auto">
                    <a href="{{route('logout')}}" class="menu-item-link text-danger">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </aside>