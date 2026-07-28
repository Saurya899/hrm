<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeUnit\FunctionUnit;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\SuperAdminController;

Route::get('/', function () {
    return view('login');
})->name('portal-hub');
Route::get('/login', function () {
    return redirect()->route('portal-hub');
})->name('login');
// Super admin login
Route::get('super-admin/login', function () {
    return view('super-admin.login');
})->name('super-admin.login');
Route::post('super-admin/login', [AuthController::class, 'adminLogin']);
// doctor login
Route::get('doctor/login', function () {
    return view('doctor.login');
})->name('doctor.login');
Route::post('doctor/login', [AuthController::class, 'doctorLogin']);
//doctor register
Route::post('doctor/register', [AuthController::class, 'doctorRegister'])->name('doctor.register');

// Patient Login
Route::get('patient/login', function () {
    return view('patient.login');
})->name('patient.login');
Route::post('patient/login', [AuthController::class, 'patientLogin']);
//patient register
Route::post('patient/register', [AuthController::class, 'patientRegister'])->name('patient.register');

Route::match(['get', 'post'], 'logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// super admin
Route::middleware(['auth', 'role:super-admin'])->prefix('super-admin')->group(function () {
    Route::get('/dashboard', fn() => view('super-admin.dashboard'))->name('super-admin.dashboard');
});
// doctor
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
    Route::get('/appoinments', [DoctorController::class, 'appointments'])->name('appoinments');
    Route::get('/patients', [DoctorController::class, 'patients'])->name('patients');
    Route::get('/settings', [DoctorController::class, 'settings'])->name('settings');
    Route::post('/settings/profile', [DoctorController::class, 'updateProfile'])->name('settings.profile');
    Route::post('/settings/shifts', [DoctorController::class, 'updateShifts'])->name('settings.shifts');
    Route::post('/settings/security', [DoctorController::class, 'updateSecurity'])->name('settings.security');
    Route::post('/consultation/store', [DoctorController::class, 'storeConsultation'])->name('consultation.store');
});
// patient
Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
    Route::get('/appointments', [PatientController::class, 'appointments'])->name('appointments');
    Route::post('appointments/book', [PatientController::class, 'appointmentsbook'])->name('appointments.book');
    Route::post('appointments/{appointment}/cancel', [PatientController::class, 'cancelAppointment'])->name('appointments.cancel');
    Route::get('/billing', [PatientController::class, 'billing'])->name('billing');
    Route::get('/records', [PatientController::class, 'records'])->name('records');
    Route::get('/settings', [PatientController::class, 'settings'])->name('settings');
    Route::post('/settings/profile', [PatientController::class, 'updateProfile'])->name('settings.profile');
    Route::post('/settings/security', [PatientController::class, 'updateSecurity'])->name('settings.security');
});
// super admin 
Route::middleware(['auth', 'role:super-admin'])->prefix('super-admin')->name('super-admin.')->group(function () {

    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/appointments', [SuperAdminController::class, 'appointments'])->name('appointments');
    Route::post('/appointments/{appointment}/status', [SuperAdminController::class, 'updateAppointmentStatus'])->name('appointments.status');
    Route::get('/billing', [SuperAdminController::class, 'billing'])->name('billing');
    Route::post('/billing/store', [SuperAdminController::class, 'storeInvoice'])->name('billing.store');
    Route::post('/billing/{invoice}/status', [SuperAdminController::class, 'updateInvoiceStatus'])->name('billing.status');
    Route::delete('/billing/{invoice}', [SuperAdminController::class, 'deleteInvoice'])->name('billing.destroy');
    Route::get('/doctors', [SuperAdminController::class, 'doctors'])->name('doctors');
    Route::post('/doctors/store', [SuperAdminController::class, 'storeDoctor'])->name('doctors.store');
    Route::delete('/doctors/{doctor}', [SuperAdminController::class, 'deleteDoctor'])->name('doctors.destroy');
    Route::post('/doctors/{doctor}/update', [SuperAdminController::class, 'updateDoctor'])->name('doctors.update');
    Route::get('/laboratory', [SuperAdminController::class, 'laboratory'])->name('laboratory');
    Route::get('/patients', [SuperAdminController::class, 'patients'])->name('patients');
    Route::post('/patients/store', [SuperAdminController::class, 'storePatient'])->name('patients.store');
    Route::delete('/patients/{patient}', [SuperAdminController::class, 'deletePatient'])->name('patients.destroy');
    Route::post('/patients/{patient}/update', [SuperAdminController::class, 'updatePatient'])->name('patients.update');
    Route::get('/reports', [SuperAdminController::class, 'reports'])->name('reports');
    Route::get('/users', [SuperAdminController::class, 'users'])->name('users');
    Route::get('/settings', [SuperAdminController::class, 'settings'])->name('settings');
    Route::post('/settings/profile', [SuperAdminController::class, 'updateProfile'])->name('settings.profile');
    Route::post('/settings/security', [SuperAdminController::class, 'updateSecurity'])->name('settings.security');

});