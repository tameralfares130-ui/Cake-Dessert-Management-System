<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
class AuthController extends Controller {
    public function loginForm(){return view('auth.login');}
    public function registerForm(){return view('auth.register');}
    public function register(Request $request){
        $data=$request->validate(['name'=>['required','string','max:100'],'email'=>['required','email','max:255','unique:users,email'],'password'=>['required','confirmed',Password::min(8)]]);
        $user=User::create($data); // role defaults to registered; no public admin escalation
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('home')->with('success','Registration successful.');
    }
    public function login(Request $request){
        $credentials=$request->validate(['email'=>['required','email'],'password'=>['required','string']]);
        if(Auth::attempt($credentials)){$request->session()->regenerate();return redirect()->intended(route('home'));}
        return back()->withErrors(['email'=>'These credentials do not match our records.'])->onlyInput('email');
    }
    public function logout(Request $request){Auth::logout();$request->session()->invalidate();$request->session()->regenerateToken();return redirect()->route('home')->with('success','Logged out.');}
}
