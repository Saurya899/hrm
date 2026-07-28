<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\LabDocument;
use App\Models\MedicalRecord;
use App\Models\Prescription;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function dashboard()
    {
      $user = Auth::user();
      $doctor = $user->doctor;
       $today =now()->toDateString();

       $todayConsultationCount =Appointment::where('doctor_id',$doctor->id)
       ->whereDate('appointment_date',$today)
       ->count();

       $todayCompletedCount =Appointment::where('doctor_id',$doctor->id)
       ->whereDate('appointment_date',$today)
       ->where('status','Completed')
       ->count();

       $totalPatientsCount=Appointment::where('doctor_id',$doctor->id)
       ->distinct('patient_id')
       ->count('patient_id');

       $pendingDiagnosesCount =Appointment::where('doctor_id',$doctor->id)
       ->where('status','Pending')
       ->count();

       $emegencyCallsCount = Appointment::where('doctor_id',$doctor->id)
       ->where('consultation_type','Emergency')
       ->where('status','Pending')
       ->count();

       $queueAppointmets = Appointment::with('patient.user')
       ->where('doctor_id',$doctor->id)
       ->whereDate('appointment_date',$today)
       ->orderby('token_number','asc')
       ->get();

       $patientIds=Appointment::where('doctor_id',$doctor->id)
       ->distinct()->pluck('patient_id');
       
       $notifications = LabDocument::with('patient.user')
       ->where('patient_id',$doctor->id)
       ->orderBy('created_at','desc')
       ->take(5)
       ->get();
        return view('doctor.dashboard', compact(
            'user',
            'doctor',
            'todayConsultationCount',
            'todayCompletedCount',
            'totalPatientsCount',
            'pendingDiagnosesCount',
            'emegencyCallsCount',
            'queueAppointmets',
            'patientIds',
            'notifications'
        ));
    }

    public function storeConsultation(Request $request){
        
        $data = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'diagnosis' => 'required|string',
            'medicines' => 'nullable|array',
            'medicines.*.name' => 'required|string',
            'medicines.*.dosage' => 'required|string',
            'medicines.*.duration' => 'required|string',
            'directives' => 'nullable|string',
            
        ]);

        $appointment = Appointment::findOrFail($data['appointment_id']);

        // if ($appointment->doctor_id !== Auth::user()->doctor->id) {
        //     abort(403);
        // }


        $appointment->update([
            'status' => 'Completed',
        ]);

        MedicalRecord::create([
              'patient_id'=>$appointment->patient_id,
              'title'=>'Consultation-'. $appointment->department,
              'type'=>'OPD Consultation',
              'doctor_name'=>Auth::user()->name,
              'description'=>"Diagnosis Summery: ".$data['diagnosis']. "\nDirectives: ".($data['directives']) ,
              'record_date'=>now()      
               ]);
         if(!empty($data['medicines'])){
            foreach($data['medicines'] as $med){
                Prescription::create([
                    'patient_id'=>$appointment->patient_id,
                    'medicine_name'=>$med['name'],
                    'dosage'=>$med['dosage'],
                    'duration'=>$med['duration'],
                    'prescribed_by'=>Auth::user()->name,
                    'status'=>'Active'
                ]);
            }
         }
        return redirect()->back()->with('success', 'Consultation details stored successfully.');
    }
    public function patients(Request $request)
    {
        $user=Auth::user();
        $doctor=$user->doctor;
        $query = Patient::with(['user','medicalRecords','labDocuments'])
        ->whereHas('appointments',function($q) use ($doctor){
            $q->where('doctor_id',$doctor->id);
        });
        if($request->filled('search')){
            $search= $request->search;
            $query->where(function ($q) use ($search){
                $q->whereHas('user',function($uQuery) use ($search){
                   $uQuery->where('name','like',"%{$search}%");
                })
                ->orWhere('id','like',"%{$search}%")
                ->orWhere('blood_group','like',"%{$search}%");
            });
        }
        $patients = $query->get();
        foreach($patients as $patient)
            {
               $latestAppointment = Appointment::where('patient_id',$patient->id) 
               ->where('doctor_id',$doctor->id)
               ->latest('appointment_date')
               ->first();
               $patient->last_visit_date = $latestAppointment ? $latestAppointment->appointment_date->format('Y-m-d'):Null;
            }
        return view('doctor.patients', compact('user','doctor','patients'));
    }

     public function appointments(Request $request)
    {
        $user =Auth::user();
        $doctor=$user->doctor;

        $query = Appointment::with('patient.user')
        ->where('doctor_id',$doctor->id);
        if($request->filled('search')){
            $search= $request->search;
            $query->whereHas('patient.user',function($q) use ($search){
                     $q->where('name','like', "%{$search}%");
            });

        }

        $appointments = $query->orderBy('appointment_date','desc')->get();
        return view('doctor.appointments' ,compact('user','doctor','appointments'));
    }

     public function settings()
    {
        $user = Auth::user();
        $doctor = $user->doctor;
        return view('doctor.settings',compact('user','doctor'));
    }
    public function updateProfile(Request $request){
        $user = Auth::user();
        $doctor =$user->doctor;

        $data = $request->validate([
            'name'=>'required',
            'department'=>'required',
            'license_id'=>'required',
            'profile_photo'=>'required|image',
            'bio'=>'required',
        ]);
        if($request->hasFile('profile_photo'))
            {
                if($doctor->profile_photo && file_exists(public_path('doctors/profile/'.$doctor->profile_photo)))
                    {
                        
                        unlink(public_path('doctors/profile/'.$doctor->profile_photo));
                    }
           $file = $request->file('profile_photo');

            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('doctors/profile'), $filename);
            $data['profile_photo'] = $filename;
        }
        else{
            $data['profile_photo'] = $doctor->profile_photo;
        }
        $user->update([
            'name' => $data['name']
        ]);

        $user->doctor()->updateOrCreate(
            [
                'user_id' => $user->id
            ],
            [
                'department' => $data['department'],
                'license_id' => $data['license_id'],
                'profile_photo' => $data['profile_photo'],
                'bio' => $data['bio'],
                
            ]
        );
        return redirect()->route('doctor.settings')->with('success', 'Doctor Updated Successfullly');
         }

         public function updateShifts(Request $request){
            
            $user = Auth::user();
            $doctor =$user->doctor;
    
            $data = $request->validate([
                'start_time'=>'required',
                'end_time'=>'required',
                'available_days'=>'required|array',
                'consultation_fee'=>'required'
            ]);
    
            $user->doctor()->updateOrCreate(
                [
                    'user_id' => $user->id
                ],
                [
                    'start_time' => $data['start_time'],
                    'end_time' => $data['end_time'],
                    'available_days' => $data['available_days'],
                    'consultation_fee' => $data['consultation_fee'],
                ]
            );
            return redirect()->route('doctor.settings')->with('success', 'Weekly Shifts And Availability Update Successfully');
         }
         
         public function updateSecurity(Request $request){
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
    
           
    
            return redirect()->route('doctor.settings')->with('success', 'Security Settings Updated Successfully');
         }
 }

