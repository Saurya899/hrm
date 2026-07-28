<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraHMS - Doctors Directory</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .doctor-card-img {
            height: 200px;
            object-fit: cover;
            width: 100%;
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
        }
        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
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
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                    <div>
                        <nav>
                            <ul class="breadcrumb-custom mb-1">
                                <li class="breadcrumb-item-custom"><a href="/super-admin/dashboard">Home</a></li>
                                <li class="breadcrumb-item-custom">Doctors</li>
                            </ul>
                        </nav>
                        <h4 class="fw-bold mb-0">Doctors Directory</h4>
                    </div>

                    <button class="btn btn-premium d-flex align-items-center gap-2" data-bs-toggle="modal"
                        data-bs-target="#addDoctorModal">
                        <i class="bi bi-plus-lg"></i> Add New Doctor
                    </button>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4 border-0 text-white" style="background: rgba(16, 185, 129, 0.2); backdrop-filter: blur(10px);" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 text-white" style="background: rgba(239, 68, 68, 0.2); backdrop-filter: blur(10px);" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $errors->first() }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- FILTER BAR -->
                <form action="{{route('super-admin.doctors')}}" method="GET" class="glass-card mb-4">
                    <div class="row g-3">
                        <div class="col-md-9">
                            <label class="form-label-custom">Search by Name / ID / Department</label>
                            <div class="position-relative">
                                <i class="bi bi-search position-absolute text-muted"
                                    style="left: 1rem; top: 50%; transform: translateY(-50%);"></i>
                                <input type="text" name="search" class="form-control form-glass ps-5"
                                    placeholder="Enter doctor name or medical license ID..." value="{{request('search')}}">
                            </div>
                        </div>
                          
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-premium-outline w-100">
                                <i class="bi bi-funnel-fill"></i> Filter Doctors
                            </button>
                        </div>
                    </div>
                </form>

                <!-- SKELETON LOADER -->
                <div class="skeleton-wrapper row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="glass-card skeleton" style="height: 350px;"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="glass-card skeleton" style="height: 350px;"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="glass-card skeleton" style="height: 350px;"></div>
                    </div>
                </div>

                <!-- DYNAMIC CONTENT -->
                <div class="real-content-wrapper">

                    <!-- GRID / TABLE TABS -->
                    <ul class="nav nav-tabs border-light border-opacity-10 mb-4" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active border-0 bg-transparent px-3 py-2 fw-semibold" id="grid-tab"
                                data-bs-toggle="tab" data-bs-target="#tab-grid" type="button" role="tab"><i
                                    class="bi bi-grid-fill me-1"></i> Grid View</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link border-0 bg-transparent px-3 py-2 fw-semibold" id="table-tab"
                                data-bs-toggle="tab" data-bs-target="#tab-table" type="button" role="tab"><i
                                    class="bi bi-list-task me-1"></i> Table View</button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- TAB GRID VIEW -->
                        <div class="tab-pane fade show active" id="tab-grid" role="tabpanel">
                            <div class="row g-4">
                                @forelse ($doctors as $doc)
                                <div class="col-sm-6 col-lg-4 col-xl-4">
                                    <div class="glass-card p-0 overflow-hidden glass-card-hover h-100 d-flex flex-column">
                                        <div class="position-relative">
                                            <img src="{{$doc->profile_photo_url}}" alt="Dr. {{$doc->user->name ?? 'Doctor'}}" class="doctor-card-img">
                                            <div class="position-absolute top-0 start-0 m-3">
                                                <span class="custom-badge badge-info shadow-sm text-capitalize">{{$doc->department}}</span>
                                            </div>
                                            <div class="position-absolute top-0 end-0 m-3">
                                                <span class="custom-badge badge-success shadow-sm"><i class="bi bi-circle-fill me-1" style="font-size:0.5rem;"></i> Active</span>
                                            </div>
                                        </div>

                                        <div class="p-3 text-center d-flex flex-column flex-grow-1">
                                            <h5 class="fw-bold mb-1 text-truncate" title="Dr. {{$doc->user->name ?? 'NA'}}">Dr. {{$doc->user->name ?? 'NA'}}</h5>
                                            <div class="text-muted small mb-2"><i class="bi bi-award me-1 text-warning"></i> License: {{$doc->license_id}}</div>
                                            
                                            @if(!empty($doc->bio))
                                                <p class="text-muted small mb-3 text-truncate-2 px-2" style="font-size:0.85rem; line-height:1.4;">{{ Str::limit($doc->bio, 80) }}</p>
                                            @else
                                                <p class="text-muted small mb-3 opacity-75" style="font-size:0.85rem;">No bio description provided.</p>
                                            @endif

                                            <div class="mt-auto pt-2">
                                                <div class="row g-0 py-2 rounded-3 bg-light bg-opacity-10 border border-light border-opacity-10 mb-3 align-items-center">
                                                    <div class="col-6 border-end border-light border-opacity-10 text-center px-1">
                                                        <span class="d-block text-muted small" style="font-size:0.75rem;">Consult Fee</span>
                                                        <span class="fw-bold text-success">${{number_format($doc->consultation_fee,2)}}</span>
                                                    </div>
                                                    <div class="col-6 text-center px-1">
                                                        <span class="d-block text-muted small" style="font-size:0.75rem;">Email</span>
                                                        <span class="fw-semibold text-truncate d-block small px-1 text-white" title="{{$doc->user->email ?? 'NA'}}">{{$doc->user->email ?? 'NA'}}</span>
                                                    </div>
                                                </div>

                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <button class="btn btn-sm btn-premium-outline flex-grow-1 d-flex align-items-center justify-content-center gap-1"
                                                        onclick="viewDoctorDetails({{ json_encode([
                                                            'id' => $doc->id,
                                                            'name' => $doc->user->name ?? '',
                                                            'email' => $doc->user->email ?? '',
                                                            'department' => ucfirst($doc->department),
                                                            'license' => $doc->license_id,
                                                            'fee' => number_format($doc->consultation_fee, 2),
                                                            'bio' => $doc->bio ?? 'No bio provided.',
                                                            'photo' => $doc->profile_photo_url,
                                                            'created_at' => $doc->created_at ? $doc->created_at->format('M d, Y') : 'N/A'
                                                        ]) }})">
                                                        <i class="bi bi-eye"></i> View
                                                    </button>

                                                    <button class="btn btn-sm btn-premium flex-grow-1 d-flex align-items-center justify-content-center gap-1"
                                                        onclick="editDoctor({{ json_encode([
                                                            'id' => $doc->id,
                                                            'name' => $doc->user->name ?? '',
                                                            'email' => $doc->user->email ?? '',
                                                            'department' => strtolower($doc->department),
                                                            'license' => $doc->license_id,
                                                            'fee' => $doc->consultation_fee,
                                                            'bio' => $doc->bio ?? ''
                                                        ]) }})">
                                                        <i class="bi bi-pencil"></i> Edit
                                                    </button>

                                                    <form action="{{ route('super-admin.doctors.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this doctor profile?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger px-2" title="Delete Doctor">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12 text-center text-muted py-5">
                                    <i class="bi bi-person-x fs-1 d-block mb-2 text-muted"></i>
                                    No doctors found matching your criteria.
                                </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- TAB TABLE VIEW -->
                        <div class="tab-pane fade" id="tab-table" role="tabpanel">
                            <div class="glass-card">
                                <div class="custom-table-container">
                                    <table class="custom-table">
                                        <thead>
                                            <tr>
                                                <th>Doctor Name</th>
                                                <th>Email</th>
                                                <th>Department</th>
                                                <th>License Id</th>
                                                <th>Consult Fee</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($doctors as $doc)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <img src="{{$doc->profile_photo_url}}"
                                                            alt="Doctor" class="rounded-circle border border-light border-opacity-10"
                                                            style="width: 38px; height: 38px; object-fit: cover;">
                                                        <div class="fw-semibold">Dr. {{$doc->user->name ?? 'NA'}}</div>
                                                    </div>
                                                </td>
                                                <td>{{$doc->user->email ?? 'NA'}}</td>
                                                <td><span class="custom-badge badge-info text-capitalize">{{$doc->department}}</span></td>
                                                <td>{{$doc->license_id}}</td>
                                                <td><span class="custom-badge badge-success">${{number_format($doc->consultation_fee,2)}}</span></td>
                                                <td class="text-end">
                                                    <button class="btn btn-sm btn-premium-outline me-1"
                                                        onclick="viewDoctorDetails({{ json_encode([
                                                            'id' => $doc->id,
                                                            'name' => $doc->user->name ?? '',
                                                            'email' => $doc->user->email ?? '',
                                                            'department' => ucfirst($doc->department),
                                                            'license' => $doc->license_id,
                                                            'fee' => number_format($doc->consultation_fee, 2),
                                                            'bio' => $doc->bio ?? 'No bio provided.',
                                                            'photo' => $doc->profile_photo_url,
                                                            'created_at' => $doc->created_at ? $doc->created_at->format('M d, Y') : 'N/A'
                                                        ]) }})" title="View Details">
                                                        <i class="bi bi-eye-fill"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-premium me-1"
                                                        onclick="editDoctor({{ json_encode([
                                                            'id' => $doc->id,
                                                            'name' => $doc->user->name ?? '',
                                                            'email' => $doc->user->email ?? '',
                                                            'department' => strtolower($doc->department),
                                                            'license' => $doc->license_id,
                                                            'fee' => $doc->consultation_fee,
                                                            'bio' => $doc->bio ?? ''
                                                        ]) }})" title="Edit Doctor">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </button>
                                                    <form action="{{ route('super-admin.doctors.destroy', $doc->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this doctor?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Doctor">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">No doctors found.</td>
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

    <!-- MODAL 1: ADD DOCTOR -->
    <div class="modal fade modal-glass" id="addDoctorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header border-light border-opacity-10">
                    <h5 class="modal-title fw-bold"><i class="bi bi-person-plus-fill me-2 text-primary"></i>Doctor Registration</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('super-admin.doctors.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12 mb-2">
                                <label class="form-label-custom">Profile Image Upload</label>
                                <input type="file" name="profile_photo" class="form-control form-glass" accept="image/*">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-glass" placeholder="Dr. Jane Watson" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control form-glass" placeholder="jane.watson@aurahms.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Password (Default: doctor123)</label>
                                <input type="password" name="password" class="form-control form-glass" placeholder="Leave empty for default 'doctor123'">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Department Division <span class="text-danger">*</span></label>
                                <select class="form-select form-glass text-capitalize" name="department" required>
                                    <option value="" disabled selected>Select Department</option>
                                    <option value="cardiology">Cardiology</option>
                                    <option value="neurology">Neurology</option>
                                    <option value="pediatrics">Pediatrics</option>
                                    <option value="ophthalmology">Ophthalmology</option>
                                    <option value="orthopedics">Orthopedics</option>
                                    <option value="dermatology">Dermatology</option>
                                    <option value="general medicine">General Medicine</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Medical License ID <span class="text-danger">*</span></label>
                                <input type="text" name="license_id" class="form-control form-glass" placeholder="e.g. MC-90284" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Consultation Fee ($) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0" name="consultation_fee" class="form-control form-glass" placeholder="e.g. 150.00" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label-custom">Professional Profile Bio / Resume</label>
                                <textarea name="bio" class="form-control form-glass" rows="3" placeholder="State past residencies, fellowships, specialties, and research..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-light border-opacity-10">
                        <button type="button" class="btn btn-premium-outline" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-premium"><i class="bi bi-check-circle me-1"></i> Register Doctor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL 2: EDIT DOCTOR -->
    <div class="modal fade modal-glass" id="editDoctorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header border-light border-opacity-10">
                    <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Doctor Profile</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editDoctorForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12 mb-2">
                                <label class="form-label-custom">Profile Image (Leave blank to keep existing)</label>
                                <input type="file" name="profile_photo" class="form-control form-glass" accept="image/*">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="edit_name" class="form-control form-glass" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="edit_email" class="form-control form-glass" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">New Password (Optional)</label>
                                <input type="password" name="password" class="form-control form-glass" placeholder="Leave empty to keep unchanged">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Department Division <span class="text-danger">*</span></label>
                                <select class="form-select form-glass text-capitalize" name="department" id="edit_department" required>
                                    <option value="cardiology">Cardiology</option>
                                    <option value="neurology">Neurology</option>
                                    <option value="pediatrics">Pediatrics</option>
                                    <option value="ophthalmology">Ophthalmology</option>
                                    <option value="orthopedics">Orthopedics</option>
                                    <option value="dermatology">Dermatology</option>
                                    <option value="general medicine">General Medicine</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Medical License ID <span class="text-danger">*</span></label>
                                <input type="text" name="license_id" id="edit_license_id" class="form-control form-glass" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Consultation Fee ($) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0" name="consultation_fee" id="edit_consultation_fee" class="form-control form-glass" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label-custom">Professional Profile Bio / Resume</label>
                                <textarea name="bio" id="edit_bio" class="form-control form-glass" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-light border-opacity-10">
                        <button type="button" class="btn btn-premium-outline" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-premium"><i class="bi bi-save me-1"></i> Update Doctor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL 3: DOCTOR DETAILS & PROFILE VIEW -->
    <div class="modal fade modal-glass" id="doctorDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header border-light border-opacity-10">
                    <h5 class="modal-title fw-bold"><i class="bi bi-person-badge me-2 text-primary"></i>Medical Officer Profile</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-4 text-center border-end border-light border-opacity-10">
                            <img id="detail_photo" src="" alt="Doctor Profile" class="rounded-4 border border-light border-opacity-10 img-fluid mb-3 shadow" style="width: 150px; height: 150px; object-fit: cover;">
                            <h5 class="fw-bold mb-1" id="detail_name">Dr. N/A</h5>
                            <span class="custom-badge badge-info mb-2 text-capitalize d-inline-block" id="detail_department">Department</span>
                            <div><span class="custom-badge badge-success mb-3"><i class="bi bi-check-circle-fill me-1"></i>Active On Duty</span></div>
                        </div>
                        <div class="col-md-8 ps-md-4">
                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <label class="text-muted small d-block">Medical License ID</label>
                                    <span class="fw-bold text-primary" id="detail_license">N/A</span>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted small d-block">Email Address</label>
                                    <span class="fw-semibold text-white" id="detail_email">N/A</span>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted small d-block">Consultation Fee</label>
                                    <span class="fw-bold text-success fs-5" id="detail_fee">$0.00</span>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted small d-block">Registered Date</label>
                                    <span class="fw-semibold text-white" id="detail_joined">N/A</span>
                                </div>
                            </div>

                            <h6 class="fw-bold text-primary mb-2 border-top border-light border-opacity-10 pt-3">Biography & Qualifications</h6>
                            <p class="text-secondary small mb-0" id="detail_bio" style="line-height:1.6;">No biography details available.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-light border-opacity-10">
                    <button class="btn btn-premium w-100" data-bs-dismiss="modal">Close Profile</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Main JS -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        function editDoctor(data) {
            document.getElementById('editDoctorForm').action = '/super-admin/doctors/' + data.id + '/update';
            document.getElementById('edit_name').value = data.name;
            document.getElementById('edit_email').value = data.email;
            document.getElementById('edit_department').value = data.department;
            document.getElementById('edit_license_id').value = data.license;
            document.getElementById('edit_consultation_fee').value = data.fee;
            document.getElementById('edit_bio').value = data.bio;
            
            var modal = new bootstrap.Modal(document.getElementById('editDoctorModal'));
            modal.show();
        }

        function viewDoctorDetails(data) {
            document.getElementById('detail_photo').src = data.photo;
            document.getElementById('detail_name').innerText = 'Dr. ' + data.name;
            document.getElementById('detail_department').innerText = data.department;
            document.getElementById('detail_license').innerText = data.license;
            document.getElementById('detail_email').innerText = data.email;
            document.getElementById('detail_fee').innerText = '$' + data.fee;
            document.getElementById('detail_joined').innerText = data.created_at;
            document.getElementById('detail_bio').innerText = data.bio || 'No biography details available.';

            var modal = new bootstrap.Modal(document.getElementById('doctorDetailsModal'));
            modal.show();
        }
    </script>
</body>

</html>