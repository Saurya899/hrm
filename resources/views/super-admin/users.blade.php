<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraHMS - Manage System Users</title>
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
        @include('super-admin.sidebar')

        <!-- MAIN WRAPPER -->
        <main class="main-wrapper">

            <!-- TOP NAVBAR -->
            @include('super-admin.header')

            <!-- CONTENT BODY -->
            <div class="content-body">

                <!-- BREADCRUMB & HEADER -->
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                    <div>
                        <nav>
                            <ul class="breadcrumb-custom mb-1">
                                <li class="breadcrumb-item-custom"><a href="/super-admin/dashboard">Home</a></li>
                                <li class="breadcrumb-item-custom">Manage Users</li>
                            </ul>
                        </nav>
                        <h4 class="fw-bold mb-0">System User & Role Center</h4>
                    </div>

                    <button class="btn btn-premium d-flex align-items-center gap-2" data-bs-toggle="modal"
                        data-bs-target="#addUserModal">
                        <i class="bi bi-person-plus-fill"></i> Provision User
                    </button>
                </div>

                <!-- SKELETON LOADER -->
                <div class="skeleton-wrapper row g-4 mb-4">
                    <div class="col-md-8">
                        <div class="glass-card skeleton" style="height: 400px;"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="glass-card skeleton" style="height: 400px;"></div>
                    </div>
                </div>

                <!-- REAL CONTENT WRAPPER -->
                <div class="real-content-wrapper d-none">

                    <div class="row g-4 mb-4">
                        <!-- USER ROSTER -->
                        <div class="col-xl-8">
                            <div class="glass-card h-100">
                                <h5 class="mb-4 fw-bold">Active User Directory</h5>

                                <div class="custom-table-container">
                                    <table class="custom-table">
                                        <thead>
                                            <tr>
                                                <th>User Profile</th>
                                                <th>System Role</th>
                                                <th>Active Permissions</th>
                                                <th>Status</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&q=80&w=100"
                                                            class="rounded-circle"
                                                            style="width: 36px; height: 36px; object-fit: cover;"
                                                            alt="User">
                                                        <div>
                                                            <div class="fw-bold">Dr. Gregory House</div>
                                                            <small class="text-muted">admin@aurahms.com</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-primary text-uppercase px-2 py-1">Super
                                                        Admin</span></td>
                                                <td>All System Permissions</td>
                                                <td><span class="custom-badge badge-success">Active</span></td>
                                                <td class="text-end">
                                                    <button class="btn btn-sm btn-premium-outline me-2"
                                                        onclick="showToast('Permission Config', 'Pre-filling permissions for Gregory House.', 'info')"
                                                        data-bs-toggle="modal" data-bs-target="#addUserModal"><i
                                                            class="bi bi-shield-check"></i></button>
                                                    <button class="btn btn-sm btn-premium" disabled><i
                                                            class="bi bi-trash-fill"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <img src="https://images.unsplash.com/photo-1594824813573-246434de83fb?auto=format&fit=crop&q=80&w=100"
                                                            class="rounded-circle"
                                                            style="width: 36px; height: 36px; object-fit: cover;"
                                                            alt="User">
                                                        <div>
                                                            <div class="fw-bold">Dr. Sarah Connor</div>
                                                            <small class="text-muted">doctor@aurahms.com</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-info text-uppercase px-2 py-1">Doctor</span>
                                                </td>
                                                <td>Schedule, Consult, Assigned Patients</td>
                                                <td><span class="custom-badge badge-success">Active</span></td>
                                                <td class="text-end">
                                                    <button class="btn btn-sm btn-premium-outline me-2"
                                                        data-bs-toggle="modal" data-bs-target="#addUserModal"><i
                                                            class="bi bi-shield-check"></i></button>
                                                    <button class="btn btn-sm btn-premium"
                                                        onclick="showToast('De-provisioned user', 'Successfully disabled doctor role credentials.', 'warning')"><i
                                                            class="bi bi-trash-fill"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- SECURITY AUDIT LOG -->
                        <div class="col-xl-4">
                            <div class="glass-card h-100">
                                <h5 class="mb-4 fw-bold">Security & Audit Logs</h5>
                                <div class="timeline-custom">
                                    <div class="timeline-item success">
                                        <div class="fw-bold" style="font-size: 0.85rem;">Super Admin Login Successful
                                        </div>
                                        <small class="text-muted d-block mb-1">IP: 192.168.1.5 • Browser:
                                            Chrome/Win</small>
                                        <span style="font-size: 0.75rem; color: var(--text-muted);">Just now</span>
                                    </div>
                                    <div class="timeline-item info">
                                        <div class="fw-bold" style="font-size: 0.85rem;">Backup Dump Initialized</div>
                                        <small class="text-muted d-block mb-1">Triggered manually by Dr. Gregory
                                            House</small>
                                        <span style="font-size: 0.75rem; color: var(--text-muted);">2 hours ago</span>
                                    </div>
                                    <div class="timeline-item warning">
                                        <div class="fw-bold" style="font-size: 0.85rem;">Credentials Update Requested
                                        </div>
                                        <small class="text-muted d-block mb-1">Doctor Sarah Connor changed profile
                                            security passphrase</small>
                                        <span style="font-size: 0.75rem; color: var(--text-muted);">Yesterday</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </main>
    </div>

    <!-- MODAL: ADD / PROVISION USER WITH PERMISSIONS CHECKBOXES -->
    <div class="modal fade modal-glass" id="addUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header border-light border-opacity-10">
                    <h5 class="modal-title fw-bold">System Credentials Provisioning</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form
                    onsubmit="event.preventDefault(); bootstrap.Modal.getInstance(document.getElementById('addUserModal')).hide(); showToast('User Provisioned', 'Account successfully created and key permissions linked.', 'success');">
                    <div class="modal-body">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label-custom">Staff Full Name</label>
                                <input type="text" class="form-control form-glass" placeholder="e.g. Dr. Watson"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Corporate Email Address</label>
                                <input type="email" class="form-control form-glass" placeholder="watson@aurahms.com"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Primary System Role</label>
                                <select class="form-select form-glass" required>
                                    <option value="doctor">Doctor / Clinician</option>
                                    <option value="super-admin">Super Admin</option>
                                    <option value="receptionist">Receptionist / Front Desk</option>
                                    <option value="pharmacist">Pharmacist</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Staff License Access Key</label>
                                <input type="text" class="form-control form-glass" placeholder="e.g. MC-9024">
                            </div>
                        </div>

                        <h6 class="fw-bold text-primary mb-3">Access Control Permissions Grid</h6>
                        <div class="glass-sub-card p-4 rounded-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-check form-check-custom">
                                        <input class="form-check-input" type="checkbox" id="permViewPatients" checked>
                                        <label class="form-check-label text-white" for="permViewPatients">
                                            View Patient Demographics & Records
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-check-custom">
                                        <input class="form-check-input" type="checkbox" id="permEditPrescriptions"
                                            checked>
                                        <label class="form-check-label text-white" for="permEditPrescriptions">
                                            Compose & Edit Prescriptions
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-check-custom">
                                        <input class="form-check-input" type="checkbox" id="permManageBilling">
                                        <label class="form-check-label text-white" for="permManageBilling">
                                            Process Billing Invoices & Receipts
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-check-custom">
                                        <input class="form-check-input" type="checkbox" id="permDbBackup">
                                        <label class="form-check-label text-white" for="permDbBackup">
                                            Generate Database Dump Backups
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check form-check-custom">
                                        <input class="form-check-input" type="checkbox" id="permManageUsers">
                                        <label class="form-check-label text-white" for="permManageUsers">
                                            Manage Accounts & Assign Access Roles
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-light border-opacity-10">
                        <button type="button" class="btn btn-premium-outline" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-premium">Complete Provisioning</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Main JS -->
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>