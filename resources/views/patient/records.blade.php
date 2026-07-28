<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraHMS - Patient Medical Records</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
        @include('patient.sidebar')

        <!-- MAIN WRAPPER -->
        <main class="main-wrapper">

            <!-- TOP NAVBAR -->
            <header class="top-navbar">
                <div class="navbar-left">
                    <button class="sidebar-toggle-btn" id="sidebar-toggle">
                        <i class="bi bi-justify"></i>
                    </button>
                    <span class="navbar-brand-name ms-2 d-none d-md-inline-block text-primary fw-bold">My Medical
                        Records</span>
                </div>

                @include('patient.header')

            </header>

            <!-- CONTENT BODY -->
            <div class="content-body">

                <!-- BREADCRUMB -->
                <nav>
                    <ul class="breadcrumb-custom">
                        <li class="breadcrumb-item-custom"><a href="/patient/dashboard">Home</a></li>
                        <li class="breadcrumb-item-custom">Medical Records</li>
                    </ul>
                </nav>

                <!-- SKELETON LOADER -->
                <div class="skeleton-wrapper row g-4 mb-4">
                    <div class="col-md-7">
                        <div class="glass-card skeleton" style="height: 450px;"></div>
                    </div>
                    <div class="col-md-5">
                        <div class="glass-card skeleton" style="height: 450px;"></div>
                    </div>
                </div>

                <!-- REAL CONTENT WRAPPER -->
                <div class="real-content-wrapper d-none">

                    <div class="row g-4">
                        <!-- LEFT PANEL: MY MEDICAL FILE & TIMELINE -->
                        <div class="col-xl-7">
                            <div class="glass-card h-100">
                                <h5 class="fw-bold mb-4">Clinical Case File & Timeline</h5>
                                <div class="timeline-custom">
                                    <div class="timeline-item success">
                                        <div class="fw-semibold">Hematology Diagnostics Report</div>
                                        <small class="text-muted">Chief Analyst: Dr. Sarah Connor</small>
                                        <p class="text-muted small">Complete Blood Count (CBC) analysis completed.
                                            Platelet indexes and white blood cell metrics returned standard. Reference
                                            values: Normal.</p>
                                        <span style="font-size: 0.75rem; color: var(--text-muted);">2026-06-28</span>
                                    </div>
                                    <div class="timeline-item info">
                                        <div class="fw-semibold">OPD Cardiology Consultation</div>
                                        <small class="text-muted">Clinical Specialist: Dr. Sarah Connor</small>
                                        <p class="text-muted small">Patient presented with tachycardia symptoms. Cardiac
                                            EKG rhythm trace performed; no abnormalities discovered. Diagnosed with mild
                                            stress palpitations. Prescribed Ivabradine daily.</p>
                                        <span style="font-size: 0.75rem; color: var(--text-muted);">2026-06-25</span>
                                    </div>
                                    <div class="timeline-item warning">
                                        <div class="fw-semibold">Allergy Warning Logged</div>
                                        <small class="text-muted">HMS Auto-System Update</small>
                                        <p class="text-muted small">Patient has an active allergic reaction counter to:
                                            **Penicillin Group Compounds**.</p>
                                        <span style="font-size: 0.75rem; color: var(--text-muted);">2026-06-20</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT PANEL: ACTIVE PRESCRIPTIONS & DOWNLOADABLE REPORTS -->
                        <div class="col-xl-5">
                            <!-- PRESCRIPTIONS LOG -->
                            <div class="glass-card mb-4">
                                <h5 class="fw-bold mb-3">My Current Prescriptions</h5>
                                <div class="d-flex flex-column gap-3">
                                    <div class="p-3 border border-light border-opacity-10 rounded-4 glass-sub-card">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h6 class="fw-bold mb-1">Ivabradine 5mg</h6>
                                                <small class="text-muted">Dosage: 1 Tab (Morning/Night)</small>
                                            </div>
                                            <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                                        </div>
                                    </div>
                                    <div class="p-3 border border-light border-opacity-10 rounded-4 glass-sub-card">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h6 class="fw-bold mb-1">Pantoprazole 40mg</h6>
                                                <small class="text-muted">Dosage: 1 Tab (Morning Empty Stomach)</small>
                                            </div>
                                            <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- MOCK DOCUMENTS -->
                            <div class="glass-card">
                                <h5 class="fw-bold mb-3">My Lab Test Documents</h5>
                                <div class="d-flex flex-column gap-2">
                                    <div
                                        class="p-2 border border-light border-opacity-10 rounded-3 d-flex justify-content-between align-items-center glass-sub-card">
                                        <span style="font-size: 0.85rem;"><i
                                                class="bi bi-file-earmark-pdf-fill text-danger me-2"></i>Blood_Count_Report.pdf</span>
                                        <button class="btn btn-sm text-info p-0"
                                            onclick="showToast('Downloading', 'Blood_Count_Report.pdf downloaded.', 'success')"><i
                                                class="bi bi-download"></i></button>
                                    </div>
                                    <div
                                        class="p-2 border border-light border-opacity-10 rounded-3 d-flex justify-content-between align-items-center glass-sub-card">
                                        <span style="font-size: 0.85rem;"><i
                                                class="bi bi-file-earmark-pdf-fill text-danger me-2"></i>Chest_XRay_Scan.pdf</span>
                                        <button class="btn btn-sm text-info p-0"
                                            onclick="showToast('Downloading', 'Chest_XRay_Scan.pdf downloaded.', 'success')"><i
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