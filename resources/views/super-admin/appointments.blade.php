<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraHMS - Appointments Module</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .calendar-day-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            text-align: center;
        }

        .calendar-header-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            text-align: center;
            font-weight: 600;
            color: var(--text-muted);
            font-size: 0.8rem;
            margin-bottom: 0.5rem;
        }

        .calendar-cell {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all var(--transition-speed);
            border: 1px solid transparent;
            color: var(--text-secondary);
        }

        .calendar-cell:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--border-color);
        }

        .calendar-cell.active {
            background: var(--primary);
            color: #fff !important;
            font-weight: 600;
        }

        .calendar-cell.has-appointment {
            color: var(--text-primary);
            font-weight: 600;
            position: relative;
        }

        .calendar-cell.has-appointment::after {
            content: '';
            position: absolute;
            bottom: 4px;
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: var(--secondary);
        }

        .token-card {
            border: 2px dashed var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.01);
            position: relative;
        }

        .token-card::before,
        .token-card::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background: var(--body-bg);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
        }

        .token-card::before {
            left: -11px;
        }

        .token-card::after {
            right: -11px;
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
                                <li class="breadcrumb-item-custom">Appointments</li>
                            </ul>
                        </nav>
                        <h4 class="fw-bold mb-0">Appointments Planner</h4>
                    </div>
                </div>

                <!-- SKELETON LOADER -->
                <div class="skeleton-wrapper row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="glass-card skeleton" style="height: 300px;"></div>
                    </div>
                    <div class="col-md-8">
                        <div class="glass-card skeleton" style="height: 500px;"></div>
                    </div>
                </div>

                <!-- REAL CONTENT WRAPPER -->
                <div class="real-content-wrapper">

                    <div class="row g-4">
                        
                        <!-- RIGHT COLUMN: APPOINTMENT DIRECTORY -->
                        <div class="col-xl-12">
                            <div class="glass-card">
                                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                                    <h5 class="mb-0"> Appointment Log</h5>
                                    <form action="{{route('super-admin.appointments')}}" method="GET" class="d-flex gap-2">
                                         <select name="status" class="form-select form-glass w-auto" onchange="this.form.submit()">
                                        <option value="">All Status</option>
                                        <option value="Pending" {{request('status')=='Pending' ? 'selected':''}}>Pending</option>
                                        <option value="Confirmed" {{request('status')=='Confirmed' ? 'selected':''}}>Confirmed</option>
                                        <option value="Completed" {{request('status')=='Completed' ? 'selected':''}}>Completed</option>
                                        <option value="Cancelled" {{request('status')=='Cancelled' ? 'selected':''}}>Cancelled</option>
                                         </select>
                                        <input type="text" name="search" class="form-control form-glass py-1 px-3" value="{{request('search')}}"
                                             placeholder="Search appointments...">
                                        <button class="btn btn-premium btn-sm" type="submit">Filter</button>
                                    </form>
                                </div>

                                <div class="custom-table-container">
                                    <table class="custom-table">
                                        <thead>
                                            <tr>
                                                <th>Token ID</th>
                                                <th>Patient Name</th>
                                                <th>Doctor</th>
                                                <th>Department</th>
                                                <th>Appointment Date</th>
                                                <th>Status</th>
                                                <th class="text-end">Update Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($appointments as $app)
                                            <tr>
                                                <td><span class="badge bg-primary rounded-pill px-3 py-1">Token
                                                        #{{$app->token_number ?? $app->id}}</span></td>
                                                <td>
                                                    <div class="fw-semibold">{{$app->patient->user->name ?? 'NA'}}</div>
                                                    <small class="text-muted">{{$app->consultation_type}}</small>
                                                </td>
                                                <td>{{$app->doctor->user->name ?? 'NA'}}</td>
                                                <td>{{$app->appointment_date ? $app->appointment_date->format('Y-m-d H:i') : 'NA'}}</td>
                                                <td>
                                                    @if($app->status==='Completed')
                                                    <span class="custom-badge badge-success"><i
                                                            class="bi bi-check-circle"></i> Completed</span>
                                                        @elseif($app->status==='Pending')
                                                        <span class="custom-badge badge-warning"><i
                                                            class="bi bi-hourglass"></i> Pending</span>
                                                            @elseif($app->status==='Confirmed')
                                                            <span class="custom-badge badge-info"><i
                                                            class="bi bi-clock"></i> Confirmed</span>
                                                           @else
                                                              <span class="custom-badge badge-danger"><i
                                                                class="bi bi-x-circle"></i> Cancelled</span>
                                                            @endif
                                                        </td>

                                                <td class="text-end">
                                                    <form action="{{route('super-admin.appointments.status',$app->id)}}" method="post" class="d-inline-flex align-items-center gap-1">
                                                        @csrf
                                                        <select name="status" class="form-select form-glass form-select-sm py-1 px-2" style="font-size: :0.8rem;">
                                                            <option value="Pending" {{$app->status==='Pending' ? 'selected':''}}>Pending</option>
                                                            <option value="Confirmed" {{$app->status==='Confirmed' ? 'selected':''}}>Confirmed</option>
                                                            <option value="Completed" {{$app->status==='Completed' ? 'selected':''}}>Completed</option>
                                                            <option value="Cancelled" {{$app->status==='Cancelled' ? 'selected':''}}>Cancelled</option>
                                                        </select>
                                                        <button type="submit" class="btn btn-sm btn-premium py-1 px-2">
                                                            <i class="bi bi-check-lg"></i></button>
                                                    </form>

                                                </td>
                                            </tr>
                                            <tr>
                                                @empty
                                                <td colspan="7" class="text-center text-muted">
                                                    <i class="bi bi-exclamation-circle me-2"></i> No appointments found.
                                                </td>
                                            </tr>
                                            @endforelse
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </main>
    </div>

    <!-- MODAL: QUEUE SLIP / TOKEN PRINT MODAL -->
    <div class="modal fade modal-glass" id="tokenSlipModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
            <div class="modal-content">
                <div class="modal-header border-light border-opacity-10">
                    <h5 class="modal-title fw-bold">Appointment Queue Ticket</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="token-card mb-4 text-start">
                        <div class="text-center mb-3">
                            <h4 class="fw-bold mb-1">AuraHMS Clinic Slip</h4>
                            <span class="text-muted small">Token ID: #AURA-2026-0042</span>
                        </div>
                        <div class="border-top border-light border-opacity-10 py-3 text-center my-3">
                            <div class="text-muted" style="font-size: 0.85rem;">YOUR QUEUE POSITION:</div>
                            <h1 class="fw-bold text-primary mb-0 mt-1">Queue #14</h1>
                        </div>
                        <div style="font-size: 0.85rem;" class="d-flex flex-column gap-2 text-white text-opacity-80">
                            <div class="d-flex justify-content-between"><span>Patient:</span> <span
                                    class="fw-semibold text-white">Michael Corleone</span></div>
                            <div class="d-flex justify-content-between"><span>Doctor:</span> <span
                                    class="fw-semibold text-white">Dr. John Carter</span></div>
                            <div class="d-flex justify-content-between"><span>Department:</span> <span
                                    class="fw-semibold text-white">Pediatrics Division</span></div>
                            <div class="d-flex justify-content-between"><span>Timing slot:</span> <span
                                    class="fw-semibold text-white">10:45 AM (Today)</span></div>
                        </div>
                        <div class="text-center mt-4">
                            <div class="p-3 bg-white d-inline-block rounded-3 shadow-sm">
                                <i class="bi bi-qr-code" style="font-size: 3.5rem; color: #000;"></i>
                            </div>
                            <div class="text-muted mt-2" style="font-size: 0.7rem;">Scan at department waiting room
                                entrance.</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-light border-opacity-10">
                    <button class="btn btn-premium-outline w-100 mb-2" onclick="window.print()"><i
                            class="bi bi-printer"></i> Print Token Slip</button>
                    <button class="btn btn-premium w-100" data-bs-dismiss="modal">Close Ticket View</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Main JS -->
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>