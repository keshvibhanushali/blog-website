<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create(){
        return view('register');
    }

    public function store(RegisterRequest $request){
        try {
        $validated = $request->validated();
        $user = new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=$request->password;
        $user->save();
        $user->assignRole('reader');
        }
        catch(Exception $e) {
            dd($e->getMessage());
        }
        return redirect()->route('login');
    }
}
