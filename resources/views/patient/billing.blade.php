<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraHMS - Patient Bills & Payments</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .invoice-preview-sheet {
            background: #fff;
            color: #0f172a;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(0, 0, 0, 0.05);
            font-size: 0.9rem;
        }

        [data-theme="dark"] .invoice-preview-sheet {
            background: #ffffff;
            color: #0f172a;
        }

        .invoice-preview-sheet th {
            color: #475569 !important;
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            background: none !important;
        }

        .invoice-preview-sheet td {
            color: #334155 !important;
            border-bottom: 1px solid #f1f5f9;
        }

        .invoice-preview-sheet .text-muted {
            color: #64748b !important;
        }

        .invoice-preview-sheet .divider-line {
            height: 1px;
            background-color: #e2e8f0;
            margin: 1.5rem 0;
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
                    <span class="navbar-brand-name ms-2 d-none d-md-inline-block text-primary fw-bold">Bills &
                        Payments</span>
                </div>

                @include('patient.header')
            </header>

            <!-- CONTENT BODY -->
            <div class="content-body">

                <!-- BREADCRUMB -->
                <nav>
                    <ul class="breadcrumb-custom">
                        <li class="breadcrumb-item-custom"><a href="/patient/dashboard">Home</a></li>
                        <li class="breadcrumb-item-custom">Bills & Payments</li>
                    </ul>
                </nav>

                <!-- SKELETON LOADER -->
                <div class="skeleton-wrapper row g-4 mb-4">
                    <div class="col-md-5">
                        <div class="glass-card skeleton" style="height: 350px;"></div>
                    </div>
                    <div class="col-md-7">
                        <div class="glass-card skeleton" style="height: 500px;"></div>
                    </div>
                </div>

                <!-- REAL CONTENT WRAPPER -->
                <div class="real-content-wrapper d-none">

                    <div class="row g-4">
                        <!-- LEFT PANEL: MY INVOICES LOG -->
                        <div class="col-xl-5">
                            <div class="glass-card h-100">
                                <h5 class="fw-bold mb-4">My Invoice Ledger</h5>
                                <div class="d-flex flex-column gap-2">
                                    <div
                                        class="p-3 border border-light border-opacity-10 rounded-4 glass-sub-card d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="fw-bold d-block">#AURA-10283</span>
                                            <small class="text-muted">OPD + Pathology Screenings</small>
                                            <small class="text-muted d-block mt-1">Issued: 2026-06-28</small>
                                        </div>
                                        <div class="text-end">
                                            <span class="fw-bold d-block">$1,450.00</span>
                                            <span class="custom-badge badge-success mt-1">Paid</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT PANEL: PROFESSIONAL LIVE PREVIEW -->
                        <div class="col-xl-7">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0">Active Invoice Statement</h6>
                                <button class="btn btn-premium btn-sm" onclick="window.print()"><i
                                        class="bi bi-printer"></i> Print Statement</button>
                            </div>

                            <!-- PRINTABLE INVOICE SHEET -->
                            <div class="invoice-preview-sheet">
                                <div class="d-flex justify-content-between align-items-start mb-4">
                                    <div>
                                        <h4 class="fw-bold mb-1" style="color: var(--primary);">Aura Hospital Group</h4>
                                        <p class="text-muted mb-0 small">742 Evergreen Terrace, Medical
                                            District<br>Springfield, OR 97477 • support@aurahms.com</p>
                                    </div>
                                    <div class="text-end">
                                        <h3 class="fw-bold mb-1" style="letter-spacing: -0.5px;">RECEIPT</h3>
                                        <span class="fw-semibold text-muted">#AURA-10283</span>
                                    </div>
                                </div>

                                <div class="divider-line"></div>

                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <span class="text-muted d-block mb-1 text-uppercase fw-semibold"
                                            style="font-size: 0.75rem;">Patient Details:</span>
                                        <h6 class="fw-bold mb-1">Eleanor Vance</h6>
                                        <p class="text-muted mb-0 small">Patient ID: #PT-1082<br>Email:
                                            eleanor@vance.com<br>Contact: +1 (555) 019-2834</p>
                                    </div>
                                    <div class="col-md-6 text-md-end">
                                        <span class="text-muted d-block mb-1 text-uppercase fw-semibold"
                                            style="font-size: 0.75rem;">Billing Info:</span>
                                        <p class="text-muted mb-0 small">
                                            Billing Date: <span class="fw-semibold text-dark">2026-06-28</span><br>
                                            Due Date: <span class="fw-semibold text-dark">2026-07-05</span><br>
                                            Status: <span class="fw-semibold text-success">Paid via Visa Card</span>
                                        </p>
                                    </div>
                                </div>

                                <table class="table table-borderless mb-4">
                                    <thead>
                                        <tr>
                                            <th style="width: 55%;">Item Description</th>
                                            <th class="text-end" style="width: 15%;">Rate</th>
                                            <th class="text-center" style="width: 15%;">Qty</th>
                                            <th class="text-end" style="width: 15%;">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="fw-bold">Cardiology OPD Consultation Session</div>
                                                <small class="text-muted">Clinical Specialist: Dr. Sarah Connor</small>
                                            </td>
                                            <td class="text-end">$150.00</td>
                                            <td class="text-center">1</td>
                                            <td class="text-end">$150.00</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="fw-bold">Comprehensive Pathology Screening (CBC + Lipid
                                                    Profile)</div>
                                                <small class="text-muted">Laboratory Diagnostics Division</small>
                                            </td>
                                            <td class="text-end">$350.00</td>
                                            <td class="text-center">1</td>
                                            <td class="text-end">$350.00</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="fw-bold">Pacemaker Implant Post-Op ICU Care Charge</div>
                                                <small class="text-muted">OPD critical care ward room 12</small>
                                            </td>
                                            <td class="text-end">$1,000.00</td>
                                            <td class="text-center">1</td>
                                            <td class="text-end">$1,000.00</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="divider-line"></div>

                                <div class="row">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <h6 class="fw-bold mb-2">Terms & Insurance:</h6>
                                        <p class="text-muted small mb-0">Payments are due within 7 days from billing
                                            date. Payments processed are insurance covered under health policy AuraPlus.
                                            Thank you.</p>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex flex-column gap-2 text-dark" style="font-size: 0.9rem;">
                                            <div class="d-flex justify-content-between">
                                                <span class="text-muted">Subtotal:</span>
                                                <span class="fw-semibold">$1,500.00</span>
                                            </div>
                                            <div class="d-flex justify-content-between text-success">
                                                <span>Insurance Discount (10%):</span>
                                                <span class="fw-semibold">-$150.00</span>
                                            </div>
                                            <div class="d-flex justify-content-between text-muted">
                                                <span>GST Summary (CGST 9% + SGST 9%):</span>
                                                <span class="fw-semibold">+$100.00</span>
                                            </div>
                                            <div class="divider-line my-1"></div>
                                            <div class="d-flex justify-content-between fw-bold"
                                                style="font-size: 1.1rem; color: var(--primary);">
                                                <span>Total Amount Paid:</span>
                                                <span>$1,450.00</span>
                                            </div>
                                        </div>
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