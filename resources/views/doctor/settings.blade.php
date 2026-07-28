<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraHMS - Doctor Settings</title>
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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <nav>
                            <ul class="breadcrumb-custom mb-1">
                                <li class="breadcrumb-item-custom"><a href="/doctor/dashboard">Home</a></li>
                                <li class="breadcrumb-item-custom">Settings</li>
                            </ul>
                        </nav>
                        <h4 class="fw-bold mb-0">Shift & Profile Configurations</h4>
                    </div>
                </div>

                <!-- SKELETON LOADER -->
                <div class="skeleton-wrapper row g-4 mb-4">
                    <div class="col-12">
                        <div class="glass-card skeleton" style="height: 450px;"></div>
                    </div>
                </div>

                <!-- REAL CONTENT WRAPPER -->
                <div class="real-content-wrapper d-none">

                    <div class="row g-4">
                        <div class="col-12">
                            <div class="glass-card">
                                <ul class="nav nav-tabs border-light border-opacity-10 mb-4" role="tablist">
                                    <li class="nav-item">
                                        <button class="nav-link active border-0 bg-transparent px-3 py-2 fw-semibold"
                                            id="profile-tab" data-bs-toggle="tab" data-bs-target="#tab-profile"
                                            type="button" role="tab"><i class="bi bi-person-badge"></i> Practitioner
                                            Profile</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link border-0 bg-transparent px-3 py-2 fw-semibold"
                                            id="shift-tab" data-bs-toggle="tab" data-bs-target="#tab-shift"
                                            type="button" role="tab"><i class="bi bi-clock-history"></i> Weekly
                                            Availability Shifts</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link border-0 bg-transparent px-3 py-2 fw-semibold"
                                            id="sec-tab" data-bs-toggle="tab" data-bs-target="#tab-sec" type="button"
                                            role="tab"><i class="bi bi-shield-lock"></i> Passphrase Security</button>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <!-- 1. PRACTITIONER PROFILE -->
                                    <div class="tab-pane fade show active" id="tab-profile" role="tabpanel">
                                        <form action ="{{route('doctor.settings.profile')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label-custom">Practitioner Legal Name</label>
                                                    <input type="text" class="form-control form-glass" name="name"
                                                        value="{{$user->name}}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label-custom">Specialty Department
                                                        Division</label>
                                                     <select class="form-select form-glass" id="registerDept" name="department" required>
                                                        <option value="" disabled>Select Division</option>
                                                        <option value="cardiology {{ old('department', $doctor->department) === 'cardiology' ? 'selected' : '' }}" >Cardiology</option>
                                                        <option value="neurology  {{ old('department', $doctor->department) === 'neurology' ? 'selected' : '' }}">Neurology</option>
                                                        <option value="pediatrics {{ old('department', $doctor->department) === 'pediatrics' ? 'selected' : '' }}" >Pediatrics</option>
                                                        <option value="general {{ old('department', $doctor->department) === 'general' ? 'selected' : '' }}">General Medicine</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label-custom">Medical License Reference
                                                        ID</label>
                                                    <input type="text" class="form-control form-glass" name="license_id" value="{{$doctor->license_id}}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label-custom">Profile Photo</label>
                                                    <div class="d-flex align-items-center gap-3">
                                                        @if($doctor->profile_photo)
                                                        <img src="{{asset('doctors/profile/'.$doctor->profile_photo)}}" alt="doctor" 
                                                        class="rounded-circle border border-light border-opacity-20"
                                                        style="width:50px; height:50px; object-fit:cover;">
                                                        @else
                                                        <img src="https://ui-avatars.com/api/?name={{$user->name}}background=0D8ABC&color=fff" alt="doctor" class="profile-avatar">
                                                         
                                                        @endif
                                                       <input type="file" class="form-control form-glass" name="profile_photo">
                                                       </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label-custom">Professional Bio / Resume
                                                        Statement</label>
                                                    <textarea class="form-control form-glass"
                                                        rows="4" name="bio">{{$doctor->bio}}</textarea>
                                                </div>
                                            </div>
                                            <div
                                                class="mt-4 pt-3 border-top border-light border-opacity-10 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-premium">Update Profile
                                                    Details</button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- 2. WEEKLY AVAILABILITY SHIFTS -->
                                    <div class="tab-pane fade" id="tab-shift" role="tabpanel">
                                        <form action="{{route('doctor.settings.shifts')}}" method="post">
                                            @csrf
                                            <div class="row g-3">
                                                <div class="col-md-12">
                                                    <label class="form-label-custom d-block">OPD Consult Days
                                                        Availability</label>
                                                    <div class="d-flex gap-3 flex-wrap my-2">
                                                        @php
                                                            $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                                                        @endphp
                                                        @foreach ($days as $day)
                                                            
                                                        
                                                        <div class="form-check form-check-custom">
                                                         
                                                            <label class="form-check-label text-white"
                                                                for="day{{$day}}">{{$day}}</label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label-custom">Shift Start Time</label>
                                                    <input type="time" class="form-control form-glass" name="start_time" value="{{$doctor->start_time}}"
                                                        required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label-custom">Shift Close Time</label>
                                                    <input type="time" class="form-control form-glass" name="end_time" value="{{$doctor->end_time}}"
                                                        required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label-custom">Consult Session Fee</label>
                                                    <input type="number" class="form-control form-glass" name="consultation_fee" value="{{$doctor->consultation_fee}}"
                                                        required>
                                                </div>
                                            </div>
                                            <div
                                                class="mt-4 pt-3 border-top border-light border-opacity-10 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-premium">Save Shift
                                                    Availability</button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- 3. PASSPHRASE SECURITY -->
                                    <div class="tab-pane fade" id="tab-sec" role="tabpanel">
                                        <form action="{{route('doctor.settings.security')}}" method="post">
                                           @csrf
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label-custom">Doctor Portal Username
                                                        Login</label>
                                                    <input type="text" class="form-control form-glass" name="email" 
                                                        value="{{$user->email}}" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label-custom">Current Access Password</label>
                                                    <input type="password" class="form-control form-glass" name="current_password"
                                                        placeholder="••••••••" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label-custom">New Access Password</label>
                                                    <input type="password" class="form-control form-glass" name="new_password"
                                                        placeholder="••••••••" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label-custom">Verify New Password</label>
                                                    <input type="password" class="form-control form-glass" name="confirm_password"
                                                        placeholder="••••••••" required>
                                                </div>
                                            </div>
                                            <div
                                                class="mt-4 pt-3 border-top border-light border-opacity-10 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-premium">Change Password</button>
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