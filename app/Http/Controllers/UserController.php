<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function index(UsersDataTable $dataTable){
        return $dataTable->render('admin.user.index');
    }

    public function create(){
        return view('admin.user.create');
    }

    public function store(Request $request){
        $user=new User;
        $user->name= $request->name;
        $user->email= $request->email;
        $user->dob= $request->dob;
        $user->password = $user->name."123";
        $user->save();

        $data=response()->json([
            "message"=>"success",
            "status"=>200,
        ]
        );
        return $data;
    }

    public function edit(User $user){
     
        return view('admin.user.edit',compact('user'));
    }

    public function update(User $user,Request $request){
        $data = $request->all();
        $user->update($data);
        $response=response()->json([
            "message"=>"success",
            "status"=>200,
        ]
        );
        return $response;
    }

    public function delete($id){
        User::where('id',$id)->delete();
        $response=response()->json([
            "message"=>"success",
            "status"=>200,
        ]
        );
        return $response;
    }

    public function removeAll(Request $request){
        User::whereIn('id',$request->ids)->delete();
    }
}
