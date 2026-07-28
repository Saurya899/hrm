<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraHMS - Unified Portal Hub</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <style>
        .portal-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 1.5rem;
            position: relative;
            z-index: 10;
        }
        .portal-header {
            text-align: center;
            max-width: 600px;
            margin-bottom: 3.5rem;
            animation: fadeInDown 0.6s ease-out;
        }
        .portal-grid {
            width: 100%;
            max-width: 1100px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            animation: fadeInUp 0.8s ease-out;
        }
        .portal-card {
            background: var(--card-bg);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 3rem 2rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }
        .portal-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            transition: all 0.4s ease;
        }
        /* Role Specific Accents */
        .portal-card.super-admin::before {
            background: linear-gradient(90deg, #ef4444, #6366f1);
        }
        .portal-card.doctor::before {
            background: linear-gradient(90deg, #06b6d4, #6366f1);
        }
        .portal-card.patient::before {
            background: linear-gradient(90deg, #10b981, #6366f1);
        }

        .portal-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.4);
            border-color: var(--border-hover-color);
            background: var(--card-hover-bg);
        }

        .portal-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.25rem;
            color: white;
            margin-bottom: 2rem;
            transition: transform 0.4s ease;
        }
        .portal-card:hover .portal-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .portal-card.super-admin .portal-icon {
            background: linear-gradient(135deg, #ef4444 0%, #6366f1 100%);
            box-shadow: 0 10px 20px rgba(239, 68, 68, 0.25);
        }
        .portal-card.doctor .portal-icon {
            background: linear-gradient(135deg, #06b6d4 0%, #6366f1 100%);
            box-shadow: 0 10px 20px rgba(6, 182, 212, 0.25);
        }
        .portal-card.patient .portal-icon {
            background: linear-gradient(135deg, #10b981 0%, #6366f1 100%);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.25);
        }

        .pulse-logo {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.8rem;
            box-shadow: 0 0 25px rgba(99, 102, 241, 0.4);
            animation: heartPulse 2s infinite;
            margin: 0 auto 1.5rem auto;
        }

        @keyframes heartPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.08); }
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 992px) {
            .portal-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                max-width: 450px;
            }
            .portal-card {
                padding: 2.5rem 1.5rem;
            }
        }
    </style>
</head>
<body>

    <!-- Page Loader -->
    <div class="page-loader" id="page-loader">
        <div class="loader-spinner"></div>
    </div>

    <!-- Decorative Glow Elements -->
    <div style="position: absolute; top: -10%; left: -10%; width: 45%; height: 45%; background: radial-gradient(circle, rgba(99,102,241,0.12) 0%, transparent 70%); filter: blur(60px); pointer-events: none; z-index: 1;"></div>
    <div style="position: absolute; bottom: -10%; right: -10%; width: 45%; height: 45%; background: radial-gradient(circle, rgba(6,182,212,0.12) 0%, transparent 70%); filter: blur(60px); pointer-events: none; z-index: 1;"></div>

    <div class="portal-container">
        
        <!-- Header Section -->
        <div class="portal-header">
            <div class="pulse-logo">
                <i class="bi bi-heart-pulse-fill"></i>
            </div>
            <h1 class="fw-bold mb-2">Welcome to AuraHMS</h1>
            <p class="text-muted" style="font-size: 1.05rem;">Select your dedicated portal below to access dashboard operations, medical rosters, or patient electronic charts.</p>
        </div>

        <!-- Role Selection Grid -->
        <div class="portal-grid">
            
            <!-- Super Admin Portal -->
            <div class="portal-card super-admin">
                <div class="d-flex flex-column align-items-center">
                    <div class="portal-icon">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                    <h3 class="fw-bold fs-4 mb-3">Super Admin</h3>
                    <p class="text-muted" style="font-size: 0.9rem; line-height: 1.5;">Manage hospital systems, configure payroll roster variables, inspect system audit logs, and oversee entire data models.</p>
                </div>
                <div class="w-100 mt-4">
                    <a href="/super-admin/login" class="btn btn-premium w-100">Access Admin Console</a>
                </div>
            </div>

            <!-- Doctor Portal -->
            <div class="portal-card doctor">
                <div class="d-flex flex-column align-items-center">
                    <div class="portal-icon">
                        <i class="bi bi-heart-pulse-fill"></i>
                    </div>
                    <h3 class="fw-bold fs-4 mb-3">Medical Doctor</h3>
                    <p class="text-muted" style="font-size: 0.9rem; line-height: 1.5;">Access diagnostic tools, update digital EHR charts, control calendar shifts, and coordinate active appointments.</p>
                </div>
                <div class="w-100 mt-4">
                    <a href="/doctor/login" class="btn btn-premium w-100">Access Clinical Console</a>
                </div>
            </div>

            <!-- Patient Portal -->
            <div class="portal-card patient">
                <div class="d-flex flex-column align-items-center">
                    <div class="portal-icon">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <h3 class="fw-bold fs-4 mb-3">Patient Portal</h3>
                    <p class="text-muted" style="font-size: 0.9rem; line-height: 1.5;">Schedule new checkups, download clinical test files, inspect prescription history, and check billing invoices.</p>
                </div>
                <div class="w-100 mt-4">
                    <a href="/patient/login" class="btn btn-premium w-100">Access Patient Portal</a>
                </div>
            </div>

        </div>

        <div class="text-center text-muted mt-5" style="font-size: 0.8rem; z-index: 10;">
            &copy; 2026 AuraHMS Technologies. All rights reserved. Registered HIPAA Compliant Medical Platform.
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Main JS -->
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>

