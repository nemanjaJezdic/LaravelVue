<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Insurance extends Model
{
    use HasFactory;

    public function storeIn($request){
       return DB::table("insurances")->insertGetId([
            'name' => $request->name,
            'surname'=>$request->surname,
            'phone'=>$request->phone,
            'type'=>$request->type,
            'start_date'=> date('Y-m-d H:i:s',strtotime($request->startdate)),
            'end_date'=>date('Y-m-d H:i:s',strtotime($request->enddate)),
            'user_id'=>rand(1,7)
       ]);
    }
    public function getAll(){
        return DB::table('insurances')
        ->get();
    }
}
