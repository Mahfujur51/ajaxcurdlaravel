<?php

namespace App\Http\Controllers;

use App\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
   public  function  index(){
       $data=Teacher::orderBy('id','desc')->get();
       return response()->json($data);
   }
   public  function  store(Request $request){
       $request->validate([
           'name'=>'required',
           'title'=>'required',
           'institute'=>'required',
       ]);
       $data = new Teacher();
       $data->name=$request->name;
       $data->title=$request->title;
       $data->institute=$request->institute;
       $data->save();
       return response()->json($data);

   }
   public  function  edit($id){
       $data=Teacher::findOrFail($id);
       return response()->json($data);

   }
   public  function  update(Request $request,$id){
       $request->validate([
           'name'=>'required',
           'title'=>'required',
           'institute'=>'required',
       ]);
       $data=Teacher::findOrFail($id);
       $data->name=$request->name;
       $data->title=$request->title;
       $data->institute=$request->institute;
       $data->update();
       return response()->json($data);

   }
   public  function  delete($id){
       $data=Teacher::findOrFail($id);
       $data->delete();
       return response()->json($data);


   }
}
