<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraHMS - Doctor Patient Registry</title>
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
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                    <div>
                        <nav>
                            <ul class="breadcrumb-custom mb-1">
                                <li class="breadcrumb-item-custom"><a href="/doctor/dashboard">Home</a></li>
                                <li class="breadcrumb-item-custom">Patients</li>
                            </ul>
                        </nav>
                        <h4 class="fw-bold mb-0">Assigned Patient Registry</h4>
                    </div>
                </div>

                <!-- SKELETON LOADER -->
                <div class="skeleton-wrapper row g-4 mb-4">
                    <div class="col-12">
                        <div class="glass-card skeleton" style="height: 400px;"></div>
                    </div>
                </div>

                <!-- REAL CONTENT WRAPPER -->
                <div class="real-content-wrapper d-none">

                    <!-- SEARCH & FILTERS -->
                    <form action="{{route('doctor.patients')}}" method="GET" class="glass-card mb-4">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <div class="position-relative">
                                    <i class="bi bi-search position-absolute text-muted"
                                        style="left: 1rem; top: 50%; transform: translateY(-50%);"></i>
                                    <input type="text" name="search" class="form-control form-glass ps-5"
                                        placeholder="Search by name, patient ID, blood group..." value="{{request('search')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-premium w-100">Filter
                                    Search</button>
                            </div>
                        </div>
                    </form>

                    <!-- PATIENT REGISTER TABLE -->
                    <div class="glass-card">
                        <div class="custom-table-container">
                            <table class="custom-table">
                                <thead>
                                    <tr>
                                        <th>Patient ID</th>
                                        <th>Patient Details</th>
                                        <th>Contact Number</th>
                                        <th>Blood Group</th>
                                        <th>Last Visit Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($patients as $patient )
                                    <tr>
                                        <td><span class="fw-bold">#PT-{{$patient->id}}</span></td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{$patient->profile ? asset('uploads/profile/'.$patient->profile) : 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&q=80&w=100'}}"
                                                    alt="Patient" class="rounded-circle"
                                                    style="width: 36px; height: 36px; object-fit: cover;">
                                                <div>
                                                    <div class="fw-semibold">{{$patient->user->name}}</div>
                                                    <small class="text-muted">{{$patient->gender}}, {{$patient->age}} years</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{$patient->number ?? 'NA'}}</td>
                                        <td><span class="custom-badge badge-success">{{$patient->blood_group}}</span></td>
                                        <td>{{$patient->last_visit_date}}</td>
                                        <td>
                                            <button class="btn btn-premium btn-sm btn-view-ehr" 
                                             data-patient-id = "{{$patient->id}}"
                                             data-patient-name = "{{$patient->user->name}}"
                                             data-patient-age= "{{$patient->age}}"
                                             data-patient-gender = "{{$patient->gender}}"
                                             data-patient-profile = "{{$patient->profile ? asset('uploads/profile/'.$patient->profile) : 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&q=80&w=100'}}"
                                             data-documents = '@json($patient->labDocuments)'
                                             data-records = '@json($patient->medicalRecords)'
                                             data-bs-toggle="modal"
                                             data-bs-target="#patientDetailsModal">Medical Files</button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            No Patients Assigned to you matching the criteria</td>
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

    <!-- MODAL: CLINICAL EHR RECORDS VIEW -->
    <div class="modal fade modal-glass" id="patientDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header border-light border-opacity-10">
                    <h5 class="modal-title fw-bold" id="ehr-title">Electronic Health Record (EHR)</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <!-- Left Details Column -->
                        <div class="col-lg-4 border-end border-light border-opacity-10 pe-lg-4">
                            <div class="text-center mb-4">
                                <img src="" id="ehr-avatar"
                                    alt="Patient" class="rounded-circle mb-3 border border-light border-opacity-10"
                                    style="width: 110px; height: 110px; object-fit: cover;">
                                <h5 class="fw-bold mb-1" id="ehr-patient-name">Patient Name</h5>
                                <span class="custom-badge badge-success mb-2" id="ehr-patient-meta">Age: -- • Gender : --</span>
                            </div>

                            <h6 class="fw-bold text-primary mb-3">Diagnostic Documents</h6>
                            <div class="d-flex flex-column gap-2" id="ehr-documents-container">
                            </div>
                          </div>

                        <!-- Right Timeline Column -->
                        <div class="col-lg-8 ps-lg-4">
                            <h6 class="fw-bold text-primary mb-4">Clinical Timeline & Diagnosis Logs</h6>
                            <div class="timeline-custom" id="ehr-records-container">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-light border-opacity-10">
                    <button class="btn btn-premium btn-sm" data-bs-dismiss="modal">Close EHR Folder</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Main JS -->
    <script src="{{ asset('js/script.js') }}"></script>
    <!-- Page Logic JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const viewButtons = document.querySelectorAll('.btn-view-ehr');
            viewButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    const patientId = this.getAttribute('data-patient-id');
                    const name = this.getAttribute('data-patient-name');
                    const age = this.getAttribute('data-patient-age');
                    const gender = this.getAttribute('data-patient-gender');
                    const profile = this.getAttribute('data-patient-profile');
                    
                    const documents = JSON.parse(this.getAttribute('data-documents') || '[]');
                    const records = JSON.parse(this.getAttribute('data-records') || '[]');

                    // Update modal patient profile
                    document.getElementById('ehr-title').innerText = 'Electronic Health Record (EHR) - ' + name;
                    document.getElementById('ehr-avatar').src = profile;
                    document.getElementById('ehr-patient-name').innerText = name;
                    document.getElementById('ehr-patient-meta').innerText = 'Age: ' + age + ' • ' + gender;

                    // Render Documents
                    const docContainer = document.getElementById('ehr-documents-container');
                    docContainer.innerHTML = '';
                    if (documents.length === 0) {
                        docContainer.innerHTML = '<div class="text-muted small">No diagnostic lab documents available.</div>';
                    } else {
                        documents.forEach(doc => {
                            const sizeInMb = doc.file_size ? (doc.file_size / (1024 * 1024)).toFixed(2) + ' MB' : 'N/A';
                            docContainer.innerHTML += `
                                <div class="p-2 border border-light border-opacity-10 rounded-3 d-flex justify-content-between align-items-center glass-sub-card">
                                    <span style="font-size: 0.85rem;"><i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i>${doc.document_name} (${sizeInMb})</span>
                                    <a href="/${doc.file_path}" target="_blank" class="btn btn-sm text-info p-0"><i class="bi bi-download"></i></a>
                                </div>
                            `;
                        });
                    }

                    // Render Diagnosis/Timeline Records
                    const recContainer = document.getElementById('ehr-records-container');
                    recContainer.innerHTML = '';
                    if (records.length === 0) {
                        recContainer.innerHTML = `
                            <div class="timeline-item success">
                                <div class="fw-semibold">No medical entries logged yet.</div>
                                <small class="text-muted d-block mb-1">A clinical folder will be created after consultation.</small>
                            </div>
                        `;
                    } else {
                        records.forEach(rec => {
                            const recDate = new Date(rec.record_date).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
                            recContainer.innerHTML += `
                                <div class="timeline-item success">
                                    <div class="fw-semibold">${rec.title}</div>
                                    <small class="text-muted d-block mb-1">Attending Clinician: ${rec.doctor_name}</small>
                                    <p class="text-muted small">${rec.description.replace(/\n/g, '<br>')}</p>
                                    <span style="font-size: 0.75rem; color: var(--text-muted);">${recDate}</span>
                                </div>
                            `;
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>