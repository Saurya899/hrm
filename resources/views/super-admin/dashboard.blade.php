<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraHMS - Super Admin Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- ApexCharts CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <!-- Page Loader -->
    <div class="page-loader" id="page-loader">
        <div class="loader-spinner"></div>
    </div>

    <!-- Toast Notifications Container -->
    <div class="toast-container-custom" id="toast-container"></div>

    <div class="app-container">

        <!-- SIDEBAR -->
        @include('super-admin.sidebar')

        <!-- MAIN WRAPPER -->
        <main class="main-wrapper">

            <!-- TOP NAVBAR -->
            @include('super-admin.header')
            <!-- CONTENT BODY -->
            <div class="content-body">

                <!-- BREADCRUMB -->
                <nav>
                    <ul class="breadcrumb-custom">
                        <li class="breadcrumb-item-custom"><a href="#">Home</a></li>
                        <li class="breadcrumb-item-custom">Dashboard</li>
                    </ul>
                </nav>

                <!-- SKELETON LOADER PLACEHOLDER -->
                <div class="skeleton-wrapper row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="glass-card skeleton" style="height: 120px;"></div>
                    </div>
                    <div class="col-md-3">
                        <div class="glass-card skeleton" style="height: 120px;"></div>
                    </div>
                    <div class="col-md-3">
                        <div class="glass-card skeleton" style="height: 120px;"></div>
                    </div>
                    <div class="col-md-3">
                        <div class="glass-card skeleton" style="height: 120px;"></div>
                    </div>
                </div>

                <!-- REAL CONTENT WRAPPER -->
                <div class="real-content-wrapper d-none">

                    <!-- STATISTICS CARDS -->
                    <div class="row g-4 mb-4">
                        <!-- Today's Appointments -->
                        <div class="col-xl-3 col-md-6">
                            <div class="glass-card glass-card-hover stat-card">
                                <span class="text-muted fw-semibold" style="font-size: 0.85rem;">TODAY'S
                                    APPOINTMENTS</span>
                                <h3 class="fw-bold mt-2 mb-1">42</h3>
                                <div class="stat-card-trend bg-success-bg text-success mt-1">
                                    <i class="bi bi-arrow-up-right-circle-fill"></i> +12% vs yesterday
                                </div>
                                <div class="stat-card-icon text-primary"><i class="bi bi-calendar2-check"></i></div>
                            </div>
                        </div>

                        <!-- Today's Revenue -->
                        <div class="col-xl-3 col-md-6">
                            <div class="glass-card glass-card-hover stat-card">
                                <span class="text-muted fw-semibold" style="font-size: 0.85rem;">TODAY'S REVENUE</span>
                                <h3 class="fw-bold mt-2 mb-1">$4,850</h3>
                                <div class="stat-card-trend bg-success-bg text-success mt-1">
                                    <i class="bi bi-arrow-up-right-circle-fill"></i> +8.4%
                                </div>
                                <div class="stat-card-icon text-success"><i class="bi bi-currency-dollar"></i></div>
                            </div>
                        </div>

                        <!-- Available Beds -->
                        <div class="col-xl-3 col-md-6">
                            <div class="glass-card glass-card-hover stat-card">
                                <span class="text-muted fw-semibold" style="font-size: 0.85rem;">AVAILABLE BEDS</span>
                                <h3 class="fw-bold mt-2 mb-1">28 <span class="text-muted" style="font-size: 1rem;">/
                                        150</span></h3>
                                <div class="stat-card-trend bg-danger-bg text-danger mt-1">
                                    <i class="bi bi-arrow-down-right-circle-fill"></i> Occupancy 81%
                                </div>
                                <div class="stat-card-icon text-warning"><i class="bi bi-hospital"></i></div>
                            </div>
                        </div>

                        <!-- Emergency Patients -->
                        <div class="col-xl-3 col-md-6">
                            <div class="glass-card glass-card-hover stat-card">
                                <span class="text-muted fw-semibold" style="font-size: 0.85rem;">EMERGENCY
                                    ADMISSIONS</span>
                                <h3 class="fw-bold mt-2 mb-1 text-danger">7</h3>
                                <div class="stat-card-trend bg-warning-bg text-warning mt-1">
                                    <i class="bi bi-activity"></i> Active ER operations
                                </div>
                                <div class="stat-card-icon text-danger"><i class="bi bi-radioactive"></i></div>
                            </div>
                        </div>
                    </div>

                    <!-- REVENUE & APPOINTMENTS GRAPHICS -->
                    <div class="row g-4 mb-4">
                        <div class="col-lg-8">
                            <div class="glass-card h-100">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div>
                                        <h5 class="mb-1">Revenue Analytics & Trend</h5>
                                        <p class="text-muted mb-0" style="font-size: 0.8rem;">Compare OPD consults vs
                                            Lab tests & Diagnostics.</p>
                                    </div>
                                    <select class="form-select form-glass w-auto py-1 px-3">
                                        <option>Monthly</option>
                                        <option>Weekly</option>
                                        <option>Daily</option>
                                    </select>
                                </div>
                                <div id="revenue-chart"></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="glass-card h-100">
                                <h5 class="mb-4">Gender Distribution</h5>
                                <div id="gender-distribution-chart"></div>
                                <div
                                    class="d-flex justify-content-around mt-4 pt-3 border-top border-light border-opacity-10">
                                    <div class="text-center">
                                        <div class="text-muted" style="font-size: 0.8rem;"><i
                                                class="bi bi-circle-fill text-primary me-1"></i> Male</div>
                                        <div class="fw-bold">48%</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-muted" style="font-size: 0.8rem;"><i
                                                class="bi bi-circle-fill text-info me-1"></i> Female</div>
                                        <div class="fw-bold">45%</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-muted" style="font-size: 0.8rem;"><i
                                                class="bi bi-circle-fill text-warning me-1"></i> Other</div>
                                        <div class="fw-bold">7%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TABLES & SCHEDULE DETAILS -->
                    <div class="row g-4 mb-4">
                        <!-- Recent Appointments Table -->
                        <div class="col-xl-8">
                            <div class="glass-card h-100">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5>Recent Patient Appointments</h5>
                                    <a href="/super-admin/appointments"
                                        class="btn btn-premium-outline btn-sm px-3 py-1">View All</a>
                                </div>
                                <div class="custom-table-container">
                                    <table class="custom-table">
                                        <thead>
                                            <tr>
                                                <th>Patient Name</th>
                                                <th>Doctor</th>
                                                <th>Department</th>
                                                <th>Appointment Time</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=60"
                                                            alt="Patient" class="rounded-circle"
                                                            style="width: 32px; height: 32px; object-fit: cover;">
                                                        <div class="fw-semibold">Eleanor Vance</div>
                                                    </div>
                                                </td>
                                                <td>Dr. Sarah Connor</td>
                                                <td>Cardiology</td>
                                                <td>09:30 AM</td>
                                                <td><span class="custom-badge badge-success"><i
                                                            class="bi bi-check-circle"></i> Completed</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=60"
                                                            alt="Patient" class="rounded-circle"
                                                            style="width: 32px; height: 32px; object-fit: cover;">
                                                        <div class="fw-semibold">Michael Corleone</div>
                                                    </div>
                                                </td>
                                                <td>Dr. John Carter</td>
                                                <td>Pediatrics</td>
                                                <td>10:45 AM</td>
                                                <td><span class="custom-badge badge-warning"><i class="bi bi-clock"></i>
                                                        Pending</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&q=80&w=60"
                                                            alt="Patient" class="rounded-circle"
                                                            style="width: 32px; height: 32px; object-fit: cover;">
                                                        <div class="fw-semibold">Jane Foster</div>
                                                    </div>
                                                </td>
                                                <td>Dr. Gregory House</td>
                                                <td>Neurology</td>
                                                <td>11:15 AM</td>
                                                <td><span class="custom-badge badge-danger"><i
                                                            class="bi bi-x-circle"></i> Cancelled</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Doctor Availability -->
                        <div class="col-xl-4">
                            <div class="glass-card h-100">
                                <h5 class="mb-4">Doctor Availability</h5>
                                <div class="d-flex flex-column gap-3">
                                    <!-- Dr. Gregory House -->
                                    <div
                                        class="p-3 rounded-4 border border-light border-opacity-10 d-flex justify-content-between align-items-center glass-sub-card">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&q=80&w=100"
                                                alt="Doctor" class="rounded-circle"
                                                style="width: 40px; height: 40px; object-fit: cover;">
                                            <div>
                                                <div class="fw-semibold" style="font-size: 0.9rem;">Dr. Gregory House
                                                </div>
                                                <small class="text-muted">Neurology department</small>
                                            </div>
                                        </div>
                                        <span class="custom-badge badge-success">On Duty</span>
                                    </div>
                                    <!-- Dr. Sarah Connor -->
                                    <div
                                        class="p-3 rounded-4 border border-light border-opacity-10 d-flex justify-content-between align-items-center glass-sub-card">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="https://images.unsplash.com/photo-1594824813573-246434de83fb?auto=format&fit=crop&q=80&w=100"
                                                alt="Doctor" class="rounded-circle"
                                                style="width: 40px; height: 40px; object-fit: cover;">
                                            <div>
                                                <div class="fw-semibold" style="font-size: 0.9rem;">Dr. Sarah Connor
                                                </div>
                                                <small class="text-muted">Cardiology department</small>
                                            </div>
                                        </div>
                                        <span class="custom-badge badge-danger">Out of Duty</span>
                                    </div>
                                    <!-- Dr. John Carter -->
                                    <div
                                        class="p-3 rounded-4 border border-light border-opacity-10 d-flex justify-content-between align-items-center glass-sub-card">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&q=80&w=100"
                                                alt="Doctor" class="rounded-circle"
                                                style="width: 40px; height: 40px; object-fit: cover;">
                                            <div>
                                                <div class="fw-semibold" style="font-size: 0.9rem;">Dr. John Carter
                                                </div>
                                                <small class="text-muted">Pediatrics department</small>
                                            </div>
                                        </div>
                                        <span class="custom-badge badge-warning">Emergency</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TIMELINE, ACTIVITY, PERFORMANCE -->
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <div class="glass-card h-100">
                                <h5 class="mb-4">Activity Timeline</h5>
                                <div class="timeline-custom">
                                    <div class="timeline-item success">
                                        <div class="fw-semibold" style="font-size: 0.85rem;">Billing Invoice Generated
                                        </div>
                                        <small class="text-muted d-block mb-1">Dr. Alex logged billing of
                                            $1,450.00</small>
                                        <span style="font-size: 0.75rem; color: var(--text-muted);">10 mins ago</span>
                                    </div>
                                    <div class="timeline-item warning">
                                        <div class="fw-semibold" style="font-size: 0.85rem;">Critical Level Medicine
                                            Stock</div>
                                        <small class="text-muted d-block mb-1">Pharmacy: Ibuprofen quantities under 20
                                            boxes</small>
                                        <span style="font-size: 0.75rem; color: var(--text-muted);">1 hour ago</span>
                                    </div>
                                    <div class="timeline-item info">
                                        <div class="fw-semibold" style="font-size: 0.85rem;">Laboratory Pathology Sync
                                        </div>
                                        <small class="text-muted d-block mb-1">Blood test diagnostic report uploaded for
                                            Jane Doe</small>
                                        <span style="font-size: 0.75rem; color: var(--text-muted);">3 hours ago</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="glass-card h-100">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5>OPD Patient Queue & Performance</h5>
                                    <button class="btn btn-premium btn-sm"
                                        onclick="showToast('Queue Refreshed', 'Dynamic OPD dashboard statistics synchronized.', 'success')">
                                        <i class="bi bi-arrow-clockwise"></i> Refresh Queue
                                    </button>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6 col-xl-3">
                                        <div class="p-3 rounded-4 border border-light border-opacity-10 text-center"
                                            style="background: rgba(255, 255, 255, 0.02)">
                                            <div class="text-muted mb-1" style="font-size: 0.8rem;">Average Wait Time
                                            </div>
                                            <h4 class="fw-bold mb-0 text-info">18 Mins</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-3">
                                        <div class="p-3 rounded-4 border border-light border-opacity-10 text-center"
                                            style="background: rgba(255, 255, 255, 0.02)">
                                            <div class="text-muted mb-1" style="font-size: 0.8rem;">Discharge Rate</div>
                                            <h4 class="fw-bold mb-0 text-success">94.2%</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-3">
                                        <div class="p-3 rounded-4 border border-light border-opacity-10 text-center"
                                            style="background: rgba(255, 255, 255, 0.02)">
                                            <div class="text-muted mb-1" style="font-size: 0.8rem;">Bed Turnover Rate
                                            </div>
                                            <h4 class="fw-bold mb-0 text-warning">2.4 Days</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-3">
                                        <div class="p-3 rounded-4 border border-light border-opacity-10 text-center"
                                            style="background: rgba(255, 255, 255, 0.02)">
                                            <div class="text-muted mb-1" style="font-size: 0.8rem;">ICU Beds Free</div>
                                            <h4 class="fw-bold mb-0 text-danger">3 / 12</h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 p-4 rounded-4 border border-light border-opacity-10"
                                    style="background: linear-gradient(135deg, rgba(99,102,241,0.05) 0%, rgba(6,182,212,0.05) 100%);">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="fw-bold mb-1">Administrative Action Required</h6>
                                            <p class="text-muted mb-0" style="font-size: 0.8rem;">The annual
                                                pharmaceutical inventory check is due in 3 days.</p>
                                        </div>
                                        <button class="btn btn-premium btn-sm px-4"
                                            onclick="window.location.href='settings.html'">Configure Backups</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </main>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- ApexCharts JS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- Custom Main JS -->
    <script src="{{ asset('js/script.js') }}"></script>

    <!-- Dashboard ApexCharts config -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                var optionsRevenue = {
                    series: [{
                        name: 'OPD Consultations',
                        data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
                    }, {
                        name: 'Diagnostics & Labs',
                        data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
                    }],
                    chart: {
                        type: 'bar',
                        height: 300,
                        toolbar: { show: false },
                        background: 'transparent'
                    },
                    colors: ['#6366f1', '#06b6d4'],
                    theme: {
                        mode: document.documentElement.getAttribute('data-theme') || 'dark'
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded',
                            borderRadius: 4
                        },
                    },
                    dataLabels: { enabled: false },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                        labels: { style: { colors: '#94a3b8' } }
                    },
                    yaxis: {
                        title: { text: '$ (thousands)', style: { color: '#94a3b8' } },
                        labels: { style: { colors: '#94a3b8' } }
                    },
                    fill: { opacity: 1 },
                    legend: {
                        labels: { colors: '#94a3b8' }
                    },
                    grid: {
                        borderColor: 'rgba(255, 255, 255, 0.05)'
                    }
                };

                var chartRevenue = new ApexCharts(document.querySelector("#revenue-chart"), optionsRevenue);
                chartRevenue.render();

                var optionsGender = {
                    series: [48, 45, 7],
                    chart: {
                        type: 'donut',
                        height: 250,
                        background: 'transparent'
                    },
                    colors: ['#6366f1', '#06b6d4', '#f59e0b'],
                    labels: ['Male', 'Female', 'Other'],
                    theme: {
                        mode: document.documentElement.getAttribute('data-theme') || 'dark'
                    },
                    legend: { show: false },
                    dataLabels: { enabled: false },
                    stroke: { colors: ['transparent'] },
                    grid: {
                        padding: { top: 0, bottom: 0 }
                    }
                };

                var chartGender = new ApexCharts(document.querySelector("#gender-distribution-chart"), optionsGender);
                chartGender.render();

                const themeToggle = document.getElementById('theme-toggle');
                if (themeToggle) {
                    themeToggle.addEventListener('click', () => {
                        setTimeout(() => {
                            const newTheme = document.documentElement.getAttribute('data-theme');
                            chartRevenue.updateOptions({
                                theme: { mode: newTheme }
                            });
                            chartGender.updateOptions({
                                theme: { mode: newTheme }
                            });
                        }, 50);
                    });
                }
            }, 1200);
        });
    </script>
</body>

</html>