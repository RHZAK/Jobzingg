<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActivityController extends BaseController
{
      /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
       $Activity_List=Activity::all();
       $Activity_List_Check=$this->send_Response($Activity_List);

       if($Activity_List_Check == true){

           return response()->json($Activity_List_Check,200);

       }else{

           return response()->json($Activity_List_Check,404);
       }
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

   public function store(Request $request)
   {

       $input = $request->all();
       $validator = validator::make($input,[
        'user_id'      => 'required',
        'candidate_id' => 'required',
        'title'        => 'required',
        'type'         => 'required',
        'date'         => 'required',
        'time'         => 'required',
        'online_url'   => 'required',
        'importance'   => 'required',
       ]);

        $Activity_Create_Check=$this->send_Response($input);

        if($validator->fails() || $Activity_Create_Check == false){

           return response()->json($Activity_Create_Check,404);

       }
           $add = Activity::create($input);
           return response()->json($add,200);
   }


   public function show($id)
   {
       $Activity=Activity::find($id);

       if(is_null($Activity)){

           return response()->json($Activity,404);

       }else{

           return response()->json($Activity,200);

       }
   }


   public function update(Request $request, $id)
   {
       $Activity=Activity::find($id);

       if(is_null($Activity)){
           return response()->json($Activity,404);
       }

       $input=$request->all();

       $validator=validator::make($input,[
        'user_id'      => 'required',
        'candidate_id' => 'required',
        'title'        => 'required',
        'type'         => 'required',
        'date'         => 'required',
        'time'         => 'required',
        'online_url'   => 'required',
        'importance'   => 'required',
       ]);

       if($validator->fails()){
            return $this->sendError('Please Validate Error',$validator->errors());
       }

        $Activity->user_id        = $input['user_id'];
        $Activity->candidate_id   = $input['candidate_id'];
        $Activity->title          = $input['title'];
        $Activity->type           = $input['type'];
        $Activity->date           = $input['date'];
        $Activity->time           = $input['time'];
        $Activity->online_url     = $input['online_url'];
        $Activity->importance     = $input['importance'];


        $Activity->update();

        return $this->send_Response($Activity,' Updated successfully');
   }


   public function softDeletes($id)
   {
       $Activity=Activity::find($id);
       $Activity_check=$this->send_Response($Activity);

       if(is_null($Activity)){

           return response()->json($Activity_check,404);

       }else{

           $Activity->delete();
           return response()->json($Activity_check,200);

       }
   }

}
