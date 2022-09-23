<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use App\Models\News;
use App\Models\Person;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    protected $data;
    public function index(){
        return view("form");
    }

    public function storeInsurance(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:20',
            'surname' => 'required|string|min:3|max:20',
            'phone' => 'required',
            'type' => 'required',
            'startdate' => 'required',
            'enddate' => 'required',
            'persons'=> 'array',
            'persons.*.birthdate' => 'required',
            'persons.*.name2' => 'required|string|min:3|max:20',
            'persons.*.surname2' => 'required|string|min:3|max:20'
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $insurance=new Insurance();
        $idins=$insurance->storeIn($request);
        $person=new Person();

        if(!empty($request->persons)){
            foreach($request->persons as $p){
                $person->storePerson($p,$idins);
            }
        }
        return response()->json(['success'=>'Record is successfully added']);
    }

    public function adminList(){
        return view("admin");
    }

    public function adminInsurance(Request $request){
        $insurances=new Insurance();
        $result=$insurances->getAll();

        if($request->ajax()){
            return response()->json($result);
        }

        return view("adminins",[
            'insurances'=>$result
        ]);
    }

    public function adminNews(Request $request){
        $news=new News();
        $result=$news->getAll();

        if($request->ajax()){
            return response()->json($result);
        }

        return view("adminnews");
    }

    public function storeNews(Request $request){
        $news=new News();

        if($request->hasFile('img')){
            $file=$request->file('img');
            $file_name=time().$file->getClientOriginalName();
            $file->move(public_path('images'),$file_name);
            return response()->json($file_name);
        }
        if($request->id!=0 && !empty($request->imgname)){
            $news->editNews($request);
        }
        if($request->id!=0){
            $news->editNewsNoimg($request);        
        }
        if($request->id==0 && !empty($request->imgname)){
            $news->storeNews($request);         
        }
        return response()->json(['success'=>'News is successfully added']);      
    }

    public function adminNewsOne(Request $request){
        $news=new News();
        $result=$news->getOne($request);
        
        if($request->ajax()){
            return response()->json($result);
        }
    }
    public function deleteNews($id){
        $news=new News();

        $news->deleteNews($id);

        $result=$news->getAll();

        return response()->json($result);
    }
    public function publishNews($id){
        $news=new News();

       $news->publish($id);

        $result=$news->getAll();

        return response()->json($result);
    }

    public function archiveNews($id){
        $news=new News();

        $news->archive($id);
 
         $result=$news->getAll();
 
         return response()->json($result);
    }
}
