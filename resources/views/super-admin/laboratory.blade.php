<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraHMS - Laboratory & Pathology</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .drag-drop-zone {
            border: 2px dashed var(--border-color);
            background: rgba(255, 255, 255, 0.01);
            border-radius: 16px;
            padding: 3rem 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all var(--transition-speed);
        }

        .drag-drop-zone:hover {
            border-color: var(--primary);
            background: rgba(99, 102, 241, 0.05);
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
        @include('super-admin.sidebar')

        <!-- MAIN WRAPPER -->
        <main class="main-wrapper">

            <!-- TOP NAVBAR -->
            @include('super-admin.header')

            <!-- CONTENT BODY -->
            <div class="content-body">

                <!-- BREADCRUMB & HEADER -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <nav>
                            <ul class="breadcrumb-custom mb-1">
                                <li class="breadcrumb-item-custom"><a href="/super-admin/dashboard">Home</a></li>
                                <li class="breadcrumb-item-custom">Laboratory</li>
                            </ul>
                        </nav>
                        <h4 class="fw-bold mb-0">Laboratory & Diagnostic Centre</h4>
                    </div>
                </div>

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
                        <!-- LEFT COLUMN: LAB REPORTS LIST -->
                        <div class="col-xl-7">
                            <div class="glass-card h-100">
                                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                                    <h5 class="mb-0">Recent Diagnostic Reports</h5>
                                    <input type="text" class="form-control form-glass py-1 px-3"
                                        style="max-width: 200px;" placeholder="Filter by Patient ID...">
                                </div>

                                <div class="custom-table-container">
                                    <table class="custom-table">
                                        <thead>
                                            <tr>
                                                <th>Patient Name</th>
                                                <th>Test Category</th>
                                                <th>Lab Status</th>
                                                <th>Reference Range</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="fw-semibold">Eleanor Vance</div>
                                                    <small class="text-muted">ID: #PT-1082</small>
                                                </td>
                                                <td>Complete Blood Count (CBC)</td>
                                                <td><span class="custom-badge badge-success"><i
                                                            class="bi bi-check-circle"></i> Completed</span></td>
                                                <td><span class="text-success fw-semibold">Normal</span></td>
                                                <td class="text-end">
                                                    <button class="btn btn-premium btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#reportDetailsModal">Open Sheet</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="fw-semibold">Michael Corleone</div>
                                                    <small class="text-muted">ID: #PT-1099</small>
                                                </td>
                                                <td>Lipid Profile Diagnostics</td>
                                                <td><span class="custom-badge badge-warning"><i class="bi bi-clock"></i>
                                                        Processing</span></td>
                                                <td><span class="text-warning fw-semibold">Pending</span></td>
                                                <td class="text-end">
                                                    <button class="btn btn-premium btn-sm" disabled>Open Sheet</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT COLUMN: CONDUCT NEW TEST & UPLOAD -->
                        <div class="col-xl-5">
                            <div class="glass-card h-100">
                                <h5 class="fw-bold mb-4">Upload Laboratory Diagnostic File</h5>
                                <form
                                    onsubmit="event.preventDefault(); showToast('Report Uploaded', 'Lab diagnostic PDF file successfully synced to patient chart.', 'success');">
                                    <div class="mb-3">
                                        <label class="form-label-custom">Select Patient Profile</label>
                                        <select class="form-select form-glass" required>
                                            <option value="">Search Admitted Patient...</option>
                                            <option value="1">Eleanor Vance (#PT-1082)</option>
                                            <option value="2">Michael Corleone (#PT-1099)</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label-custom">Test Category Code</label>
                                        <select class="form-select form-glass" required>
                                            <option value="cbc">Complete Blood Count (CBC) - $120</option>
                                            <option value="lipid">Lipid Profile Diagnostics - $200</option>
                                            <option value="mri">Brain MRI Contrast Scan - $850</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label-custom">Select Diagnostic Report PDF</label>
                                        <div class="drag-drop-zone" id="file-dropzone">
                                            <i class="bi bi-file-earmark-arrow-up text-primary"
                                                style="font-size: 2.5rem;"></i>
                                            <h6 class="fw-semibold mt-2">Drag Diagnostic PDF here</h6>
                                            <p class="text-muted small mb-0">Max allowed file size 5MB. Standard reports
                                                only.</p>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-premium w-100">Link File & Notify
                                        Doctor</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </main>
    </div>

    <!-- MODAL: LAB REPORT DETAILS PREVIEW -->
    <div class="modal fade modal-glass" id="reportDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header border-light border-opacity-10">
                    <h5 class="modal-title fw-bold">Diagnostic Pathology Sheet - #PT-1082</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="p-3 mb-4 rounded-4 border border-light border-opacity-10"
                        style="background: rgba(255, 255, 255, 0.02);">
                        <div class="row text-white text-opacity-80">
                            <div class="col-6 mb-2">Patient: <span class="fw-bold text-white">Eleanor Vance</span></div>
                            <div class="col-6 mb-2">Age / Gender: <span class="fw-bold text-white">28 / Female</span>
                            </div>
                            <div class="col-6">Test Code: <span class="fw-bold text-white">CBC-0928</span></div>
                            <div class="col-6">Ref Physician: <span class="fw-bold text-white">Dr. Sarah Connor</span>
                            </div>
                        </div>
                    </div>

                    <h6 class="fw-bold text-primary mb-3">Pathology Parameters Results</h6>
                    <div class="table-responsive">
                        <table class="table table-borderless text-white">
                            <thead>
                                <tr class="border-bottom border-light border-opacity-10">
                                    <th class="text-muted">Parameter</th>
                                    <th class="text-center text-muted">Value</th>
                                    <th class="text-center text-muted">Ref Intervals</th>
                                    <th class="text-end text-muted">Evaluation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Hemoglobin (Hb)</td>
                                    <td class="text-center fw-bold">13.5 g/dL</td>
                                    <td class="text-center text-muted">12.0 - 15.5 g/dL</td>
                                    <td class="text-end"><span class="custom-badge badge-success">Normal</span></td>
                                </tr>
                                <tr>
                                    <td>White Blood Cells (WBC)</td>
                                    <td class="text-center fw-bold text-warning">11.2 x10^3</td>
                                    <td class="text-center text-muted">4.5 - 11.0 x10^3</td>
                                    <td class="text-end"><span class="custom-badge badge-warning">Borderline High</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Platelet Count</td>
                                    <td class="text-center fw-bold">250 x10^3</td>
                                    <td class="text-center text-muted">150 - 450 x10^3</td>
                                    <td class="text-end"><span class="custom-badge badge-success">Normal</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer border-light border-opacity-10">
                    <button class="btn btn-premium-outline me-2"
                        onclick="showToast('Print Document', 'Compiling print buffer.', 'success')"><i
                            class="bi bi-printer"></i> Print PDF</button>
                    <button class="btn btn-premium" data-bs-dismiss="modal">Close Diagnostic Sheet</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Main JS -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        document.getElementById('file-dropzone').addEventListener('click', () => {
            showToast('Document Upload', 'Select pathology report PDF files.', 'info');
        });
    </script>
</body>

</html>