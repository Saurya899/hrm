<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraHMS - Doctor Appointments</title>
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

                <!-- BREADCRUMB & HEADER -->
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <div>
                        <nav>
                            <ul class="breadcrumb-custom mb-1">
                                <li class="breadcrumb-item-custom"><a href="/doctor/dashboard">Home</a></li>
                                <li class="breadcrumb-item-custom">Appointments</li>
                            </ul>
                        </nav>
                        <h4 class="fw-bold mb-0">My Consult Appointments</h4>
                    </div>
                </div>

                <!-- SKELETON LOADER -->
                <div class="skeleton-wrapper row g-4 mb-4">
                    <div class="col-12">
                        <div class="glass-card skeleton" style="height: 350px;"></div>
                    </div>
                </div>

                <!-- REAL CONTENT WRAPPER -->
                <div class="real-content-wrapper d-none">

                    <!-- MY APPOINTMENTS LOG -->
                    <div class="glass-card">
                        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                            <h5 class="mb-0 fw-bold">Assigned Bookings Database</h5>
                            <form action="{{route('doctor.appoinments')}}" method="GET" class="d-flex gap-2">
                                <input type="text" name="search" class="form-control form-glass py-1 px-3" style="max-width: 200px;"
                                    placeholder="Filter by patient name..." value="{{request('search')}}">
                                <button class="btn btn-premium btn-sm">Filter</button>
                            </form>
                        </div>

                        <div class="custom-table-container">
                            <table class="custom-table">
                                <thead>
                                    <tr>
                                        <th>Token ID</th>
                                        <th>Patient Profile</th>
                                        <th>Consultation Department</th>
                                        <th>Timing slot</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($appointments as $app )
                                  
                                    <tr>
                                        <td><span class="badge bg-primary rounded-pill px-3 py-1">Token #{{$app->token_number}}</span></td>
                                        <td>
                                            <div class="fw-bold">{{$app->patient->user->name}}</div>
                                            <small class="text-muted">ID: #PT-{{$app->patient_id}}</small>
                                        </td>
                                        <td>{{$app->department}}</td>
                                        <td>{{$app->appointment_date->format('Y-m-d h:i A')}}</td>
                                        <td>
                                            @if($app->status==='Completed')
                                            <span class="custom-badge badge-success"><i class="bi bi-check-circle"></i>
                                                Completed</span>
                                            @else
                                              <span class="custom-badge badge-warning"><i class="bi bi-clock"></i>
                                                Pending</span>
                                                @endif
                                            </td>
                                        <td class="text-end">
                                            @if($app->status!=='Completed')
                                            <button class="btn btn-sm btn-premium btn-start-consult"
                                                       data-app-id="{{$app->id}}"
                                                       data-patient-id="{{$app->patient->id}}"
                                                       data-patient-name="{{$app->patient->user->name}}"
                                                       data-patient-age="{{$app->patient->age}}"
                                                       data-patient-gender="{{$app->patient->gender}}"
                                                       data-patient-blood="{{$app->patient->blood_group}}"
                                                       data-patient-allergies="{{$app->patient->disease ?? 'None'}}"
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

            </div>
        </main>
    </div>

    <!-- MODAL: CLINICAL CONSULTATION -->
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
                                            <input type="text" name="medicines[0][name] class="form-control form-glass py-1"
                                                value="Ivabradine 5mg Tablets" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label-custom small">Dosage / Frequency</label>
                                            <input type="text" name="medicines[0][dosage]" class="form-control form-glass py-1" value="1-0-1 (BID)"
                                                required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label-custom small">Duration</label>
                                            <input type="text" name="medicines[0][duration] class="form-control form-glass py-1" value="14 Days"
                                                required>
                                        </div>
                                        <div class="col-md-1 text-end mt-4">
                                            <button class="btn btn-sm text-danger p-0 remove-medicne-btn" type="button"><i
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
    <!-- Custom Main JS -->
    <script src="{{ asset('js/script.js') }}"></script>
    <!-- Custom Page Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Click handler to load data into the consultation modal
            const consultButtons = document.querySelectorAll('.btn-start-consult');
            consultButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const apptId = this.getAttribute('data-app-id');
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