<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraHMS - Doctor Console</title>
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

        @include('doctor.sidebar')

        <!-- MAIN WRAPPER -->
        <main class="main-wrapper">

            @include('doctor.header')

            <!-- CONTENT BODY -->
            <div class="content-body">

                <!-- BREADCRUMB -->
                <nav>
                    <ul class="breadcrumb-custom">
                        <li class="breadcrumb-item-custom"><a href="#">Home</a></li>
                        <li class="breadcrumb-item-custom">Doctor Console</li>
                    </ul>
                </nav>

                <!-- SKELETON LOADER PLACEHOLDER -->
                <div class="skeleton-wrapper row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="glass-card skeleton" style="height: 120px;"></div>
                    </div>
                    <div class="col-md-3">
                        <div class="glass-card skeleton" style="height: 120px;"></div>
                    </div>
                    <div class="col-md-3">
                        <div class="glass-card skeleton" style="height: 120px;"></div>
                    </div>
                    <div class="col-md-3">
                        <div class="glass-card skeleton" style="height: 120px;"></div>
                    </div>
                </div>

                <!-- REAL CONTENT WRAPPER -->
                <div class="real-content-wrapper d-none">

                    <!-- STATISTICS CARDS -->
                    <div class="row g-4 mb-4">
                        <div class="col-xl-3 col-md-6">
                            <div class="glass-card glass-card-hover stat-card">
                                <span class="text-muted fw-semibold" style="font-size: 0.85rem;">TODAY'S
                                    CONSULTATIONS</span>
                                <h3 class="fw-bold mt-2 mb-1">{{$todayConsultationCount}}</h3>
                                <div class="stat-card-trend bg-success-bg text-success mt-1">
                                    <i class="bi bi-check-circle-fill"></i> {{$todayCompletedCount}}
                                </div>
                                <div class="stat-card-icon text-primary"><i class="bi bi-calendar-check"></i></div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="glass-card glass-card-hover stat-card">
                                <span class="text-muted fw-semibold" style="font-size: 0.85rem;">MY TOTAL ASSIGNED
                                    PATIENTS</span>
                                <h3 class="fw-bold mt-2 mb-1">{{$totalPatientsCount}}</h3>
                                <div class="stat-card-trend bg-info-bg text-info mt-1">
                                    <i class="bi bi-people-fill"></i> Active case charts
                                </div>
                                <div class="stat-card-icon text-success"><i class="bi bi-person-fill-lock"></i></div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="glass-card glass-card-hover stat-card">
                                <span class="text-muted fw-semibold" style="font-size: 0.85rem;">PENDING
                                    DIAGNOSES</span>
                                <h3 class="fw-bold mt-2 mb-1 text-warning">{{$pendingDiagnosesCount}}</h3>
                                <div class="stat-card-trend bg-warning-bg text-warning mt-1">
                                    <i class="bi bi-pencil-square"></i> Require prescriptions
                                </div>
                                <div class="stat-card-icon text-warning"><i class="bi bi-clipboard2-pulse"></i></div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="glass-card glass-card-hover stat-card">
                                <span class="text-muted fw-semibold" style="font-size: 0.85rem;">EMERGENCY ER
                                    CALLS</span>
                                <h3 class="fw-bold mt-2 mb-1 text-danger">{{$emegencyCallsCount}}</h3>
                                <div class="stat-card-trend bg-danger-bg text-danger mt-1">
                                    <i class="bi bi-heart-pulse-fill {{$emegencyCallsCount > 0 ? 'animate-pulse' : ''}} "></i> Active cardiology alert
                                </div>
                                <div class="stat-card-icon text-danger"><i class="bi bi-activity"></i></div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <!-- ACTIVE CONSULT QUEUE -->
                        <div class="col-lg-8">
                            <div class="glass-card h-100">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div>
                                        <h5 class="mb-1 fw-bold">Active Patient Consultation Queue</h5>
                                        <p class="text-muted mb-0 small">Only showing patients registered under {{$user->name}} today.</p>
                                    </div>
                                    <button class="btn btn-premium btn-sm"
                                        onclick="window.location.reload()">
                                        <i class="bi bi-arrow-clockwise"></i> Sync Queue
                                    </button>
                                </div>

                                <div class="custom-table-container">
                                    <table class="custom-table">
                                        <thead>
                                            <tr>
                                                <th>Queue No.</th>
                                                <th>Patient Name</th>
                                                <th>Scheduled Slot</th>
                                                <th>Clinical Reason</th>
                                                <th>Status</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($queueAppointmets as $appt)
                                            
                                            <tr>
                                                <td><span class="fw-bold">Q-{{sprintf('%02d',$appt->token_number)}}</span></td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <img src="{{asset('uploads/profile/'.$appt->patient->profile)}}"
                                                            alt="Patient" class="rounded-circle"
                                                            style="width: 32px; height: 32px; object-fit: cover;">
                                                        <div class="fw-semibold">{{$appt->patient->user->name}}</div>
                                                    </div>
                                                </td>
                                                <td>{{$appt->appointment_date->format('h:i A')}}</td>
                                                <td>{{$appt->symptoms}}</td>
                                                <td>
                                                    @if($appt->status==='Completed')
                                                    <span class="custom-badge badge-success">Completed</span>
                                                    @elseif($appt->status==='Checked In')
                                                    <span class="custom-badge badge-success">Checked In</span>
                                                    @else
                                                    <span class="custom-badge badge-warning">{{$appt->status}}</span>
                                                    @endif
                                                </td>
                                                 <td class="text-end">

                                                     @if($appt->status!=="Completed")
                                                       <button class="btn btn-premium btn-sm btn-start-consult"

                                                       data-appt-id="{{$appt->id}}"
                                                       data-patient-id="{{$appt->patient->id}}"
                                                       data-patient-name="{{$appt->patient->user->name}}"
                                                       data-patient-age="{{$appt->patient->age}}"
                                                       data-patient-gender="{{$appt->patient->gender}}"
                                                       data-patient-blood="{{$appt->patient->blood_group}}"
                                                       data-patient-allergies="{{$appt->patient->disease ?? 'None'}}"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#consultationModal">Start Consult</button>
                                                    @else
                                                       <button class="btn btn-premium-outline btn-sm" disabled>Completed</button>
                                                    @endif
                                                 </td>
                                            </tr>
                                             @empty
                                             <tr>
                                            <td class="text-center text-muted py-4" colspan="6">No active patient</td>
                                             </tr>
                                             @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- CLINICAL BULLETIN & ANNOUNCEMENTS -->
                        <div class="col-lg-4">
                            <div class="glass-card h-100">
                                <h5 class="mb-4 fw-bold">Clinical Notifications</h5>
                                <div class="timeline-custom">
                                    <div class="timeline-item success">
                                        <div class="fw-bold" style="font-size: 0.85rem;">Laboratory Pathology Update
                                        </div>
                                        <small class="text-muted d-block mb-1">Blood test report synced for patient
                                            Eleanor Vance.</small>
                                        <span style="font-size: 0.75rem; color: var(--text-muted);">10 mins ago</span>
                                    </div>
                                    <div class="timeline-item warning">
                                        <div class="fw-bold" style="font-size: 0.85rem;">ER Call Intake Alert</div>
                                        <small class="text-muted d-block mb-1">Cardiac distress admission arriving in ER
                                            Bay 3 in 5 mins.</small>
                                        <span style="font-size: 0.75rem; color: var(--text-muted);">30 mins ago</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </main>
    </div>

    <!-- MODAL: ACTIVE CLINICAL CONSULTATION & PRESCRIPTION ISSUANCE -->
    <div class="modal fade modal-glass" id="consultationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header border-light border-opacity-10">
                    <h5 class="modal-title fw-bold" id="modal-patient-name">Consultation Portal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{route('doctor.consultation.store')}}" method="post">
                    @csrf
                    <input type="hidden" name="appointment_id" id="modal-appointment-id-input">
                    <div class="modal-body">
                        <div class="p-3 mb-4 rounded-4 border border-light border-opacity-10"
                            style="background: rgba(255, 255, 255, 0.02);">
                            <div class="row text-white text-opacity-80">
                                <div class="col-md-6 mb-2">Patient ID: <span class="fw-bold text-white" id="modal-patient-id-display">#PT-1082</span>
                                </div>
                                <div class="col-md-6 mb-2">Age / Blood Group: <span class="fw-bold text-white" id="modal-patient-age-display">28,
                                        Female / O+</span></div>
                                <div class="col-md-12">Allergies: <span class="fw-bold text-danger" id="modal-patient-allergies-display">Penicillin
                                        (Severe)</span></div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label-custom">Clinical Findings & Diagnosis Summary</label>
                                <textarea name="diagnosis" class="form-control form-glass" rows="3"
                                    placeholder="Describe symptoms, vital measurements, cardiac pulse rate, and diagnoses..."
                                    required></textarea>
                            </div>
                            <div class="col-md-12">
                                <h6 class="fw-bold text-primary my-2">Issued Prescriptions</h6>
                                <div class="glass-sub-card p-3 rounded-4 mb-3" id="prescriptions-container">
                                    <div class="row g-2 mb-2 align-items-center prescription-row">
                                        <div class="col-md-5">
                                            <label class="form-label-custom small">Medicine Name</label>
                                            <input type="text" class="form-control form-glass py-1"
                                                value="Ivabradine 5mg Tablets" name="medicines[0][name]" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label-custom small">Dosage / Frequency</label>
                                            <input type="text" class="form-control form-glass py-1" name="medicines[0][dosage]"   value="1-0-1 (BID)"
                                                required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label-custom small">Duration</label>
                                            <input type="text" class="form-control form-glass py-1" name="medicines[0][duration]"  value="14 Days"
                                                required>
                                        </div>
                                        <div class="col-md-1 text-end mt-4">
                                            <button class="btn btn-sm text-danger p-0 remove-medicine-btn" type="button"><i
                                                    class="bi bi-trash-fill"></i></button>
                                        </div>
                                    </div>
                                    <button class="btn btn-premium-outline btn-sm py-1 px-3 mt-2" type="button" id="add-medicine-btn">+Add Medicine</button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label-custom">Special Directives for Patient / Pharmacy
                                    instructions</label>
                                <textarea name="directives" class="form-control form-glass" rows="2"
                                    placeholder="Take tablets after meals. Watch for cardiac slowing symptoms..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-light border-opacity-10">
                        <button type="button" class="btn btn-premium-outline" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-premium">Publish Consultation Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- ApexCharts JS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- Custom Main JS -->
    <script src="{{ asset('js/script.js') }}"></script>

    <!-- Custom Page logic -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Click handler to load data into the consultation modal
            const consultButtons = document.querySelectorAll('.btn-start-consult');
            consultButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const apptId = this.getAttribute('data-appt-id');
                    const patientId = this.getAttribute('data-patient-id');
                    const patientName = this.getAttribute('data-patient-name');
                    const patientAge = this.getAttribute('data-patient-age');
                    const patientGender = this.getAttribute('data-patient-gender');
                    const patientBlood = this.getAttribute('data-patient-blood');
                    const patientAllergies = this.getAttribute('data-patient-allergies');
                    
                    document.getElementById('modal-patient-name').innerText = 'Consultation Portal: ' + patientName;
                    document.getElementById('modal-patient-id-display').innerText = '#PT-' + patientId;
                    document.getElementById('modal-patient-age-display').innerText = patientAge + ', ' + patientGender + ' / ' + patientBlood;
                    document.getElementById('modal-patient-allergies-display').innerText = patientAllergies;
                    document.getElementById('modal-appointment-id-input').value = apptId;
                });
            });

            // Add new medicine field logic
            let medicineIndex = 1;
            document.getElementById('add-medicine-btn').addEventListener('click', function() {
                const container = document.getElementById('prescriptions-container');
                const row = document.createElement('div');
                row.className = 'row g-2 mb-2 align-items-center prescription-row';
                row.innerHTML = `
                    <div class="col-md-5">
                        <label class="form-label-custom small">Medicine Name</label>
                        <input type="text" name="medicines[${medicineIndex}][name]" class="form-control form-glass py-1" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label-custom small">Dosage / Frequency</label>
                        <input type="text" name="medicines[${medicineIndex}][dosage]" class="form-control form-glass py-1" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label-custom small">Duration</label>
                        <input type="text" name="medicines[${medicineIndex}][duration]" class="form-control form-glass py-1" required>
                    </div>
                    <div class="col-md-1 text-end mt-4">
                        <button class="btn btn-sm text-danger p-0 remove-medicine-btn" type="button"><i class="bi bi-trash-fill"></i></button>
                    </div>
                `;
                container.appendChild(row);
                medicineIndex++;
                
                // Add event listener to the remove button in this row
                row.querySelector('.remove-medicine-btn').addEventListener('click', function() {
                    row.remove();
                });
            });

            // Bind existing remove button logic
            document.querySelectorAll('.remove-medicine-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const row = btn.closest('.prescription-row');
                    // Check if it's the only row, if so don't remove or just remove
                    row.remove();
                });
            });
        });
    </script>

    <!-- Session Toasts -->
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                showToast('Success', "{{ session('success') }}", 'success');
            });
        </script>
    @endif
    @if($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                showToast('Error', "{{ $errors->first() }}", 'danger');
            });
        </script>
    @endif
</body>


</html>