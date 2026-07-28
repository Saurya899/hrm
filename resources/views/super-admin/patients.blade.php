<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraHMS - Patient Registry</title>
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
                                <li class="breadcrumb-item-custom">Patients</li>
                            </ul>
                        </nav>
                        <h4 class="fw-bold mb-0">Patient Registry</h4>
                    </div>

                    <button class="btn btn-premium d-flex align-items-center gap-2" onclick="switchTab('register-tab')">
                        <i class="bi bi-person-plus-fill"></i> Patient Admission
                    </button>
                </div>
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

                <!-- SKELETON LOADER -->
                <div class="skeleton-wrapper row g-4 mb-4">
                    <div class="col-12">
                        <div class="glass-card skeleton" style="height: 400px;"></div>
                    </div>
                </div>

                <!-- DYNAMIC CONTENT -->
                <div class="real-content-wrapper">

                    <!-- PATIENT VIEW NAVIGATION -->
                    <ul class="nav nav-tabs border-light border-opacity-10 mb-4" id="patientTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active border-0 bg-transparent px-3 py-2 fw-semibold"
                                id="table-view-tab" data-bs-toggle="tab" data-bs-target="#tab-table-view" type="button"
                                role="tab"><i class="bi bi-list-columns-reverse me-1"></i> Registry Table</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link border-0 bg-transparent px-3 py-2 fw-semibold" id="card-view-tab"
                                data-bs-toggle="tab" data-bs-target="#tab-card-view" type="button" role="tab"><i
                                    class="bi bi-grid-fill me-1"></i> Patient Cards</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link border-0 bg-transparent px-3 py-2 fw-semibold" id="register-tab"
                                data-bs-toggle="tab" data-bs-target="#tab-register" type="button" role="tab"><i
                                    class="bi bi-person-plus-fill me-1"></i> New Registration</button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- 1. TABLE VIEW PANEL -->
                        <div class="tab-pane fade show active" id="tab-table-view" role="tabpanel">
                            <!-- SEARCH & FILTERS -->
                            <form action="{{route('super-admin.patients')}}" method="GET" class="glass-card mb-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Search Query</label>
                                        <div class="position-relative">
                                            <i class="bi bi-search position-absolute text-muted"
                                                style="left: 1rem; top: 50%; transform: translateY(-50%);"></i>
                                            <input type="text" name="search" value="{{request('search')}}" class="form-control form-glass ps-5"
                                                placeholder="Search by name, patient ID, blood group...">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label-custom">Blood Group</label>
                                        <select class="form-select form-glass">
                                            <option value="">Blood Group (All)</option>
                                            <option value="A+" {{request('blood_group')=='A+' ? 'selected' : ''}}>A+</option>
                                            <option value="B+" {{request('blood_group')=='B+' ? 'selected' : ''}}>B+</option>
                                            <option value="O+" {{request('blood_group')=='O+' ? 'selected' : ''}}>O+</option>
                                            <option value="AB+" {{request('blood_group')=='AB+' ? 'selected' : ''}}>AB+</option>
                                            <option value="A-" {{request('blood_group')=='A-' ? 'selected' : ''}}>A-</option>
                                            <option value="B-" {{request('blood_group')=='B-' ? 'selected' : ''}}>B-</option>
                                            <option value="O-" {{request('blood_group')=='O-' ? 'selected' : ''}}>O-</option>
                                            <option value="AB-" {{request('blood_group')=='AB-' ? 'selected' : ''}}>AB-</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-premium-outline w-100">Apply
                                            Filter</button>
                                       
                                    </div>
                                </div>
                            </form>

                            <div class="glass-card">
                                <div class="custom-table-container">
                                    <table class="custom-table">
                                        <thead>
                                            <tr>
                                                <th>Patient ID</th>
                                                <th>Patient Details</th>
                                                <th>Contact & Email</th>
                                                <th>Blood Group</th>
                                                <th>Illness</th>
                                                <th>Registered</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($patients as $pt)
                                             
                                            <tr>
                                                <td><span class="fw-bold">#PT-{{$pt->id}}</span></td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <img src="{{$pt->profile_photo_url}}"
                                                            alt="Patient" class="rounded-circle border border-light border-opacity-10"
                                                            style="width: 36px; height: 36px; object-fit: cover;">
                                                        <div>
                                                            <div class="fw-semibold">{{$pt->user->name ?? 'NA'}}</div>
                                                            <small class="text-muted">{{ucfirst($pt->gender)}}, {{$pt->age}} years</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                            <div><i class="bi bi-telephone me-1 text-muted"></i>{{$pt->number ?? 'NA'}}</div>
                                                            <small class="text-muted">{{$pt->user->email ?? 'NA'}}</small>
                                                        </div>
                                                </td>
                                                
                                                <td><span class="custom-badge badge-danger">{{$pt->blood_group}}</span></td>
                                                <td><span class="custom-badge badge-info">{{$pt->disease ?? 'NA'}}</span></td>
                                                <td><small class="text-muted">{{$pt->created_at ? $pt->created_at->format('Y-m-d'): 'NA'}}</small></td>
                                                <td class="text-end">
                                                    <button class="btn btn-premium-outline me-1 btn-sm" 
                                                    onclick="viewPatientDetails({{json_encode([
                                                    'id'=>$pt->id,
                                                    'name'=>$pt->user->name ?? '',
                                                    'email'=>$pt->user->email ?? '',
                                                    'age'=>$pt->age,
                                                    'gender'=>ucfirst($pt->gender),
                                                    'blood_group'=>$pt->blood_group,
                                                    'number'=>$pt->number,
                                                    'disease'=>$pt->disease ?? '',
                                                    'address'=>$pt->address ?? '',
                                                    'photo'=>$pt->profile_photo_url,
                                                    'created_at'=>$pt->created_at ? $pt->created_at->format('Y-m-d'): 'NA'

                                                    ])}})" title="Accesss Medical Record"
                                                        ><i class="bi bi-file-earmark-medical me-1"></i>EHR</button>
                                                        <button class="btn btn-sm btn-premium me-1"
                                                        onclick="editPatient({{json_encode([
                                                         'id'=>$pt->id,
                                                    'name'=>$pt->user->name ?? '',
                                                    'email'=>$pt->user->email ?? '',
                                                    'age'=>$pt->age,
                                                    'gender'=>strtolower($pt->gender),
                                                    'blood_group'=>$pt->blood_group,
                                                    'number'=>$pt->number,
                                                    'disease'=>$pt->disease ?? '',
                                                    'address'=>$pt->address ?? '',
                                                        ])}})" title="Edit Patient"
                                                        > <i class="bi bi-pencil-fill"> </i>
                                                </button>
                                                <form action="{{ route('super-admin.patients.destroy', $pt->id) }}" class="d-inline-block" onsubmit="return confirm('Are you sure want to delete this patient record?');">
                                                     @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Patient">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                </form>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">No Patients Record Found</td>
                                                
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- 2. CARD VIEW PANEL -->
                        <div class="tab-pane fade" id="tab-card-view" role="tabpanel">
                            <div class="row g-4">
                                @forelse ($patients as $pt)
                               
                                <div class="col-md-6 col-lg-4 col-xl-4">
                                    <div class="glass-card text-center glass-card-hover h-100 d-flex flex-column p-4">
                                        <img src="{{$pt->profile_photo_url}}"
                                            alt="Patient"
                                            class="rounded-circle mb-3 border border-light border-opacity-10"
                                            style="width: 70px; height: 70px; object-fit: cover;">
                                            <span class="position-absolute top-0 end-0 custom-badge badge-danger">{{$pt->blood_group}}</span>
                                            </div>
                                        <h5 class="fw-bold mb-1">{{$pt->user->name ?? 'NA'}}</h5>
                                        <p class="text-muted small mb-2">ID: <span class="text-primary fw-semibold"> #PT-{{$pt->id}}</span> • {{$pt->age}} years ({{ucfirst($pt->gender)}})</p>
                                        <div class="p-2 mb-3 rounded-3 text-start small border border-light border-opacity-10 bg-light bg-opacity-10 flex-grow-1 ">
                                            <div class="d-flex justify-content-between mb-2"><span
                                                    class="text-muted"><i class="bi bi-activity me-1 text-warning"></i>Illness:</span>
                                                <span class="fw-semibold text-white text-capitalize">{{$pt->disease}}</span>
                                            </div>
                                            <div class="d-flex justify-content-between"><span
                                                    class="text-muted"><i class="bi bi-telephone me-1 text-info"></i> Number:</span> 
                                             <span class="fw-semibold text-white">{{$pt->number}}</span>
                                              </div>
                                              <div class="d-flex justify-content-between"><span
                                                    class="text-muted"><i class="bi bi-envelope me-1 text-primary"></i> Email:</span> 
                                             <span class="fw-semibold text-white text-truncate ms-2" title="{{$pt->user->email}}">{{$pt->user->email}}</span>
                                              </div>
                                        </div>
                                       
                                    
                                
                            <div class="d-flex align-items-center justify-content-center gap-2 mt-auto">

                               <button class="btn btn-premium-outline btn-sm flex-grow-1" 
                                onclick="viewPatientDetails({{json_encode([
                                                    'id'=>$pt->id,
                                                    'name'=>$pt->user->name ?? '',
                                                    'email'=>$pt->user->email ?? '',
                                                    'age'=>$pt->age,
                                                    'gender'=>ucfirst($pt->gender),
                                                    'blood_group'=>$pt->blood_group,
                                                    'number'=>$pt->number,
                                                    'disease'=>$pt->disease ?? '',
                                                    'address'=>$pt->address ?? '',
                                                    'photo'=>$pt->profile_photo_url,
                                                    'created_at'=>$pt->created_at ? $pt->created_at->format('Y-m-d'): 'NA'

                                                    ])}})"
                                                       >EHR</button>
                                                        <button class="btn btn-sm btn-premium me-1"
                                                        onclick="editPatient({{json_encode([
                                                         'id'=>$pt->id,
                                                    'name'=>$pt->user->name ?? '',
                                                    'email'=>$pt->user->email ?? '',
                                                    'age'=>$pt->age,
                                                    'gender'=>strtolower($pt->gender),
                                                    'blood_group'=>$pt->blood_group,
                                                    'number'=>$pt->number,
                                                    'disease'=>$pt->disease ?? '',
                                                    'address'=>$pt->address ?? '',
                                                        ])}})" title="Edit Patient"
                                                        > <i class="bi bi-pencil-fill"> </i>
                                                </button>
                                                 <form action="{{ route('super-admin.patients.destroy', $pt->id) }}" class="d-inline-block" onsubmit="return confirm('Are you sure want to delete this patient record?');">
                                                     @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Patient">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                </form>

                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="glass-card text-center p-4">
                                <i class="bi bi-exclamation-triangle-fill text-warning mb-2" style="font-size: 2rem;"></i>
                                <h6 class="fw-semibold mb-1">No Patient Records Found</h6>
                                <p class="text-muted small mb-0">Please check back later or add new patient records.</p>
                            </div>
                        </div>
                        @endforelse

                    </div>
                </div>

                        <!-- 3. NEW REGISTRATION FORM -->
                        <div class="tab-pane fade" id="tab-register" role="tabpanel">
                            <div class="glass-card">
                                <h5 class="fw-bold mb-4"><i class="bi bi-person-plus-fill me-2 text-primary"></i>Patient Admission & Intake Form</h5>
                                <form action="{{route('super-admin.patients.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="form-label-custom">Profile Photo</label>
                                            <input type="file" name="profile" class="form-control form-glass" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-custom">Full Name</label>
                                            <input type="text" name="name" class="form-control form-glass" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-custom">Email</label>
                                            <input type="email" name="email" class="form-control form-glass" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-custom">Password</label>
                                            <input type="password" name="password" class="form-control form-glass" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label-custom">Age</label>
                                            <input type="number" name="age" class="form-control form-glass" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label-custom">Gender</label>
                                            <select name="gender" class="form-select form-glass" required>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label-custom">Blood Group</label>
                                            <select name="blood_group" class="form-select form-glass" required>
                                                <option value="O+">O+</option>
                                                <option value="O+">O-</option>
                                                <option value="A+">A+</option>
                                                <option value="A+">A-</option>
                                                <option value="B+">B+</option>
                                                <option value="B+">B-</option>
                                                <option value="AB+">AB+</option>
                                                <option value="AB+">AB-</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-custom">Contact Number</label>
                                            <input type="tel" name="number" class="form-control form-glass"
                                                placeholder="Enter Number" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-custom">Disease</label>
                                            <input type="text" name="disease" class="form-control form-glass"
                                                placeholder="Penicillin, Sulfa, none etc.">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label-custom">Residental Address</label>
                                            <textarea class="form-control form-glass" rows="4" name="address"
                                                placeholder="Brief explanation of current patient diagnoses..."></textarea>
                                        </div>
                                    </div>
                                    <div
                                        class="mt-4 pt-3 border-top border-light border-opacity-10 d-flex justify-content-end gap-2">
                                        <button type="reset" class="btn btn-premium-outline">Reset Form</button>
                                        <button type="submit" class="btn btn-premium">Complete Admission</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </main>
    </div>
     <!--Patient Upadte Modals-->
     <div class="modal fade modal-glass" id="editPatientModal" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-lg">
       <div class="modal-content">
        <div class="modal-header border-light border-opacity-10">
            <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2 text-primary"></i>Update Patient Info
            </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>

        </div>
        <form id="editPatientForm" action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="form-label-custom">Profile Photo (leave blank then photo not change)</label>
                                            <input type="file" name="profile" class="form-control form-glass" >
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-custom">Full Name</label>
                                            <input type="text" name="name" id="edit_name" class="form-control form-glass">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-custom">Email</label>
                                            <input type="email" name="email" id="edit_email" class="form-control form-glass">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-custom">Password</label>
                                            <input type="password" name="password"  class="form-control form-glass">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label-custom">Age</label>
                                            <input type="number" name="age" id="edit_age" class="form-control form-glass" >
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label-custom">Gender</label>
                                            <select name="gender" id="edit_gender" class="form-select form-glass">
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label-custom">Blood Group</label>
                                            <select name="blood_group" id="edit_blood_group" class="form-select form-glass">
                                                <option value="O+">O+</option>
                                                <option value="O+">O-</option>
                                                <option value="A+">A+</option>
                                                <option value="A+">A-</option>
                                                <option value="B+">B+</option>
                                                <option value="B+">B-</option>
                                                <option value="AB+">AB+</option>
                                                <option value="AB+">AB-</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-custom">Contact Number</label>
                                            <input type="tel" name="number" id="edit_number" class="form-control form-glass"
                                                placeholder="Enter Number" >
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label-custom">Disease</label>
                                            <input type="text" name="disease" id="edit_disease" class="form-control form-glass"
                                                placeholder="Penicillin, Sulfa, none etc.">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label-custom">Residental Address</label>
                                            <textarea class="form-control form-glass" rows="4" name="address" id="edit_address"
                                                placeholder="Brief explanation of current patient diagnoses..."></textarea>
                                        </div>
                                    </div>
                        </div>
                        <div
                                        class="mt-4 pt-3 border-top border-light border-opacity-10 d-flex justify-content-end gap-2">
                                        <button type="button" class="btn btn-premium-outline" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-premium">Update Patient</button>
                                    </div>

        </form>

       </div>
     </div>
     </div>
    <!-- MODAL: PATIENT FILES & DETAILS -->
    <div class="modal fade modal-glass" id="patientDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header border-light border-opacity-10">
                    <h5 class="modal-title fw-bold">Electronic Health Record (EHR)</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4 align-items-center">
                        <!-- Profile Summary & Documents -->
                        <div class="col-lg-4 text-center border-end border-light border-opacity-10 pe-md-4">
                          
                                <img src="" id="detail_photo"
                                    alt="Patient" class="rounded-circle mb-3 border border-light border-opacity-10"
                                    style="width: 110px; height: 110px; object-fit: cover;">
                                <h5 class="fw-bold mb-1" id="detail_name">Patient Name</h5>
                                <div class="mb-2"><span class="custom-badge badge-primary" id="detail_id"></span></div>
                                <span class="custom-badge badge-success mb-2" id="detail_blood_group">O+</span>
                        </div>
                        <div class="col-md-8 ps-md-4">
                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <label class="text-muted small d-block">Age & Gender</label>
                                    <span class="fw-bold text-white" id="detail_age_gender">NA</span>

                                </div>
                                <div class="col-6">
                                    <label class="text-muted small d-block">Contact Number</label>
                                    <span class="fw-bold text-white" id="detail_number">NA</span>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted small d-block">Email</label>
                                    <span class="fw-bold text-white" id="detail_email">NA</span>
                                </div>
                                   <div class="col-6">
                                    <label class="text-muted small d-block">Registered Date</label>
                                    <span class="fw-bold text-warning fs-6" id="detail_created_at">NA</span>
                                </div>
                                 <div class="col-12">
                                    <label class="text-muted small d-block">Codition/Illness</label>
                                    <span class="fw-bold text-warining fs-6" id="detail_disease">NA</span>
                                </div>
                                <div class="col-12">
                                    <label class="text-muted small d-block">Residental Address</label>
                                    <span class="text-secondary small" id="detail_address">NA</span>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="modal-footer border-light border-opacity-10">
                    <button class="btn btn-premium w-100" data-bs-dismiss="modal">Close Record</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Main JS -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        function switchTab(tabId) {
            const triggerEl = document.getElementById(tabId);
            if (triggerEl) {
                bootstrap.Tab.getOrCreateInstance(triggerEl).show();
            }
        }
    
    function editPatient(data) {
            document.getElementById('editPatientForm').action = '/super-admin/patients/' + data.id + '/update';
            document.getElementById('edit_name').value = data.name;
            document.getElementById('edit_email').value = data.email;
            document.getElementById('edit_age').value = data.age;
            document.getElementById('edit_gender').value = data.gender;
            document.getElementById('edit_blood_group').value = data.blood_group;
            document.getElementById('edit_number').value = data.number;
            document.getElementById('edit_disease').value = data.disease;
            document.getElementById('edit_address').value = data.address;

            var modal = new bootstrap.Modal(document.getElementById('editPatientModal'));
            modal.show();
        }

        function viewPatientDetails(data) {
            document.getElementById('detail_photo').src = data.photo;
            document.getElementById('detail_name').innerText = data.name;
            document.getElementById('detail_id').innerText = '#PT-' + data.id;
            document.getElementById('detail_blood_group').innerText = 'Blood Group: ' + data.blood_group;
            document.getElementById('detail_age_gender').innerText = data.age + ' Years (' + data.gender + ')';
            document.getElementById('detail_number').innerText = data.number || 'N/A';
            document.getElementById('detail_email').innerText = data.email || 'N/A';
            document.getElementById('detail_created_at').innerText = data.created_at || 'N/A';
            document.getElementById('detail_disease').innerText = data.disease || 'General Checkup';
            document.getElementById('detail_address').innerText = data.address || 'No residential address recorded.';

            var modal = new bootstrap.Modal(document.getElementById('patientDetailsModal'));
            modal.show();
        }
    </script>
</body>

</html>