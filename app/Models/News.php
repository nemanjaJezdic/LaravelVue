<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class News extends Model
{
    use HasFactory;

    public function getAll(){
        return DB::table('news')->select('news.*',DB::raw('CONCAT(users.name," ",users.surname) AS fullname'))
                   ->join('users','news.user_id','=','users.id')
                   ->orderBy('id')
                   ->get();
    }
    
    public function storeNews($request){
        return DB::table("news")->insert([
            'user_id' => rand(1,7),
            'title'=>$request->title,
            'desc'=>$request->desc,
            'text'=>$request->text,
            'cover'=>$request->imgname,
            'alt'=>"img8",
            'news_type'=>$request->type,
            'status'=>'in process',
            'created_at'=> date('Y-m-d H:i:s')
       ]);
    }
    public function editNews($request){
        return DB::table("news")->where('id',$request->id)
                                ->update([
                                      'title' => $request->title,
                                      'desc' => $request->desc,
                                      'text'=> $request->text,
                                      'news_type' => $request->type,
                                      'cover'=>$request->imgname
                                 ]);
    }
    public function editNewsNoimg($request){
        return DB::table("news")->where('id',$request->id)
                                ->update([
                                      'title' => $request->title,
                                      'desc' => $request->desc,
                                      'text'=> $request->text,
                                      'news_type' => $request->type,
                                 ]);
    }

    public function getOne($request){
        return DB::table('news')->select('news.*',DB::raw('CONCAT(users.name," ",users.surname) AS fullname'))
                   ->join('users','news.user_id','=','users.id')
                   ->where('news.id',$request->id)
                   ->first();
    }

    public function deleteNews($id){
        return DB::table("news")->where('id',$id)->delete();
    }
    public function publish($id){
        return DB::table("news")->where('id',$id)
                                ->update([
                                      'status' => 'published',
                                      'published_at' => date('Y-m-d H:i:s')
                                 ]);
    }
    public function archive($id){
        return DB::table("news")->where('id',$id)
                                ->update([
                                      'status' => 'archived',
                                      'archived_at' => date('Y-m-d H:i:s')
                                 ]);
    }
}
