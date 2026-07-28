<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraHMS - System Settings & Profile</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .error-preview-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: var(--body-bg);
            z-index: 1060;
            display: none;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
            animation: fadeIn 0.3s ease forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <nav>
                            <ul class="breadcrumb-custom mb-1">
                                <li class="breadcrumb-item-custom"><a href="/super-admin/dashboard">Home</a></li>
                                <li class="breadcrumb-item-custom">Settings</li>
                            </ul>
                        </nav>
                        <h4 class="fw-bold mb-0">System Control Centre</h4>
                    </div>
                </div>

                <!-- SKELETON LOADER -->
                <div class="skeleton-wrapper row g-4 mb-4">
                    <div class="col-12">
                        <div class="glass-card skeleton" style="height: 450px;"></div>
                    </div>
                </div>

                <!-- REAL CONTENT WRAPPER -->
                <div class="real-content-wrapper">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="row g-4">
                        <div class="col-12">
                            <div class="glass-card">
                                <ul class="nav nav-tabs border-light border-opacity-10 mb-4" role="tablist">
                                    <li class="nav-item">
                                        <button class="nav-link active border-0 bg-transparent px-3 py-2 fw-semibold"
                                            id="branding-tab" data-bs-toggle="tab" data-bs-target="#tab-branding"
                                            type="button" role="tab"><i class="bi bi-patch-check"></i> Super Admin
                                            Profile</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link border-0 bg-transparent px-3 py-2 fw-semibold" id="security-tab" data-bs-toggle="tab" data-bs-target="#tab-security" type="button" role="tab"><i class="bi bi-shield-lock"></i> Security & Password</button>
                                    </li>
                                   
                                </ul>

                                <div class="tab-content">
                                    <!-- 1. CLINIC PROFILE -->
                                    <div class="tab-pane fade show active" id="tab-branding" role="tabpanel">
                                        <form action="{{route('super-admin.settings.profile')}}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row g-3 align-items-center mb-3">
                                                <div class="col-md-3 text-center mb-3 mb-md-0">
                                                   <img src="{{Auth::user()->profile_photo_url}}" alt="Super Admin" class="rounded-circle border border-light border-opacity-10 mb-2"
                                                    style="width: 100px; height:100px;object-fit:cover;">
                                                </div>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label-custom">Full Name</label>
                                                    <input type="text" name="name" class="form-control form-glass" 
                                                    value="{{Auth::user()->name}}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label-custom">Email</label>
                                                    <input type="email" name="email" class="form-control form-glass"
                                                        value="{{Auth::user()->email}}" required>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label-custom">Upload Profile Photo</label>
                                                    <input type="file" name="profile_photo" class="form-control form-glass">
                                                </div>
                                            </div>
                                          
                                            <div class="mt-4 pt-3 border-top border-light border-opacity-10 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-premium">Save Profile</button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- 2. STAFF CREDENTIALS -->
                                    <div class="tab-pane fade" id="tab-security" role="tabpanel">
                                        <form action="{{route('super-admin.settings.security')}}" method="post">
                                            @csrf
                                            <div class="row g-3">
                                 
                                                <div class="col-md-4">
                                                    <label class="form-label-custom">Current Password</label>
                                                    <input type="password" name="current_password" class="form-control form-glass"
                                                     required   >
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label-custom"> New Password</label>
                                                    <input type="password" name="new_password" class="form-control form-glass"
                                                      required  >
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label-custom">Verify Password Change</label>
                                                    <input type="password" name="new_password_confirmation" class="form-control form-glass"
                                                      required >
                                                </div>
                                            </div>
                                            <div
                                                class="mt-4 pt-3 border-top border-light border-opacity-10 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-premium">Update Password</button>
                                            </div>
                                        </form>
                                    </div>
                                

                                    <!-- 4. DB BACKUPS -->
                                    <div class="tab-pane fade" id="tab-backups" role="tabpanel">
                                        <div
                                            class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                                            <div>
                                                <h6 class="fw-bold mb-1">AuraHMS Backup Matrix</h6>
                                                <small class="text-muted">Automated schema backups run daily at 00:00
                                                    AM.</small>
                                            </div>
                                            <button class="btn btn-premium btn-sm"
                                                onclick="showToast('Backup Triggered', 'HMS dump sequence initialized.', 'success')"><i
                                                    class="bi bi-cloud-arrow-up"></i> Generate Backup Now</button>
                                        </div>

                                        <div class="custom-table-container">
                                            <table class="custom-table">
                                                <thead>
                                                    <tr>
                                                        <th>Timestamp File</th>
                                                        <th>Directory Volume</th>
                                                        <th>Sync Status</th>
                                                        <th class="text-end">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>aura_hms_dump_2026-06-29.sql</td>
                                                        <td>12.4 MB</td>
                                                        <td><span class="custom-badge badge-success">Completed</span>
                                                        </td>
                                                        <td class="text-end">
                                                            <button class="btn btn-sm btn-premium-outline me-2"
                                                                onclick="showToast('Restoring State', 'Re-indexing database cluster.', 'warning')"><i
                                                                    class="bi bi-clock-history"></i> Restore</button>
                                                            <button class="btn btn-sm btn-premium"
                                                                onclick="showToast('Archive Sent', 'Triggering file download.', 'success')"><i
                                                                    class="bi bi-download"></i> Download</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- 5. HTTP ERROR PREVIEWS -->
                                    <div class="tab-pane fade" id="tab-errors" role="tabpanel">
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <button class="btn btn-premium-outline w-100"
                                                    onclick="triggerErrorPreview('error-403')">403 Forbidden</button>
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn btn-premium-outline w-100"
                                                    onclick="triggerErrorPreview('error-404')">404 Not Found</button>
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn btn-premium-outline w-100"
                                                    onclick="triggerErrorPreview('error-500')">500 Server Error</button>
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn btn-premium-outline w-100"
                                                    onclick="triggerErrorPreview('error-maint')">Maintenance
                                                    Mode</button>
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

    <!-- ERROR PREVIEWS FULLSCREEN OVERLAYS -->
    <!-- 403 Forbidden -->
    <div class="error-preview-overlay" id="error-403">
        <div>
            <i class="bi bi-shield-slash-fill text-danger mb-4" style="font-size: 5rem; display: block;"></i>
            <h1 class="fw-bold mb-2">403 Forbidden</h1>
            <p class="text-muted mb-4 mx-auto" style="max-width: 500px;">Access Violation. The requested action requires
                senior supervisor clearance permissions.</p>
            <button class="btn btn-premium" onclick="closeErrorPreview('error-403')">Return to System Settings</button>
        </div>
    </div>

    <!-- 404 Not Found -->
    <div class="error-preview-overlay" id="error-404">
        <div>
            <i class="bi bi-search text-warning mb-4" style="font-size: 5rem; display: block;"></i>
            <h1 class="fw-bold mb-2">404 Patient Record Missing</h1>
            <p class="text-muted mb-4 mx-auto" style="max-width: 500px;">We couldn't resolve the directory query
                reference ID you were searching for.</p>
            <button class="btn btn-premium" onclick="closeErrorPreview('error-404')">Return to System Settings</button>
        </div>
    </div>

    <!-- 500 Server Error -->
    <div class="error-preview-overlay" id="error-500">
        <div>
            <i class="bi bi-bug-fill text-danger mb-4" style="font-size: 5rem; display: block;"></i>
            <h1 class="fw-bold mb-2">500 Server Crash</h1>
            <p class="text-muted mb-4 mx-auto" style="max-width: 500px;">Internal connection timeout. The SQL cluster
                failed to respond to the clinical query thread.</p>
            <button class="btn btn-premium" onclick="closeErrorPreview('error-500')">Return to System Settings</button>
        </div>
    </div>

    <!-- Maintenance Mode -->
    <div class="error-preview-overlay" id="error-maint">
        <div>
            <i class="bi bi-tools text-info mb-4" style="font-size: 5rem; display: block;"></i>
            <h1 class="fw-bold mb-2">AuraHMS System Upgrade</h1>
            <p class="text-muted mb-4 mx-auto" style="max-width: 500px;">The administration portal is temporarily under
                scheduled backup sequence optimization.</p>
            <button class="btn btn-premium" onclick="closeErrorPreview('error-maint')">Return to System
                Settings</button>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Main JS -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        function triggerErrorPreview(overlayId) {
            const overlay = document.getElementById(overlayId);
            if (overlay) {
                overlay.style.display = 'flex';
            }
        }
        function closeErrorPreview(overlayId) {
            const overlay = document.getElementById(overlayId);
            if (overlay) {
                overlay.style.display = 'none';
            }
        }
    </script>
</body>

</html>