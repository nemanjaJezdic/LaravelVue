<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        return view("home");
    }

    public function Register(Request $request){
        $user=new User();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:20',
            'surname' => 'required|string|min:3|max:20',
            'phone' => 'required|numeric',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'birthdate' => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $id=$user->insert_user($request);
       

        return response()->json(["success"=>"Welcome to our agency"]);
    }

    public function Login(Request $request){
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $credentials=$request->only('email','password');

        if(Auth::attempt($credentials)){
             $user=Auth::user();
             $request->session()->put("user",$user);
             return response()->json(["success"=>"something"]);
        }

        return response()->json(['msg'=> "Incorect password or email"]);
    }

    public function Logout(Request $request){
        
        $request->session()->remove("user");
        return redirect()->route("home");
    }
}
