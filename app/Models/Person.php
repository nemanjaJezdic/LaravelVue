<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Person extends Model
{
    use HasFactory;

    public function storePerson($request,$id){
        return DB::table('persons')->insert([
           'name'=> $request["name2"],
           'surname'=> $request["surname2"],
           'birth_date'=>date('Y-m-d H:i:s',strtotime($request["birthdate"])),
           'insurance_id'=>$id
        ]);
    }
}
