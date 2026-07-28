<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function adminLogin(Request $request)
    {
      if(Auth::check() && Auth::user()->role === 'super-admin'){
          return redirect()->route('super-admin.dashboard');
      }
      $credentials = $request->validate([
      'email'=>'required|email',
        'password'=>'required'
      ]);

      if(Auth::attempt($credentials)){

     $user = Auth::user();
       if($user->role == 'super-admin')
        {
            $request->session()->regenerate();
            return redirect()->intended(route('super-admin.dashboard'));
        }
        Auth::logout();
      }
        return back()->withErrors([
         'email' => 'this credentials do not match our records',
        ])->onlyInput('email');
    }

    // login for doctor
    public function doctorLogin(Request $request){
      if(Auth::check() && Auth::user()->role === 'doctor'){
          return redirect()->route('doctor.dashboard');
      }
      $credentials = $request->validate([
          'email'=>'required|email',
          'password'=>'required'
      ]);
      if(Auth::attempt($credentials)){
        $user = Auth::user();
        if($user->role =='doctor'){
          $request->session()->regenerate();
          return redirect()->intended(route('doctor.dashboard'));
        }
        Auth::Logout();
      }
      return back()->withErrors([
         'email'=>'this credentials do not match our records'
      ])->onlyInput('email');
    }

    public function doctorRegister(Request $request){
       $data = $request->validate([
       'name'=>'required',
       'department'=>'required',
       'license'=>'required',
       'email'=>'required|email|unique:users',
       'password'=>'required'
       ]);

       $user = User::create([
        'name' => $data['name'],
        'email'=>$data['email'],
        'password'=>Hash::make($data['password']),
        'role'=>'doctor'
       ]);

       $user->doctor()->create([
             'department'=>$data['department'],
              'license_id'=>$data['license']
       ]);
      //  Auth::login($user);
       return redirect()->route('doctor.login');
    }
     // patient register
     public function patientRegister(Request $request){
        $data = $request->validate([
          'name' =>'required',
          'email'=>'required|email|unique:users',
          'password'=>'required',
          'age' =>'required',
          'gender'=>'required',
          'blood_group' =>'required'
        ]);

        $user = User::create([
              'name' => $data['name'],
              'email' =>$data['email'],
              'password' =>Hash::make($data['password']),
              'role'=>'patient'
        ]);

        $user->patient()->create([
                 'age' =>$data['age'],
                 'gender'=>$data['gender'],
                 'blood_group'=>$data['blood_group']
        ]);
        return redirect()->route('patient.login');
     }

     public function patientLogin(Request $request){
           if(Auth::check() && Auth::user()->role ==='patient'){
            return redirect()->route('patient.dashboard');
           }
           $credentials = $request->validate([
            'email'=>'required|email',
            'password'=>'required'
           ]);

           if(Auth::attempt($credentials)){
            $user = Auth::User();
            if($user->role === 'patient'){
              $request->session()->regenerate();
              return redirect()->intended(route('patient.dashboard'));
            }
            Auth::logout();
           }
           return back()->withErrors([  
            'email'=>'this credentials do not match our records'
           ])->onlyInput('email');
     }

     public function logout(Request $request)
     {
       Auth::logout();
       $request->session()->invalidate();
       $request->session()->regenerateToken();

       return redirect()->route('portal-hub');
     }

}
