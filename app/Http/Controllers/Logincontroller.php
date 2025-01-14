<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Logincontroller extends Controller
{
    //
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }
    
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'docente';
        $user->save();
    
        Auth::login($user);
        return redirect(route('docentevista.index'));
    }
    
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }
    
        $credentials = [
            "email" => $request->email,
            "password" => $request->password
        ];
        $remember = ($request->has('remember') ? true : false);
    
        if(Auth::attempt($credentials, $remember)){
            $request->session()->regenerate();
            
            // Redirigir según el rol del usuario
            if(Auth::user()->role == 'docente'){
                return redirect()->intended(route('docentevista.index'));
            } else {
                return redirect()->intended(route('home'));
            }            
        } else {
            return redirect('login')->withErrors(['email' => 'Credenciales incorrectas']);
        }
    }
    
    public function logout(Request $request){
        
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login'));
    }
}
