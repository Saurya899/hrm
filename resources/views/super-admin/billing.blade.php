<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraHMS - Billing & Invoices</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Dark Theme Support for Modals & Tables */
        [data-theme="dark"] .modal-content {
            background: #0f172a !important;
            color: #f8fafc !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6) !important;
        }

        [data-theme="dark"] .modal-header,
        [data-theme="dark"] .modal-footer {
            border-color: rgba(255, 255, 255, 0.08) !important;
        }

        [data-theme="dark"] .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background-color: rgba(30, 41, 59, 0.8) !important;
            border-color: rgba(255, 255, 255, 0.12) !important;
            color: #f8fafc !important;
        }

        [data-theme="dark"] select option {
            background-color: #0f172a !important;
            color: #f8fafc !important;
        }

        [data-theme="dark"] .form-control:focus,
        [data-theme="dark"] .form-select:focus {
            background-color: rgba(30, 41, 59, 0.95) !important;
            border-color: #6366f1 !important;
            color: #ffffff !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25) !important;
        }

        [data-theme="dark"] .form-control::placeholder {
            color: #64748b !important;
        }

        [data-theme="dark"] .table {
            color: #f8fafc !important;
            --bs-table-bg: transparent !important;
            --bs-table-color: #f8fafc !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
        }

        [data-theme="dark"] .table thead th {
            background-color: rgba(15, 23, 42, 0.8) !important;
            color: #94a3b8 !important;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1) !important;
        }

        [data-theme="dark"] .table tbody td {
            color: #cbd5e1 !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        }

        [data-theme="dark"] .table-bordered,
        [data-theme="dark"] .table-bordered th,
        [data-theme="dark"] .table-bordered td {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        [data-theme="dark"] .table-light {
            background-color: rgba(30, 41, 59, 0.6) !important;
            color: #cbd5e1 !important;
        }

        [data-theme="dark"] .bg-body-tertiary {
            background-color: rgba(30, 41, 59, 0.5) !important;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Invoice Preview Sheet Styling */
        .invoice-preview-sheet {
            background: #ffffff;
            color: #0f172a;
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: var(--shadow-lg, 0 10px 30px rgba(0, 0, 0, 0.1));
            border: 1px solid rgba(0, 0, 0, 0.05);
            font-size: 0.9rem;
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

        [data-theme="dark"] .invoice-preview-sheet {
            background: #0f172a !important;
            color: #f8fafc !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        [data-theme="dark"] .invoice-preview-sheet h3,
        [data-theme="dark"] .invoice-preview-sheet h4,
        [data-theme="dark"] .invoice-preview-sheet h5,
        [data-theme="dark"] .invoice-preview-sheet h6,
        [data-theme="dark"] .invoice-preview-sheet strong {
            color: #f8fafc !important;
        }

        [data-theme="dark"] .invoice-preview-sheet th {
            color: #94a3b8 !important;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1) !important;
            background: none !important;
        }

        [data-theme="dark"] .invoice-preview-sheet td {
            color: #cbd5e1 !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        }

        [data-theme="dark"] .invoice-preview-sheet .text-muted {
            color: #94a3b8 !important;
        }

        [data-theme="dark"] .invoice-preview-sheet .text-dark {
            color: #f8fafc !important;
        }

        [data-theme="dark"] .invoice-preview-sheet .divider-line {
            height: 1px;
            background-color: rgba(255, 255, 255, 0.1) !important;
            margin: 1.5rem 0;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .printable-area,
            .printable-area * {
                visibility: visible;
                color: #0f172a !important;
                background: #ffffff !important;
            }

            .printable-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                box-shadow: none;
                border: none;
                padding: 0;
            }
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
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <div>
                        <nav>
                            <ul class="breadcrumb-custom mb-1">
                                <li class="breadcrumb-item-custom"><a href="{{ route('super-admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item-custom">Billing</li>
                            </ul>
                        </nav>
                        <h4 class="fw-bold mb-0">Financial & Invoicing Hub</h4>
                    </div>
                    <div>
                        <button class="btn btn-primary d-flex align-items-center gap-2 px-3 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#createInvoiceModal">
                            <i class="bi bi-plus-circle-fill"></i> Create New Invoice
                        </button>
                    </div>
                </div>

                <!-- ALERTS -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $errors->first() }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- KPI STATS CARDS -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3 col-sm-6">
                        <div class="glass-card p-3 d-flex align-items-center gap-3">
                            <div class="rounded-3 p-3 text-white bg-success bg-gradient">
                                <i class="bi bi-currency-dollar fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Total Revenue Collected</small>
                                <h4 class="fw-bold mb-0">${{ number_format($totalRevenue, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="glass-card p-3 d-flex align-items-center gap-3">
                            <div class="rounded-3 p-3 text-white bg-info bg-gradient">
                                <i class="bi bi-receipt fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Total Invoices</small>
                                <h4 class="fw-bold mb-0">{{ $totalInvoicesCount }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="glass-card p-3 d-flex align-items-center gap-3">
                            <div class="rounded-3 p-3 text-white bg-primary bg-gradient">
                                <i class="bi bi-check2-circle fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Paid Invoices</small>
                                <h4 class="fw-bold mb-0">{{ $paidCount }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="glass-card p-3 d-flex align-items-center gap-3">
                            <div class="rounded-3 p-3 text-white bg-warning bg-gradient">
                                <i class="bi bi-clock-history fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Unpaid / Pending</small>
                                <h4 class="fw-bold mb-0">{{ $unpaidCount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEARCH & FILTER BAR -->
                <div class="glass-card p-3 mb-4">
                    <form action="{{ route('super-admin.billing') }}" method="GET" class="row g-2 align-items-center">
                        <div class="col-md-3 col-sm-6">
                            <select name="status" class="form-select form-glass" onchange="this.form.submit()">
                                <option value="">All Invoice Statuses</option>
                                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-glass text-muted"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" class="form-control form-glass" placeholder="Search by Invoice #, Title or Patient Name..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-3 col-12 d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100 fw-semibold">Search</button>
                            @if(request('search') || request('status'))
                                <a href="{{ route('super-admin.billing') }}" class="btn btn-outline-secondary">Reset</a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- INVOICES LOG TABLE -->
                <div class="glass-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">Billing & Invoice Records</h5>
                        <span class="badge bg-secondary">{{ count($invoices) }} Results</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle text-nowrap">
                            <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Patient</th>
                                    <th>Title</th>
                                    <th>Billing Date</th>
                                    <th>Due Date</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $invoice)
                                    <tr>
                                        <td>
                                            <span class="fw-bold text-primary">{{ $invoice->invoice_number }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="avatar-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:36px; height:36px;">
                                                    {{ strtoupper(substr($invoice->patient->user->name ?? 'P', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ $invoice->patient->user->name ?? 'N/A' }}</div>
                                                    <small class="text-muted">{{ $invoice->patient->user->email ?? 'N/A' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-medium">{{ $invoice->title }}</span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($invoice->billing_date)->format('M d, Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</td>
                                        <td>
                                            <span class="fw-bold">${{ number_format($invoice->total_amount, 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-dark-subtle text-body border">{{ $invoice->payment_method ?? 'Not Specified' }}</span>
                                        </td>
                                        <td>
                                            @if(strtolower($invoice->status) == 'paid')
                                                <span class="badge bg-success-subtle text-success px-3 py-1 border border-success-subtle rounded-pill">Paid</span>
                                            @elseif(strtolower($invoice->status) == 'unpaid')
                                                <span class="badge bg-warning-subtle text-warning px-3 py-1 border border-warning-subtle rounded-pill">Unpaid</span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger px-3 py-1 border border-danger-subtle rounded-pill">{{ ucfirst($invoice->status) }}</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#viewInvoiceModal_{{ $invoice->id }}" title="View / Print Invoice">
                                                    <i class="bi bi-eye-fill"></i> View
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updateStatusModal_{{ $invoice->id }}" title="Update Status">
                                                    <i class="bi bi-pencil-square"></i> Status
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteInvoiceModal_{{ $invoice->id }}" title="Delete Invoice">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5 text-muted">
                                            <i class="bi bi-receipt fs-1 d-block mb-2 text-secondary"></i>
                                            No billing invoices found. Click <strong>"Create New Invoice"</strong> to add one.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- MODALS FOR EACH INVOICE RECORD -->
    @foreach($invoices as $invoice)
        <!-- UPDATE STATUS MODAL -->
        <div class="modal fade" id="updateStatusModal_{{ $invoice->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content glass-card">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold">Update Invoice Status - {{ $invoice->invoice_number }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('super-admin.billing.status', $invoice->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Payment Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="unpaid" {{ strtolower($invoice->status) == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                    <option value="paid" {{ strtolower($invoice->status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="cancelled" {{ strtolower($invoice->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Payment Method</label>
                                <select name="payment_method" class="form-select">
                                    <option value="Cash" {{ $invoice->payment_method == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="Credit/Debit Card" {{ $invoice->payment_method == 'Credit/Debit Card' ? 'selected' : '' }}>Credit / Debit Card</option>
                                    <option value="Online / UPI" {{ $invoice->payment_method == 'Online / UPI' ? 'selected' : '' }}>Online / UPI</option>
                                    <option value="Insurance Claim" {{ $invoice->payment_method == 'Insurance Claim' ? 'selected' : '' }}>Insurance Claim</option>
                                    <option value="Bank Transfer" {{ $invoice->payment_method == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- DELETE INVOICE MODAL -->
        <div class="modal fade" id="deleteInvoiceModal_{{ $invoice->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content glass-card">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold text-danger">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p>Are you sure you want to delete invoice <strong class="text-primary">{{ $invoice->invoice_number }}</strong>?</p>
                    </div>
                    <div class="modal-footer border-0 justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('super-admin.billing.destroy', $invoice->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- VIEW / PRINT INVOICE MODAL -->
        <div class="modal fade" id="viewInvoiceModal_{{ $invoice->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 bg-transparent">
                    <div class="modal-header border-0 bg-dark text-white px-4 py-3 rounded-top">
                        <h5 class="modal-title fw-bold"><i class="bi bi-receipt me-2"></i>Invoice Details</h5>
                        <div>
                            <button type="button" class="btn btn-sm btn-light me-2" onclick="printInvoice({{ $invoice->id }}, '{{ $invoice->invoice_number }}', '{{ addslashes($invoice->patient->user->name ?? 'Patient') }}')">
                                <i class="bi bi-printer-fill me-1"></i> Print Invoice
                            </button>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="modal-body p-0">
                        <div class="invoice-preview-sheet printable-area" id="printable-invoice-{{ $invoice->id }}">
                            <!-- Invoice Header -->
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div>
                                    <h3 class="fw-bold text-primary mb-1">AuraHMS Clinic</h3>
                                    <p class="text-muted mb-0 small">123 Healthcare Boulevard, Medical District</p>
                                    <p class="text-muted mb-0 small">Phone: +1 (800) 555-AURA | Email: billing@aurahms.com</p>
                                </div>
                                <div class="text-end">
                                    <h4 class="fw-bold text-dark mb-1">INVOICE</h4>
                                    <span class="fw-bold text-primary fs-5">{{ $invoice->invoice_number }}</span>
                                    <div class="mt-2">
                                        @if(strtolower($invoice->status) == 'paid')
                                            <span class="badge bg-success fs-6 px-3 py-1">PAID</span>
                                        @else
                                            <span class="badge bg-warning text-dark fs-6 px-3 py-1">{{ strtoupper($invoice->status) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="divider-line"></div>

                            <!-- Patient & Invoice Dates Info -->
                            <div class="row mb-4">
                                <div class="col-6">
                                    <h6 class="fw-bold text-uppercase text-muted small mb-2">Billed To:</h6>
                                    <h5 class="fw-bold mb-1">{{ $invoice->patient->user->name ?? 'Patient' }}</h5>
                                    <p class="mb-0 text-muted small"><i class="bi bi-envelope me-1"></i>{{ $invoice->patient->user->email ?? 'N/A' }}</p>
                                    <p class="mb-0 text-muted small"><i class="bi bi-telephone me-1"></i>{{ $invoice->patient->number ?? 'N/A' }}</p>
                                    <p class="mb-0 text-muted small"><i class="bi bi-geo-alt me-1"></i>{{ $invoice->patient->address ?? 'N/A' }}</p>
                                </div>
                                <div class="col-6 text-end">
                                    <h6 class="fw-bold text-uppercase text-muted small mb-2">Invoice Information:</h6>
                                    <p class="mb-1"><span class="text-muted">Title:</span> <strong>{{ $invoice->title }}</strong></p>
                                    <p class="mb-1"><span class="text-muted">Billing Date:</span> <strong>{{ \Carbon\Carbon::parse($invoice->billing_date)->format('M d, Y') }}</strong></p>
                                    <p class="mb-1"><span class="text-muted">Due Date:</span> <strong>{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</strong></p>
                                    <p class="mb-0"><span class="text-muted">Payment Method:</span> <strong>{{ $invoice->payment_method ?? 'N/A' }}</strong></p>
                                </div>
                            </div>

                            <!-- Line Items Table -->
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered align-middle">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Item Description</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-end">Rate ($)</th>
                                            <th class="text-end">Amount ($)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($invoice->items as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="fw-bold">{{ $item->description }}</div>
                                                </td>
                                                <td class="text-center">{{ $item->qty }}</td>
                                                <td class="text-end">${{ number_format($item->rate, 2) }}</td>
                                                <td class="text-end">${{ number_format($item->total, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">No items found for this invoice.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Invoice Summary Breakdown -->
                            <div class="row align-items-center">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <h6 class="fw-bold mb-2">Terms & Notes:</h6>
                                    <p class="text-muted small mb-0">Payments are due within the payment window specified above. Thank you for choosing AuraHMS Medical Services.</p>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex flex-column gap-2 text-dark">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Subtotal:</span>
                                            <span class="fw-semibold">${{ number_format($invoice->subtotal, 2) }}</span>
                                        </div>
                                        @if($invoice->discount > 0)
                                            <div class="d-flex justify-content-between text-success">
                                                <span>Discount:</span>
                                                <span class="fw-semibold">-${{ number_format($invoice->discount, 2) }}</span>
                                            </div>
                                        @endif
                                        @if($invoice->gst > 0)
                                            <div class="d-flex justify-content-between text-muted">
                                                <span>GST Tax:</span>
                                                <span class="fw-semibold">+${{ number_format($invoice->gst, 2) }}</span>
                                            </div>
                                        @endif
                                        <div class="divider-line my-1"></div>
                                        <div class="d-flex justify-content-between fw-bold fs-5 text-primary">
                                            <span>Total Amount:</span>
                                            <span>${{ number_format($invoice->total_amount, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- CREATE INVOICE MODAL -->
    <div class="modal fade" id="createInvoiceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content glass-card">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle text-primary me-2"></i>Create New Invoice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('super-admin.billing.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Select Patient <span class="text-danger">*</span></label>
                                <select name="patient_id" class="form-select" required>
                                    <option value="">-- Choose Patient --</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->user->name ?? 'Patient' }} (ID: {{ $patient->id }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Invoice Title / Description <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" placeholder="e.g. OPD Consultation & Medication Fee" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Billing Date <span class="text-danger">*</span></label>
                                <input type="date" name="billing_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Due Date <span class="text-danger">*</span></label>
                                <input type="date" name="due_date" class="form-control" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Payment Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="unpaid" selected>Unpaid</option>
                                    <option value="paid">Paid</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Payment Method</label>
                                <select name="payment_method" class="form-select">
                                    <option value="Pending">Pending / None</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Credit/Debit Card">Credit / Debit Card</option>
                                    <option value="Online / UPI">Online / UPI</option>
                                    <option value="Insurance Claim">Insurance Claim</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Discount Amount ($)</label>
                                <input type="number" step="0.01" min="0" name="discount" id="invoice_discount" class="form-control" value="0.00" oninput="calculateTotals()">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">GST / Tax Amount ($)</label>
                                <input type="number" step="0.01" min="0" name="gst" id="invoice_gst" class="form-control" value="0.00" oninput="calculateTotals()">
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- INVOICE ITEMS REPEATER -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Invoice Line Items</h6>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addItemRow()">
                                <i class="bi bi-plus-lg me-1"></i> Add Item Row
                            </button>
                        </div>

                        <div class="table-responsive mb-3">
                            <table class="table table-sm align-middle" id="itemsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 45%;">Item / Service Description</th>
                                        <th style="width: 20%;">Qty</th>
                                        <th style="width: 25%;">Rate ($)</th>
                                        <th style="width: 10%;" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="itemsTableBody">
                                    <tr>
                                        <td>
                                            <input type="text" name="items[0][description]" class="form-control form-control-sm" placeholder="Consultation Fee" required>
                                        </td>
                                        <td>
                                            <input type="number" min="1" name="items[0][qty]" class="form-control form-control-sm item-qty" value="1" oninput="calculateTotals()" required>
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" min="0" name="items[0][rate]" class="form-control form-control-sm item-rate" value="100.00" oninput="calculateTotals()" required>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-link text-danger" onclick="removeItemRow(this)" disabled><i class="bi bi-trash-fill"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- LIVE CALCULATION DISPLAY -->
                        <div class="bg-body-tertiary p-3 rounded-3 mb-2">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Subtotal:</span>
                                <span class="fw-bold" id="display_subtotal">$100.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1 text-success">
                                <span>Discount:</span>
                                <span class="fw-bold" id="display_discount">-$0.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1 text-muted">
                                <span>GST Tax:</span>
                                <span class="fw-bold" id="display_gst">+$0.00</span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between fw-bold fs-5 text-primary">
                                <span>Grand Total Amount:</span>
                                <span id="display_total">$100.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4 fw-semibold">Generate Invoice</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Main JS -->
    <script src="{{ asset('js/script.js') }}"></script>

    <script>
        let itemIndex = 1;

        function addItemRow() {
            const tbody = document.getElementById('itemsTableBody');
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>
                    <input type="text" name="items[${itemIndex}][description]" class="form-control form-control-sm" placeholder="Service description" required>
                </td>
                <td>
                    <input type="number" min="1" name="items[${itemIndex}][qty]" class="form-control form-control-sm item-qty" value="1" oninput="calculateTotals()" required>
                </td>
                <td>
                    <input type="number" step="0.01" min="0" name="items[${itemIndex}][rate]" class="form-control form-control-sm item-rate" value="50.00" oninput="calculateTotals()" required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-link text-danger" onclick="removeItemRow(this)"><i class="bi bi-trash-fill"></i></button>
                </td>
            `;
            tbody.appendChild(tr);
            itemIndex++;
            updateRemoveButtons();
            calculateTotals();
        }

        function removeItemRow(btn) {
            const row = btn.closest('tr');
            row.remove();
            updateRemoveButtons();
            calculateTotals();
        }

        function updateRemoveButtons() {
            const rows = document.querySelectorAll('#itemsTableBody tr');
            rows.forEach(row => {
                const btn = row.querySelector('.text-danger');
                if (btn) {
                    btn.disabled = (rows.length === 1);
                }
            });
        }

        function calculateTotals() {
            let subtotal = 0;
            const rows = document.querySelectorAll('#itemsTableBody tr');
            rows.forEach(row => {
                const qtyInput = row.querySelector('.item-qty');
                const rateInput = row.querySelector('.item-rate');
                const qty = parseFloat(qtyInput ? qtyInput.value : 0) || 0;
                const rate = parseFloat(rateInput ? rateInput.value : 0) || 0;
                subtotal += (qty * rate);
            });

            const discount = parseFloat(document.getElementById('invoice_discount').value) || 0;
            const gst = parseFloat(document.getElementById('invoice_gst').value) || 0;
            const grandTotal = Math.max(0, subtotal - discount + gst);

            document.getElementById('display_subtotal').innerText = '$' + subtotal.toFixed(2);
            document.getElementById('display_discount').innerText = '-$' + discount.toFixed(2);
            document.getElementById('display_gst').innerText = '+$' + gst.toFixed(2);
            document.getElementById('display_total').innerText = '$' + grandTotal.toFixed(2);
        }

        function printInvoice(invoiceId, invoiceNumber, patientName) {
            const printElement = document.getElementById('printable-invoice-' + invoiceId);
            if (!printElement) return;

            const safePatientName = (patientName || 'Patient').replace(/[^a-zA-Z0-9\s]/g, '').trim().replace(/\s+/g, '_');
            const pdfFileName = `${invoiceNumber}_${safePatientName}`;

            const printContents = printElement.innerHTML;
            const printWindow = window.open('', '_blank', 'width=900,height=850');

            printWindow.document.write(`
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <title>${pdfFileName}</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
                    <style>
                        body {
                            background-color: #ffffff !important;
                            color: #0f172a !important;
                            font-family: system-ui, -apple-system, sans-serif;
                            padding: 2.5rem;
                            -webkit-print-color-adjust: exact;
                            print-color-adjust: exact;
                        }
                        .invoice-preview-sheet {
                            background: #ffffff !important;
                            color: #0f172a !important;
                            box-shadow: none !important;
                            border: none !important;
                            padding: 0 !important;
                        }
                        .divider-line {
                            height: 1px;
                            background-color: #e2e8f0 !important;
                            margin: 1.5rem 0;
                        }
                        th {
                            color: #475569 !important;
                            font-weight: 600;
                            border-bottom: 2px solid #e2e8f0 !important;
                            text-transform: uppercase;
                            font-size: 0.75rem;
                            letter-spacing: 0.5px;
                            background: none !important;
                        }
                        td {
                            color: #334155 !important;
                            border-bottom: 1px solid #f1f5f9 !important;
                        }
                        .text-muted { color: #64748b !important; }
                        .text-dark { color: #0f172a !important; }
                        .badge {
                            border: 1px solid #cbd5e1 !important;
                            padding: 0.35em 0.65em;
                        }
                        @media print {
                            @page {
                                size: auto;
                                margin: 12mm;
                            }
                            body {
                                padding: 0 !important;
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="invoice-preview-sheet">
                        ${printContents}
                    </div>
                    <script>
                        window.onload = function() {
                            window.focus();
                            window.print();
                            setTimeout(function() {
                                window.close();
                            }, 500);
                        };
                    <\/script>
                </body>
                </html>
            `);
            printWindow.document.close();
        }

        document.addEventListener('DOMContentLoaded', function() {
            calculateTotals();
        });
    </script>
</body>

</html>