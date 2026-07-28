<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class SuperAdminController extends Controller
{
    public function dashboard()
    {
        return view('super-admin.dashboard');
    }
    public function appointments(Request $request)
    {
        $query = Appointment::with(['patient.user', 'doctor.user']);
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{ $search}%");
            })->orWhereHas('doctor.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{ $search}%");
            });
        }
        $appointments = $query->orderBy('appointment_date', 'desc')->get();
        $doctors = Doctor::with('user')->get();
        $patients = Patient::with('user')->get();
        return view('super-admin.appointments', compact('appointments', 'doctors', 'patients'));
    }

    public function updateAppointmentStatus(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'status' => 'required|in:Pending,Confirmed,Completed,Cancelled',
        ]);
        $appointment->update([
            'status' => $data['status'],
        ]);
        return redirect()->route('super-admin.appointments')
            ->with('success', 'Appointments status updated.');
    }

    public function billing(Request $request)
    {
        $query = Invoice::with(['patient.user', 'items']);
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhereHas('patient.user', function ($pq) use ($search) {
                        $pq->where('name', 'like', "%{$search}%");
                    });

            });
        }
        $invoices = $query->orderBy('created_at', 'desc')->get();
        $patients = Patient::with('user')->get();
        $totalRevenue = Invoice::where('status', 'paid')->sum('total_amount');
        $paidCount = Invoice::where('status', 'paid')->count();
        $unpaidCount = Invoice::where('status', 'unpaid')->count();
        $totalInvoicesCount = Invoice::count();
        return view('super-admin.billing', compact(
            'invoices',
            'patients',
            'totalRevenue',
            'paidCount',
            'unpaidCount',
            'totalInvoicesCount'
        ));
    }

    public function storeInvoice(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'title' => 'required|string|max:255',
            'billing_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:billing_date',
            'payment_method' => 'nullable|string|max:100',
            'status' => 'required|in:paid,unpaid,cancelled',
            'discount' => 'nullable|numeric|min:0',
            'gst' => 'nullable|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string|max:255',
            'items.*.rate' => 'required|numeric|min:0',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        $subtotal = 0;
        foreach ($data['items'] as $item) {
            $subtotal += ($item['qty'] * $item['rate']);
        }
        $discount = $data['discount'] ?? 0;
        $gst = $data['gst'] ?? 0;
        $totalAmount = max(0, $subtotal - $discount + $gst);

        $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(4));
        $invoice = Invoice::create([
            'patient_id' => $data['patient_id'],
            'invoice_number' => $invoiceNumber,
            'title' => $data['title'],
            'billing_date' => $data['billing_date'],
            'due_date' => $data['due_date'],
            'subtotal' => $subtotal,
            'discount' => $discount,
            'gst' => $gst,
            'total_amount' => $totalAmount,
            'status' => $data['status'],
            'payment_method' => $data['payment_method'] ?? 'Pending',
        ]);
        foreach ($data['items'] as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'description' => $item['description'],
                'rate' => $item['rate'],
                'qty' => $item['qty'],
                'total' => ($item['qty'] * $item['rate']),
            ]);
        }
        return redirect()->route('super-admin.billing')
            ->with('success', 'Invoice genrrated successfully');

    }
    public function updateInvoiceStatus(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'status' => 'required|in:paid,unpaid,cancelled',
            'payment_method' => 'nullable|string|max:100',
        ]);

        $invoice->update([
            'status' => $data['status'],
            'payment_method' => $data['payment_method'] ?? $invoice->payment_method,
        ]);
        return redirect()->route('super-admin.billing')
            ->with('success', 'Invoice status updated successfully.');
    }
    public function deleteInvoice(Invoice $invoice)
    {

        $invoice->delete();
        return redirect()->route('super-admin.billing')
            ->with('success', 'Invoice deleted successfully.');
    }
    public function doctors(Request $request)
    {
        $query = Doctor::with('user');
        if ($request->filled('search')) {
            $search = $request->search;
            $query->wherehas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('department', 'like', "%{$search}%")
                ->orWhere('license_id', 'like', "%{$search}%");
        }
        $doctors = $query->orderBy('created_at', 'desc')->get();
        return view('super-admin.doctors', compact('doctors'));
    }
    public function storeDoctor(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'department' => 'required|string|max:255',
            'license_id' => 'required|string|max:255|unique:doctors,license_id',
            'bio' => 'nullable|string',
            'profile_photo' => 'nullable|image',
            'consultation_fee' => 'nullable|numeric|min:0',
        ]);
        $photoPath = null;
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('doctors/profile'), $filename);
            $photoPath = $filename;
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'doctor',
            'status' => 'active'
        ]);


        Doctor::create([
            'user_id' => $user->id,
            'department' => $data['department'],
            'license_id' => $data['license_id'],
            'bio' => $data['bio'] ?? null,
            'profile_photo' => $photoPath,
            'consultation_fee' => $data['consultation_fee'] ?? null,
        ]);


        return redirect()->route('super-admin.doctors')
            ->with('success', 'Doctor added successfully.');
    }
     public function updateDoctor(Request $request ,Doctor $doctor){
       $data=$request->validate([
          'name'=>'required|string|max:255',
          'email'=>'required|email|unique:users,email,'.$doctor->user_id,
          'password'=>'required|string|min:6',
          'department'=>'required|string|max:255',
          'license_id'=>'required|string|max:255|unique:doctors,license_id,'.$doctor->id,
          'bio'=>'nullable|string',
          'profile_photo'=>'nullable|image',
          'consultation_fee'=>'nullable|numeric|min:0',
        ]);
        $photoPath = $doctor->profile_photo;
        if($request->hasFile('profile_photo')){
        if($doctor->profile_photo && file_exists(public_path('doctor/profile/'.$doctor->profile_photo))){
            unlink(public_path('doctors/profile/'.$doctor->profile_photo));
        }
        $file =$request->file('profile_photo');
        $filename=time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('doctors/profile'),$filename);
        $photoPath =$filename;
       }
       $userData=[
        'name'=>$data['name'],
        'email'=>$data['email'],
        'password'=>Hash::make($data['password']),
       ];
       $doctor->user->update($userData);

       $doctor->update([
        'department'=>$data['department'],
        'license_id'=>$data['license_id'],
        'bio'=>$data['bio'] ?? null ,
        'consultation_fee' => $data['consultation_fee'],
        'profile_photo'=>$photoPath,
       ]);
       return redirect ()->route('super-admin.doctors')->with('success','Doctor Updated successfully');
    }

    public function deleteDoctor(Doctor $doctor){
        if($doctor->profile_photo && file_exists(public_path('doctors/profile/'.$doctor->profile_photo))){
            unlink(public_path('doctors/profile/'.$doctor->profile_photo));
        }
        $user=$doctor->user;
        $doctor->delete();
        if($user){
            $user->delete();
        }
        return redirect()->route('super-admin.doctors')->with('success','Doctor Deleted Successfully!');
    }

    public function laboratory()
    {
        return view('super-admin.laboratory');
    }

    public function patients(Request $request)

    {
        $query =Patient::with(['user','medicalRecords','labDocuments','appointments.doctor.user']);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->wherehas('user', function ($uQuery) use ($search){
                    $uQuery->where('name','like',"%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orWhere('number', 'like', "%{$search}%")
            ->orWhere('disease', 'like', "%{$search}%")
            ->orWhere('id', 'like', "%{$search}%");
            });
        }
        if($request->filled('blood_group')){
            $query->where('blood_group',$request->blood_group);
        }
        $patients = $query->orderBy('created_at','desc')->get();

        return view('super-admin.patients', compact('patients'));
    }
    public function storePatient(Request $request){
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|string|min:6',
            'age' => 'required|string|max:50',
            'gender' => 'required|string|max:50',
            'number' => 'required|string|max:20|unique:patients,number',
            'blood_group' => 'required|string|max:10',
            'address' => 'nullable|string|max:500',
            'disease' => 'nullable|string|max:255',
            'profile' => 'nullable|image',
        ]);
        $photoPath = null;
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile'), $filename);
            $photoPath = $filename;
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'patient',
            'status' => 'active'
        ]);

        Patient::create([
            'user_id' => $user->id,
            'number' => $data['number'],
            'age' => $data['age'],
            'gender' => $data['gender'],
            'blood_group' => $data['blood_group'],
            'disease' => $data['disease'] ?? null,
            'address' => $data['address'] ?? null,
            'profile' => $photoPath,
        ]);

        return redirect()->route('super-admin.patients')
            ->with('success', 'Patient added successfully.');
    }
    
    public function updatePatient(Request $request, Patient $patient){
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$patient->user_id,
            'password' => 'nullable|string|min:6',
            'age' => 'required|string|max:50',
            'gender' => 'required|string|max:50',
            'blood_group' => 'required|string|max:50',
            'number' => 'required|string|max:20',
            'disease'=>'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'profile' => 'nullable|image'
        ]);

         $photoPath=$patient->profile;
        if($request->hasFile('profile')){
            if($patient->profile && file_exists(public_path('uploads/profile/'.$patient->profile))){
                unlink(public_path('uploads/profile/'.$patient->profile));
            }
            $file=$request->file('profile');
            $filename=time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile'),$filename);
            $photoPath=$filename;
        }
        $userData=[
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password'])
        ];
        $patient->user->update($userData);

        $patient->update([
            'age'=>$data['age'],
            'gender'=>$data['gender'],
            'number'=>$data['number'],
            'blood_group'=>$data['blood_group'],
            'disease'=>$data['disease'],
            'address'=>$data['address'] ?? null,
            'profile'=>$photoPath,
        ]);
        return redirect()->route('super-admin.patients')
        ->with('success','Patient Updated Successfully');
    }

    public function deletePatient(Patient $patient){
        if($patient->profile && file_exists(public_path('uploads/profile/'.$patient->profile))){
            unlink(public_path('uploads/profile/'.$patient->profile));
        }
        $user=$patient->user;
        $patient->delete();
        if($user){
            $user->delete();
        }
        return redirect()->route('super-admin.patients')->with('success','Patient Deleted Successfully!');
    }
    public function users()
    {
        return view('super-admin.users');
    }


    public function reports()
    {
        return view('super-admin.reports');
    }

    public function settings()
    {
        $user = Auth::user();

        return view('super-admin.settings', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profile_photo' => 'nullable|image',
        ]);
        if ($request->hasFile('profile_photo')) {

            if ($user->profile_photo && file_exists(public_path('super-admin/profile/' . $user->profile_photo))) {
                unlink(public_path('super-admin/profile/' . $user->profile_photo));
            }
            $file = $request->file('profile_photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('super-admin/profile'), $filename);
            $data['profile_photo'] = $filename;
        } else {
            $data['profile_photo'] = $user->profile_photo;
        }
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'profile_photo' => $data['profile_photo'],
        ]);
        return redirect()->route('super-admin.settings')->with('success', 'Profile Update Successfully');
    }
    public function updateSecurity(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:6',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is Incorrect.'
            ]);
        }
        $user->update([
            'password' => Hash::make($data['new_password'])
        ]);

        return redirect()->route('super-admin.settings')
            ->with('success', 'Password update Successfully');

    }
}


   