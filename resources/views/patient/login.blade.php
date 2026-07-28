<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraHMS - Patient Care Portal</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            z-index: 10;
        }
        .auth-glass-box {
            background: var(--card-bg);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            width: 100%;
            max-width: 1000px;
            display: flex;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        .auth-info-side {
            width: 45%;
            padding: 3rem;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(99, 102, 241, 0.08) 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-right: 1px solid var(--border-color);
        }
        .auth-form-side {
            width: 55%;
            padding: 3rem;
            position: relative;
        }
        .auth-form-panel {
            display: none;
            animation: fadeIn 0.4s ease-in-out forwards;
        }
        .auth-form-panel.active {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .pulse-logo {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--success) 0%, var(--primary) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.4);
            animation: heartPulse 2s infinite;
        }
        @keyframes heartPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.08); }
        }
        .patient-badge {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.3);
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }
        @media (max-width: 768px) {
            .auth-glass-box {
                flex-direction: column;
            }
            .auth-info-side {
                width: 100%;
                padding: 2rem;
                border-right: none;
                border-bottom: 1px solid var(--border-color);
            }
            .auth-form-side {
                width: 100%;
                padding: 2rem;
            }
        }
    </style>
</head>
<body>

    <!-- Page Loader -->
    <div class="page-loader" id="page-loader">
        <div class="loader-spinner"></div>
    </div>

    <!-- Background Decorative Gradients -->
    <div style="position: absolute; top: -10%; left: -10%; width: 40%; height: 40%; background: radial-gradient(circle, rgba(16,185,129,0.1) 0%, transparent 70%); filter: blur(50px); pointer-events: none; z-index: 1;"></div>
    <div style="position: absolute; bottom: -10%; right: -10%; width: 40%; height: 40%; background: radial-gradient(circle, rgba(99,102,241,0.1) 0%, transparent 70%); filter: blur(50px); pointer-events: none; z-index: 1;"></div>

    <div class="auth-container">
        <div class="auth-glass-box">
            
            <!-- Left Info Panel -->
            <div class="auth-info-side">
                <div>
                    <div class="pulse-logo mb-4">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="mb-3">
                        <span class="patient-badge">
                            <i class="bi bi-heart-fill"></i>
                            PATIENT CARE PORTAL
                        </span>
                    </div>
                    <h3 class="fw-bold mb-2">AuraHMS Patients</h3>
                    <p class="text-muted" style="font-size: 0.95rem;">Access your personal health registry, clinical records, laboratory checkup reports, and scheduling request portal.</p>
                </div>
                
                <div class="my-4 d-none d-md-block">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="p-2 rounded-circle" style="background: rgba(16, 185, 129, 0.1); color: var(--success);">
                            <i class="bi bi-file-earmark-medical"></i>
                        </div>
                        <div>
                            <div class="fw-semibold" style="font-size: 0.85rem;">My Electronic Charts</div>
                            <div class="text-muted" style="font-size: 0.75rem;">View history, prescription files and invoice receipts.</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-circle" style="background: rgba(99, 102, 241, 0.1); color: var(--primary);">
                            <i class="bi bi-bell-fill"></i>
                        </div>
                        <div>
                            <div class="fw-semibold" style="font-size: 0.85rem;">Real-time Health Sync</div>
                            <div class="text-muted" style="font-size: 0.75rem;">Get notifications for new reports or scheduler shifts.</div>
                        </div>
                    </div>
                </div>

                <div class="text-muted" style="font-size: 0.75rem;">
                    &copy; 2026 AuraHMS Technologies. All rights reserved.
                </div>
            </div>

            <!-- Right Form Panel -->
            <div class="auth-form-side">
                
                <!-- 1. LOGIN PANEL -->
                <div class="auth-form-panel {{ !old('name') ? 'active' : '' }}" id="panel-login">
                    <h4 class="fw-bold mb-1">Patient Portal Login</h4>
                    <p class="text-muted mb-4" style="font-size: 0.9rem;">Sign in to view appointments, reports, and wellness metrics.</p>
                    
                    <form action="{{ url('patient/login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label-custom">Email Address</label>
                            <div class="position-relative">
                                <i class="bi bi-envelope position-absolute text-muted" style="left: 1rem; top: 50%; transform: translateY(-50%);"></i>
                                <input type="email" class="form-control form-glass ps-5" name="email" placeholder="eleanor.vance@gmail.com" required value="{{ old('email', 'eleanor.vance@gmail.com') }}">
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <label class="form-label-custom mb-0">Password</label>
                                <a href="#" class="text-decoration-none text-primary" style="font-size: 0.8rem;" onclick="switchPanel('panel-forgot')">Forgot Password?</a>
                            </div>
                            <div class="position-relative">
                                <i class="bi bi-lock position-absolute text-muted" style="left: 1rem; top: 50%; transform: translateY(-50%);"></i>
                                <input type="password" class="form-control form-glass ps-5" name="password" placeholder="••••••••" required value="password123">
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="rememberMe" checked>
                                <label class="form-check-label text-muted" style="font-size: 0.85rem;" for="rememberMe">Remember this browser</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-premium w-100 mb-3">Sign In Dashboard</button>
                        <a href="/" class="btn btn-premium-outline w-100 mb-3"><i class="bi bi-arrow-left me-2"></i>Return to Portal Selection</a>
                        
                        <div class="text-center text-muted" style="font-size: 0.85rem;">
                            First time here? <a href="#" class="text-primary text-decoration-none" onclick="switchPanel('panel-register')">Register Patient Account</a>
                        </div>
                    </form>
                </div>

                <!-- 2. REGISTER PANEL -->
                <div class="auth-form-panel {{ old('name') ? 'active' : '' }}" id="panel-register">
                    <h4 class="fw-bold mb-1">Register Patient Account</h4>
                    <p class="text-muted mb-3" style="font-size: 0.9rem;">Join the AuraHMS patient wellness platform.</p>
                    
                    <form action="{{ route('patient.register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label-custom">Full Name</label>
                            <input type="text" class="form-control form-glass" name="name" placeholder="Eleanor Vance" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">Age</label>
                                <input type="number" class="form-control form-glass" name="age" placeholder="e.g. 28" id="registerAge" value="{{ old('age', 28) }}" required>
                                @error('age')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">Gender</label>
                                <select class="form-select form-glass" name="gender" required>
                                    <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', 'Female') === 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender') === 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">Blood Group</label>
                                <input type="text" class="form-control form-glass" name="blood_group" placeholder="e.g. O+" id="registerBlood" value="{{ old('blood_group', 'O+') }}" required>
                                @error('blood_group')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label-custom">Email Address</label>
                                <input type="email" class="form-control form-glass" name="email" placeholder="eleanor.vance@gmail.com" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom">Create Secure Password</label>
                            <input type="password" class="form-control form-glass" name="password" placeholder="••••••••" required>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="agreeTerms" required checked>
                            <label class="form-check-label text-muted" style="font-size: 0.8rem;" for="agreeTerms">I agree to patient user agreement & privacy policies.</label>
                        </div>

                        <button type="submit" class="btn btn-premium w-100 mb-3">Create System Account</button>
                        
                        <div class="text-center text-muted" style="font-size: 0.85rem;">
                            Already registered? <a href="#" class="text-primary text-decoration-none" onclick="switchPanel('panel-login')">Sign In</a>
                        </div>
                    </form>
                </div>

                <!-- 3. FORGOT PASSWORD PANEL -->
                <div class="auth-form-panel" id="panel-forgot">
                    <h4 class="fw-bold mb-1">Recover Patient Credentials</h4>
                    <p class="text-muted mb-4" style="font-size: 0.9rem;">Resetting passwords requires email verification security.</p>
                    
                    <form onsubmit="event.preventDefault(); switchPanel('panel-otp');">
                        <div class="mb-4">
                            <label class="form-label-custom">Associated Patient Email</label>
                            <input type="email" class="form-control form-glass" placeholder="patient@aurahms.com" required value="eleanor.vance@gmail.com">
                        </div>
                        <button type="submit" class="btn btn-premium w-100 mb-3">Send Recovery Code</button>
                        <button type="button" class="btn btn-premium-outline w-100" onclick="switchPanel('panel-login')">Back to Login</button>
                    </form>
                </div>

                <!-- 4. OTP VERIFICATION PANEL -->
                <div class="auth-form-panel" id="panel-otp">
                    <h4 class="fw-bold mb-1">OTP Authentication</h4>
                    <p class="text-muted mb-3" style="font-size: 0.9rem;">We sent a 6-digit confirmation key to your device.</p>
                    
                    <form onsubmit="event.preventDefault(); switchPanel('panel-reset');">
                        <div class="d-flex gap-2 justify-content-between mb-4">
                            <input type="text" class="form-control form-glass text-center fs-4 fw-bold" style="width: 50px; height: 50px;" maxlength="1" required>
                            <input type="text" class="form-control form-glass text-center fs-4 fw-bold" style="width: 50px; height: 50px;" maxlength="1" required>
                            <input type="text" class="form-control form-glass text-center fs-4 fw-bold" style="width: 50px; height: 50px;" maxlength="1" required>
                            <input type="text" class="form-control form-glass text-center fs-4 fw-bold" style="width: 50px; height: 50px;" maxlength="1" required>
                            <input type="text" class="form-control form-glass text-center fs-4 fw-bold" style="width: 50px; height: 50px;" maxlength="1" required>
                            <input type="text" class="form-control form-glass text-center fs-4 fw-bold" style="width: 50px; height: 50px;" maxlength="1" required>
                        </div>
                        <button type="submit" class="btn btn-premium w-100 mb-3">Verify System Key</button>
                        <div class="text-center text-muted" style="font-size: 0.85rem;">
                            Didn't receive verification? <a href="#" class="text-primary text-decoration-none">Resend Code</a>
                        </div>
                    </form>
                </div>

                <!-- 5. RESET PASSWORD PANEL -->
                <div class="auth-form-panel" id="panel-reset">
                    <h4 class="fw-bold mb-1">Configure New Password</h4>
                    <p class="text-muted mb-4" style="font-size: 0.9rem;">Set a brand new access key.</p>
                    
                    <form onsubmit="event.preventDefault(); switchPanel('panel-change');">
                        <div class="mb-3">
                            <label class="form-label-custom">New Password</label>
                            <input type="password" class="form-control form-glass" placeholder="••••••••" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label-custom">Confirm Password</label>
                            <input type="password" class="form-control form-glass" placeholder="••••••••" required>
                        </div>
                        <button type="submit" class="btn btn-premium w-100">Update Credentials</button>
                    </form>
                </div>

                <!-- 6. CHANGE PASSWORD SUCCESS PANEL -->
                <div class="auth-form-panel text-center" id="panel-change">
                    <div class="mb-4 text-success" style="font-size: 4rem;">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Password Restored Successfully</h4>
                    <p class="text-muted mb-4" style="font-size: 0.95rem;">Security log registers updating credential profiles.</p>
                    <button class="btn btn-premium w-100" onclick="switchPanel('panel-login')">Proceed to Login</button>
                </div>

                <!-- 7. EMAIL VERIFICATION PANEL -->
                <div class="auth-form-panel text-center" id="panel-email-verify">
                    <div class="mb-4 text-info" style="font-size: 4rem;">
                        <i class="bi bi-envelope-check-fill"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Verify Account Email</h4>
                    <p class="text-muted mb-4" style="font-size: 0.95rem;">An activation link was dispatched to your inbox directory. Check verification status here.</p>
                    <button class="btn btn-premium w-100 mb-3" onclick="switchPanel('panel-login')">Confirm Verification & Continue</button>
                    <div class="text-muted" style="font-size: 0.85rem;">
                        Incorrect email? <a href="#" class="text-primary text-decoration-none" onclick="switchPanel('panel-register')">Change Address</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Main JS -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        function switchPanel(panelId) {
            const panels = document.querySelectorAll('.auth-form-panel');
            panels.forEach(p => p.classList.remove('active'));
            
            const targetPanel = document.getElementById(panelId);
            if (targetPanel) {
                targetPanel.classList.add('active');
            }
        }

        function handleLogin(event) {
            event.preventDefault();
            window.location.href = '/patient/dashboard';
        }
    </script>
</body>
</html>


