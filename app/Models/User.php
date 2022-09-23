<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    public function getAll(){
        return DB::table('users')->get();
    }

    public function getOne($id){
        return DB::table('users')->where('id',$id)->first();
    }

    public function insert_user($request){
        return DB::table('users')->insertGetId([
             'email'=>$request->email,
             'password'=>Hash::make($request->password),
             'name'=>$request->name,
             'surname'=>$request->surname,
             'phone'=>$request->phone,
             'birth_date'=>date('Y-m-d H:i:s',strtotime($request->birthdate)),
             'role_id'=>2,
        ]);
    }
}
