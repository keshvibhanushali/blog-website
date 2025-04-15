<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Exception;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function create(){
        // dd("hello");
        return view('login');
    }
    
    public function loginMatch(LoginRequest $request){
        try {
            $validated = $request->validated();
            if(Auth::attempt($validated)){
                if(Auth::user()->hasRole('admin')){
                    return redirect('/dashboard');
                }
                else {
                    return redirect('/');
                }
            }
            else{
                return redirect('/login')->with('Error');
            }
        }
        catch(Exception $e){
            dd($e->getMessage());
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }

    public function dashboard(){
        return view('index');
    }
}
