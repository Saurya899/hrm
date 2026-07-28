<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraHMS - My Appointments</title>
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

        @include('patient.sidebar')
        <!-- MAIN WRAPPER -->
        <main class="main-wrapper">

            <!-- TOP NAVBAR -->
            <header class="top-navbar">
                <div class="navbar-left">
                    <button class="sidebar-toggle-btn" id="sidebar-toggle">
                        <i class="bi bi-justify"></i>
                    </button>
                    <span class="navbar-brand-name ms-2 d-none d-md-inline-block text-primary fw-bold">My
                        Appointments</span>
                </div>

                @include('patient.header')
            </header>

            <!-- CONTENT BODY -->
            <div class="content-body">

                <!-- BREADCRUMB -->
                <nav>
                    <ul class="breadcrumb-custom">
                        <li class="breadcrumb-item-custom"><a href="/patient/dashboard">Home</a></li>
                        <li class="breadcrumb-item-custom">My Appointments</li>
                    </ul>
                </nav>

                <!-- SKELETON LOADER -->
                <div class="skeleton-wrapper row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="glass-card skeleton" style="height: 300px;"></div>
                    </div>
                    <div class="col-md-8">
                        <div class="glass-card skeleton" style="height: 400px;"></div>
                    </div>
                </div>

                <!-- REAL CONTENT WRAPPER -->
                <div class="real-content-wrapper d-none">

                    <div class="row g-4">
                        <!-- LEFT COLUMN: BOOKING FORM & CALENDAR -->
                        <div class="col-xl-4">
                            @php
                           $today =now();
                           $firstDayOfMonth = now()->startOfMonth();
                           $daysInMonth= now()->daysInMonth();
                           $startOfWeek =$firstDayOfMonth->dayOfWeek;

                           $activeDays = $appointments->filter(function($app){
                            return $app->appointment_date->format('Y-m') === now()->format('Y-m');
                           })->pluck('appointment_date')->map(function($date){
                                    return (int)$date->format('d');
                           })->unique()->toArray();
                           
                            @endphp
                            <!-- MY CALENDAR -->
                            <div class="glass-card mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold mb-0">{{now()->format('F Y')}}</h6>
                                </div>
                                <div class="calendar-header-grid">
                                    <div>Su</div>
                                    <div>Mo</div>
                                    <div>Tu</div>
                                    <div>We</div>
                                    <div>Th</div>
                                    <div>Fr</div>
                                    <div>Sa</div>
                                </div>
                                <div class="calendar-day-grid">
                                    @for($i = 0; $i < $startOfWeek; $i++)
                                        <div class="calendar-cell text-muted">
                                        </div>
                                    @endfor
                                    @for($day=1; $day<=$daysInMonth; $day++)
                                    @php
                                        $hasApp= in_array($day,$activeDays);
                                        $isToday= ($day===(int)$today->format('d'));
                                    @endphp
                                        <div class="calendar-cell {{$hasApp ? 'has-appointment' : ''}} {{$isToday ? 'active' : ''}}">
                                            {{$day}}
                                        </div>
                                    @endfor
                                </div>
                            </div>
                           
                            <!-- PATIENT BOOKING FORM -->
                            <div class="glass-card">
                                <h6 class="fw-bold mb-4">Book New Appointment</h6>
                                  <!-- Alerts -->
                                    @if(session('success'))
                                        <div
                                            class="alert alert-success bg-success bg-opacity-10 border border-success border-opacity-20 text-success rounded-4 p-3 mb-4">
                                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                                        </div>
                                    @endif

                                    @if($errors->any())
                                        <div
                                            class="alert alert-danger bg-danger bg-opacity-10 border border-danger border-opacity-20 text-danger rounded-4 p-3 mb-4">
                                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Please correct the errors
                                            below.
                                            <ul class="mb-0 mt-2">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                <form action="{{route('patient.appointments.book')}}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label-custom">Select Department</label>
                                        <select class="form-select form-glass" id="department-select" required>
                                            <option disabled readonly>--Select Department--</option>
                                            @foreach ( $departments as $dept)
                                                 <option value="{{$dept}}">{{$dept}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label-custom">Select Doctor</label>
                                        <select class="form-select form-glass" name="doctor_id" id="doctor-select" required>
                                           <option disabled readonly>--Select Doctor--</option>
                                           @foreach ($doctors as $doctor )
                                               <option value="{{$doctor->id}}" data-department="{{$doctor->department}}">{{$doctor->user->name}}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label-custom">Select Date & Time</label>
                                        <input type="datetime-local" class="form-control form-glass" name="appointment_date" min="{{now()->format('Y-m-d\TH:i')}}" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label-custom">Describe Symptoms</label>
                                        <textarea class="form-control form-glass" rows="3" name="symptoms"
                                            placeholder="Briefly write about any chest pain, palpitation, etc."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-premium w-100">Book Slot</button>
                                </form>
                            </div>
                        </div>

                        <!-- RIGHT COLUMN: APPOINTMENTS DIRECTORY -->
                        <div class="col-xl-8">
                            <div class="glass-card">
                                <h5 class="fw-bold mb-4">My Appointments Log</h5>
                                @if(session('cancel_success'))
                                    <div class="alert alert-success bg-success bg-opacity-10 border border-success border-opacity-20 text-success rounded-4 p-3 mb-4">
                                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('cancel_success') }}
                                    </div>
                                @endif
                                @if(session('cancel_error'))
                                    <div class="alert alert-danger bg-danger bg-opacity-10 border border-danger border-opacity-20 text-danger rounded-4 p-3 mb-4">
                                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('cancel_error') }}
                                    </div>
                                @endif
                                <div class="custom-table-container">
                                    <table class="custom-table">
                                        <thead>
                                            <tr>
                                                <th>Doctor Name</th>
                                                <th>Department</th>
                                                <th>Appointment Time</th>
                                                <th>Consultation Type</th>
                                                <th>Status</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($appointments as $app)
                                        
                                            <tr>
                                                <td>
                                                    <div class="fw-semibold">{{$app->doctor->user->name}}</div>
                                                    <small class="text-muted">{{$app->doctor->license_id}}</small>
                                                </td>
                                                <td>{{$app->department}}</td>
                                                <td>{{$app->appointment_date->format('Y-m-d,H:i A')}}</td>
                                                <td>{{$app->consultation_type}}</td>

                                                <td>
                                                    @if($app->status ==='Completed')
                                                    <span class="custom-badge badge-success"><i
                                                            class="bi bi-check-circle"></i> Completed</span>
                                                        @elseif($app->status==='Cancelled')
                                                        <span class="custom-badge badge-danger"><i
                                                                class="bi bi-x-circle"></i> Cancelled</span>
                                                                @else
                                                                <span class="custom-badge badge-warning"><i
                                                                class="bi bi-clock"></i> Pending</span>
                                                                @endif
                                                        </td>
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end gap-2">
                                                        <button class="btn btn-sm btn-premium" data-bs-toggle="modal"
                                                            data-bs-target="#patientTokenModal">View Ticket</button>
                                                        @if($app->status === 'Pending')
                                                            <form action="{{ route('patient.appointments.cancel', $app->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this appointment?');" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-x-circle"></i> Cancel</button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">
                                                    <i class="bi bi-calendar-x" style="font-size: 2rem;"></i>
                                                    <div class="mt-2">No appointments found.</div>
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
    <div class="modal fade modal-glass" id="patientTokenModal" tabindex="-1" aria-hidden="true">
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
                            <h1 class="fw-bold text-primary mb-0 mt-1">Queue #12</h1>
                        </div>
                        <div style="font-size: 0.85rem;" class="d-flex flex-column gap-2 text-white text-opacity-80">
                            <div class="d-flex justify-content-between"><span>Patient:</span> <span
                                    class="fw-semibold text-white">Eleanor Vance</span></div>
                            <div class="d-flex justify-content-between"><span>Doctor:</span> <span
                                    class="fw-semibold text-white">Dr. Sarah Connor</span></div>
                            <div class="d-flex justify-content-between"><span>Department:</span> <span
                                    class="fw-semibold text-white">Cardiology</span></div>
                            <div class="d-flex justify-content-between"><span>Timing slot:</span> <span
                                    class="fw-semibold text-white">09:30 AM (Today)</span></div>
                        </div>
                        <!-- Mock QR Code -->
                        <div class="text-center mt-4">
                            <div class="p-3 bg-white d-inline-block rounded-3 shadow-sm">
                                <i class="bi bi-qr-code" style="font-size: 3.5rem; color: #000;"></i>
                            </div>
                            <div class="text-muted mt-2" style="font-size: 0.7rem;">Scan at Cardiology OPD waiting room.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-light border-opacity-10">
                    <button class="btn btn-premium-outline w-100 mb-2" onclick="window.print()"><i
                            class="bi bi-printer"></i> Print Slip</button>
                    <button class="btn btn-premium w-100" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Main JS -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    // Dynamic doctor select filter
    const deptSelect = document.getElementById('department-select');
    const docSelect = document.getElementById('doctor-select');
    const docOptions = Array.from(docSelect.options);

    deptSelect.addEventListener('change', function () {
        const selectedDept = this.value;

        // Clear doctor select and show prompt
        docSelect.innerHTML = '<option value="">Choose Doctor</option>';

        // Filter and append matching doctors
        docOptions.forEach(opt => {
            if (opt.value === "") return;
            if (!selectedDept || opt.getAttribute('data-department') === selectedDept) {
                docSelect.appendChild(opt.cloneNode(true));
            }
        });
    });
});
    </script>
</body>

</html>