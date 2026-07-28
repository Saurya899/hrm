<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class PatientController extends Controller
{
    public function dashboard(): View
    {
        $user = Auth::user();
        $patient = Auth::user()->patient;
        return view('patient.dashboard', compact('user', 'patient'));
    }

    public function appointments(): View
    {
        $patient = Auth::user()->patient;

        $appointments = $patient->appointments()
            ->with('doctor.user')
            ->orderBy('appointment_date', 'desc')
            ->get();

        $doctors = Doctor::with('user')->get();
        $departments = Doctor::select('department')->distinct()->pluck('department');
        return view('patient.appointments', compact('appointments', 'doctors', 'departments'));
    }

    public function appointmentsbook(Request $request)
    {
        $patient = Auth::user()->patient;
        $data = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'symptoms' => 'nullable|string',
            'consultation_type' => 'nullable|string'
        ]);

        $doctor = Doctor::findOrFail($data['doctor_id']);
        $dataString = date('Y-m-d', strtotime($data['appointment_date']));
        $tokenNumber = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', $dataString)
            ->count() + 1;

        $appointments = $patient->appointments()->create([
            'doctor_id' => $doctor->id,
            'appointment_date' => $data['appointment_date'],
            'department' => $doctor->department,
            'symptoms' => $data['symptoms'] ?? 'NA',
            'consultation_type' => $data['consultation_type'] ?? 'NA',
            'token_number' => $tokenNumber,
        ]);
        return redirect()->route('patient.appointments')->with([
            'success' => 'Appointment Booked Successfully with Token Number',
            'booked_token' => $appointments->id
        ]);
    }

    public function cancelAppointment(Appointment $appointment)
    {
        $patient = Auth::user()->patient;
        if ($appointment->patient_id !== $patient->id) {
            abort(403);
        }

        if ($appointment->status === 'Pending') {
            $appointment->update([
                'status' => 'Cancelled'
            ]);
            return redirect()->route('patient.appointments')->with('cancel_success', 'Appointment Cancelled Successfully');
        }

        return redirect()->route('patient.appointments')->with('cancel_error', 'Only pending appointments can be cancelled.');
    }

    public function billing(): View
    {
        return view('patient.billing');
    }
    public function records(): View
    {
        $patient = Auth::user()->patient;
        $timelineRecords = $patient->medicalRecords()
            ->orderBy('record_date', 'desc')
            ->get();

        $activePrescriptions = $patient->prescriptions()->get();
        $labDocuments = $patient->labDocuments()->get();
        return view('patient.records');
    }

    public function settings(): View
    {
        return view('patient.settings');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::User();
        $data = $request->validate([
            'name' => 'required',
            'disease' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'gender' => 'required',
            'age' => 'required',
            'blood_group' => 'required',
            'number' => 'required',
            'address' => 'required',
            'profile' => 'required|max:2048'
        ]);

        if ($request->hasFile('profile')) {
            $oldprofile = $user->patient->profile;
            if ($oldprofile && file_exists('uploads/profile' . $oldprofile)) {
                unlink('uploads/profile' . $oldprofile);
            }
            $file = $request->file('profile');

            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile'), $filename);
            $data['profile'] = $filename;
        } else {
            $data['profile'] = $user->patient->profile;
        }
        $user->update([
            'name' => $data['name'],
            'email' => $data['email']
        ]);

        $user->patient()->updateOrCreate(
            [
                'user_id' => $user->id
            ],
            [
                'disease' => $data['disease'],
                'gender' => $data['gender'],
                'age' => $data['age'],
                'number' => $data['number'],
                'blood_group' => $data['blood_group'],
                'address' => $data['address'],
                'profile' => $data['profile']
            ]
        );
        return redirect()->route('patient.settings')->with('success', 'Patient Updated Successfullly');
    }

    public function updateSecurity(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'The provided password does not match old password!'
            ]);

        }
        $user->update([
            'password' => Hash::make($data['new_password'])
        ]);
        return redirect()->route('patient.settings')->with('success', 'Password Updated Successfullly');
    }

}
