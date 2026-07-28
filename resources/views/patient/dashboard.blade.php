<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraHMS - Patient Portal Panel</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .patient-badge {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.15) 0%, rgba(99, 102, 241, 0.15) 100%);
            border: 1px solid var(--border-color);
        }
    </style>
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
        @include('patient.sidebar')
        <!-- MAIN WRAPPER -->
        <main class="main-wrapper">

            <!-- TOP NAVBAR -->
            <header class="top-navbar">
                <div class="navbar-left">
                    <button class="sidebar-toggle-btn" id="sidebar-toggle">
                        <i class="bi bi-justify"></i>
                    </button>
                    <span class="navbar-brand-name ms-2 d-none d-md-inline-block text-primary fw-bold">Patient
                        Dashboard</span>
                </div>

                @include('patient.header')
            </header>

            <!-- CONTENT BODY -->
            <div class="content-body">

                <!-- BREADCRUMB -->
                <nav>
                    <ul class="breadcrumb-custom">
                        <li class="breadcrumb-item-custom"><a href="#">Home</a></li>
                        <li class="breadcrumb-item-custom">Patient Portal</li>
                    </ul>
                </nav>

                <!-- SKELETON LOADER -->
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

                    <!-- PATIENT SUMMARY INFO -->
                    <div class="row g-4 mb-4">
                        <div class="col-xl-3 col-md-6">
                            <div class="glass-card patient-badge">
                                <span class="text-muted fw-semibold small">NEXT CLINIC APPOINTMENT</span>
                                <h5 class="fw-bold mt-2 mb-1 text-primary">Dr. Sarah Connor</h5>
                                <div class="small text-white text-opacity-80"><i class="bi bi-calendar3"></i> Tomorrow,
                                    09:30 AM</div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="glass-card patient-badge">
                                <span class="text-muted fw-semibold small">PENDING PAYMENTS</span>
                                <h5 class="fw-bold mt-2 mb-1 text-warning">$0.00</h5>
                                <div class="small text-success"><i class="bi bi-check-circle-fill"></i> No outstanding
                                    invoices</div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="glass-card patient-badge">
                                <span class="text-muted fw-semibold small">LAB DIAGNOSTICS</span>
                                <h5 class="fw-bold mt-2 mb-1 text-success">1 Ready</h5>
                                <div class="small text-white text-opacity-80"><i class="bi bi-file-earmark-check"></i>
                                    Blood CBC Report available</div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="glass-card patient-badge">
                                <span class="text-muted fw-semibold small">ACTIVE PRESCRIPTIONS</span>
                                <h5 class="fw-bold mt-2 mb-1 text-info">2 Prescriptions</h5>
                                <div class="small text-white text-opacity-80"><i class="bi bi-prescription"></i> Updated
                                    2 days ago</div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <!-- LEFT PANEL: MY MEDICAL FILE & TIMELINE -->
                        <div class="col-lg-8">
                            <!-- UPCOMING SHIFT & BOOKING LINK -->
                            <div class="glass-card mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="fw-bold mb-0">Active Treatment Timeline</h5>
                                    <button class="btn btn-premium btn-sm"
                                        onclick="showToast('Appointment Scheduler', 'Redirecting to booking calendar.', 'info')">
                                        <i class="bi bi-calendar-plus"></i> Request Appointment
                                    </button>
                                </div>
                                <div class="timeline-custom pt-2">
                                    <div class="timeline-item success">
                                        <div class="fw-semibold">CBC Blood Count Result Published</div>
                                        <small class="text-muted">Diagnostics Centre • Evaluated: Normal</small>
                                        <span class="d-block small text-white text-opacity-70 mt-1">Platelet counts and
                                            Hb levels normal. PDF ready for download.</span>
                                        <span style="font-size: 0.75rem; color: var(--text-muted);">2026-06-28</span>
                                    </div>
                                    <div class="timeline-item info">
                                        <div class="fw-semibold">Cardiology Consultation & EKG Screening</div>
                                        <small class="text-muted">Assigned Physician: Dr. Sarah Connor</small>
                                        <span class="d-block small text-white text-opacity-70 mt-1">EKG testing
                                            completed. Advice: Rest and daily Ivabradine medication intake.</span>
                                        <span style="font-size: 0.75rem; color: var(--text-muted);">2026-06-25</span>
                                    </div>
                                </div>
                            </div>

                            <!-- ACTIVE PRESCRIPTIONS TABLE -->
                            <div class="glass-card">
                                <h5 class="fw-bold mb-4">Active Pharmaceutical Prescriptions</h5>
                                <div class="custom-table-container">
                                    <table class="custom-table">
                                        <thead>
                                            <tr>
                                                <th>Medicine Name</th>
                                                <th>Dosage / Routine</th>
                                                <th>Duration</th>
                                                <th>Prescribing Doctor</th>
                                                <th class="text-end">Print Layout</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><span class="fw-bold">Ivabradine 5mg</span></td>
                                                <td>1 tab - Morning / Night (Post Meal)</td>
                                                <td>30 Days</td>
                                                <td>Dr. Sarah Connor</td>
                                                <td class="text-end">
                                                    <button class="btn btn-premium-outline btn-sm"
                                                        onclick="showToast('Print Prescription', 'Preparing clinical slip.', 'success')"><i
                                                            class="bi bi-printer"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="fw-bold">Pantoprazole 40mg</span></td>
                                                <td>1 tab - Morning (Empty Stomach)</td>
                                                <td>15 Days</td>
                                                <td>Dr. Sarah Connor</td>
                                                <td class="text-end">
                                                    <button class="btn btn-premium-outline btn-sm"
                                                        onclick="showToast('Print Prescription', 'Preparing clinical slip.', 'success')"><i
                                                            class="bi bi-printer"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT PANEL: LAB DOCUMENTS & STATS -->
                        <div class="col-lg-4">
                            <div class="glass-card mb-4">
                                <h5 class="fw-bold mb-3">Health Metrics Log</h5>
                                <div class="p-3 border border-light border-opacity-10 rounded-4 glass-sub-card mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="text-muted small">Blood Group</div>
                                            <h4 class="fw-bold text-success mt-1 mb-0">
                                                {{Auth::user()->patient->blood_group}}
                                            </h4>
                                        </div>
                                        <i class="bi bi-activity text-success" style="font-size: 2rem;"></i>
                                    </div>
                                </div>
                                <div class="p-3 border border-light border-opacity-10 rounded-4 glass-sub-card mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="text-muted small">Age</div>
                                            <h4 class="fw-bold text-info mt-1 mb-0">{{Auth::user()->patient->age}}</h4>
                                        </div>
                                        <i class="bi bi-heart-fill text-info" style="font-size: 2rem;"></i>
                                    </div>
                                </div>
                                <div class="p-3 border border-light border-opacity-10 rounded-4 glass-sub-card">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="text-muted small">Disease</div>
                                            <h4 class="fw-bold text-warning mt-1 mb-0">
                                                {{Auth::user()->patient->disease}}</h4>
                                        </div>
                                        <i class="bi bi-droplet-fill text-warning" style="font-size: 2rem;"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="glass-card">
                                <h5 class="fw-bold mb-3">My Diagnostic Documents</h5>
                                <div class="d-flex flex-column gap-2">
                                    <div
                                        class="p-3 border border-light border-opacity-10 rounded-4 glass-sub-card d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="fw-semibold d-block small">Blood_Count_Report.pdf</span>
                                            <span class="text-muted" style="font-size: 0.75rem;">Pathology Lab • 1.2
                                                MB</span>
                                        </div>
                                        <button class="btn btn-premium btn-sm"
                                            onclick="showToast('Downloading Report', 'Opening file stream.', 'success')"><i
                                                class="bi bi-download"></i></button>
                                    </div>
                                    <div
                                        class="p-3 border border-light border-opacity-10 rounded-4 glass-sub-card d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="fw-semibold d-block small">Chest_XRay_Scan.pdf</span>
                                            <span class="text-muted" style="font-size: 0.75rem;">Radiology scan • 3.5
                                                MB</span>
                                        </div>
                                        <button class="btn btn-premium btn-sm"
                                            onclick="showToast('Downloading Report', 'Opening file stream.', 'success')"><i
                                                class="bi bi-download"></i></button>
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
    <!-- Custom Main JS -->
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>