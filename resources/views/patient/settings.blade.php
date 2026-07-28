<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraHMS - Patient Settings</title>
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
                        Settings</span>
                </div>

                @include('patient.header')

            </header>

            <!-- CONTENT BODY -->
            <div class="content-body">

                <!-- BREADCRUMB -->
                <nav>
                    <ul class="breadcrumb-custom">
                        <li class="breadcrumb-item-custom"><a href="/patient/dashboard">Home</a></li>
                        <li class="breadcrumb-item-custom">My Settings</li>
                    </ul>
                </nav>

                <!-- SKELETON LOADER -->
                <div class="skeleton-wrapper row g-4 mb-4">
                    <div class="col-12">
                        <div class="glass-card skeleton" style="height: 400px;"></div>
                    </div>
                </div>

                <!-- REAL CONTENT WRAPPER -->
                <div class="real-content-wrapper d-none">

                    <div class="row g-4">
                        <div class="col-12">
                            <div class="glass-card">
                                <ul class="nav nav-tabs border-light border-opacity-10 mb-4" role="tablist">
                                    <li class="nav-item">
                                        <button
                                            class="nav-link active text-white border-0 bg-transparent px-3 py-2 fw-semibold"
                                            id="profile-tab" data-bs-toggle="tab" data-bs-target="#tab-profile"
                                            type="button" role="tab"><i class="bi bi-person"></i> Edit Profile</button>
                                    </li>
                                    <li class="nav-item">
                                        <button
                                            class="nav-link text-white border-0 bg-transparent px-3 py-2 fw-semibold"
                                            id="security-tab" data-bs-toggle="tab" data-bs-target="#tab-security"
                                            type="button" role="tab"><i class="bi bi-shield-lock"></i> Security &
                                            Password</button>
                                    </li>
                                </ul>

                                <div class="tab-content">
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
                                    <!-- 1. PROFILE DETAILS -->
                                    <div class="tab-pane fade show active" id="tab-profile" role="tabpanel">
                                        <form action="{{route('patient.settings.profile')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label-custom">Upload your Profile Picture</label>
                                                    <div class="d-flex align-items-center gap-3">
                                                        @if(Auth::user()->patient->profile)
                                                        <img src="{{asset('uploads/profile/'.Auth::user()->patient->profile)}}" alt="patient" 
                                                        class="rounded-circle border border-light border-opacity-20"
                                                        style="width:50px; height:50px; object-fit:cover;>
                                                        @else
                                                       <img src="https://ui-avatars.com/api/?name={{Auth::user()->name}}background=0D8ABC&color=fff" alt="patient" class="profile-avatar">
                                                         
                                                        @endif
                                                       <input type="file" class="form-control form-glass" name="profile">
                                                       </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label-custom">Full Name</label>
                                                    <input type="text" class="form-control form-glass" name="name"
                                                        placeholder="Full Name"
                                                        value="{{old('name', Auth::user()->name)}}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label-custom">Gender</label>
                                                    <select name="gender" class="form-select form-glass" required>
                                                        <option value="Female" {{ old('gender', Auth::user()->patient->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                                                        <option value="Male" {{ old('gender', Auth::user()->patient->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                                                        <option value="Other" {{ old('gender', Auth::user()->patient->gender) === 'Other' ? 'selected' : '' }}>Other</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label-custom">Disease</label>
                                                    <input type="text" class="form-control form-glass" name="disease"
                                                        placeholder="Enter Disease"
                                                        value="{{old('disease', Auth::user()->patient->disease)}}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label-custom">Age</label>
                                                    <input type="text" class="form-control form-glass" name="age"
                                                        placeholder=" Enter Age"
                                                        value="{{old('age', Auth::user()->patient->age)}}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label-custom">Blood Group</label>
                                                    <input type="text" class="form-control form-glass"
                                                        name="blood_group" placeholder="Enter blood Group "
                                                        value="{{old('blood_group', Auth::user()->patient->blood_group)}}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label-custom">Email Address</label>
                                                    <input type="email" class="form-control form-glass" name="email"
                                                        placeholder="Enter Email"
                                                        value="{{old('email', Auth::user()->email)}}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label-custom">Contact Number</label>
                                                    <input type="tel" class="form-control form-glass" name="number"
                                                        placeholder="Enter Mobile Number"
                                                        value="{{old('number', Auth::user()->patient->number)}}">
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label-custom">Residential Address</label>
                                                    <textarea class="form-control form-glass" rows="2" name="address"
                                                        placeholder="Enter Your Address">{{old('address', Auth::user()->patient->address)}}</textarea>
                                                </div>
                                            </div>
                                            <div
                                                class="mt-4 pt-3 border-top border-light border-opacity-10 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-premium">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- 2. SECURITY CONFIG -->
                                    <div class="tab-pane fade" id="tab-security" role="tabpanel">
                                        <form action="{{route('patient.settings.security')}}" method="post">
                                            @csrf
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <label class="form-label-custom">Current Password</label>
                                                    <input type="password" class="form-control form-glass"
                                                        placeholder="Enter Old Password" name="current_password">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label-custom">Configure New Password</label>
                                                    <input type="password" class="form-control form-glass"
                                                        placeholder="Enter New Password" name="new_password">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label-custom">Verify Password Change</label>
                                                    <input type="password" class="form-control form-glass"
                                                        placeholder="Enter Confirm Password"
                                                        name="new_password_confirmation">
                                                </div>
                                            </div>
                                            <div
                                                class="mt-4 pt-3 border-top border-light border-opacity-10 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-premium">Update Password</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </main>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Main JS -->
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>