<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //Show Registeration Form
    public function create(){
        return view('users.create');
    }
    // Store Registeration Form
    public static function store(Request $request){
        // dd($request->hasFile('logo'));
            $formList = $request->validate([
                 'name' => ['required','min:3'],
                 'email' => ['required' , 'email', Rule::unique('users','email')],
                 'password' => ['required','confirmed','min:6']
     
            ]);
     
            //hash password
            $formList['password'] = bcrypt($formList['password']);
            
            //Create User
            $User = User::create($formList);
            // Login
            auth()->login($User);

            return redirect('/')->with('message' , 'User Created And Logged in Successfuly');
     
         }

         // Logout
         public function logout(Request $request) {
            auth()->logout();
    
            $request->session()->invalidate();
            $request->session()->regenerateToken();
    
            return redirect('/')->with('message', 'You have been logged out!');
    
        }
        
        // Login Form 
        public function login(){
            return view('users.login');
        }
        // Authenticate User
        public function authenticate(Request $request) {
            $formFields = $request->validate([
                'email' => ['required', 'email'],
                'password' => 'required'
            ]);
    
            if(auth()->attempt($formFields)) {
                $request->session()->regenerate();
    
                return redirect('/')->with('message', 'You are now logged in!');
            }
    
            return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
        }
    
}
