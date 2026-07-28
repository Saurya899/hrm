   <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-logo">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>
                <span class="sidebar-brand-name">AuraHMS</span>
            </div>
            
            <ul class="sidebar-menu">
                <li class="menu-item {{request()->routeIs('super-admin.dashboard') ? 'active' : ''}}">
                    <a href="{{route('super-admin.dashboard')}}" class="menu-item-link">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="menu-item  {{request()->routeIs('super-admin.users') ? 'active' : ''}}">
                    <a href="{{route('super-admin.users')}}" class="menu-item-link">
                        <i class="bi bi-shield-lock-fill"></i>
                        <span>Manage Users</span>
                    </a>
                </li>
                <li class="menu-item {{request()->routeIs('super-admin.doctors') ? 'active' : ''}}">
                    <a href="{{route('super-admin.doctors')}}" class="menu-item-link">
                        <i class="bi bi-person-heart"></i>
                        <span>Doctors</span>
                    </a>
                </li>
                <li class="menu-item {{request()->routeIs('super-admin.patients') ? 'active' : ''}}">
                    <a href="{{route('super-admin.patients')}}" class="menu-item-link">
                        <i class="bi bi-people-fill"></i>
                        <span>Patients</span>
                    </a>
                </li>
                <li class="menu-item {{request()->routeIs('super-admin.appointments') ? 'active' : ''}}">
                    <a href="{{route('super-admin.appointments')}}" class="menu-item-link">
                        <i class="bi bi-calendar-event-fill"></i>
                        <span>Appointments</span>
                    </a>
                </li>
                <li class="menu-item {{request()->routeIs('super-admin.billing') ? 'active' : ''}}">
                    <a href="{{route('super-admin.billing')}}" class="menu-item-link">
                        <i class="bi bi-receipt-cutoff"></i>
                        <span>Billing & Invoice</span>
                    </a>
                </li>
                <li class="menu-item {{request()->routeIs('super-admin.laboratory') ? 'active' : ''}}">
                    <a href="{{route('super-admin.laboratory')}}" class="menu-item-link">
                        <i class="bi bi-clipboard2-pulse-fill"></i>
                        <span>Laboratory</span>
                    </a>
                </li>
                <li class="menu-item {{request()->routeIs('super-admin.reports') ? 'active' : ''}}">
                    <a href="{{route('super-admin.reports')}}" class="menu-item-link">
                        <i class="bi bi-bar-chart-line-fill"></i>
                        <span>Reports</span>
                    </a>
                </li>
                <li class="menu-item  {{request()->routeIs('super-admin.settings') ? 'active' : ''}}">
                    <a href="{{route('super-admin.settings')}}" class="menu-item-link">
                        <i class="bi bi-gear-fill"></i>
                        <span>Settings</span>
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