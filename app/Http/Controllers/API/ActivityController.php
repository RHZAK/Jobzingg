<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

   //show candidate of auth user

   public function useractivitylist()
   {
       $useractivity_List = DB::table('activities')
       ->where('activities.user_id',Auth::user()->id)->get();

       $useractivity_List_Check=$this->send_Response($useractivity_List);

       if($useractivity_List_Check == true){

           return response()->json($useractivity_List_Check,200);

       }else{

           return response()->json($useractivity_List_Check,404);
       }
   }

   public function store(Request $request)
   {

       $input = $request->all();
       $validator = validator::make($input,[
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
           $add=Activity::create([
            "user_id"      => Auth::user()->id,
            'candidate_id' => $request->candidate_id,
            'title'        => $request->title,
            'type'         => $request->type,
            'date'         => $request->date,
            'time'         => $request->time,
            'online_url'   => $request->online_url,
            'importance'   => $request->importance,
        ]);
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

       if($Activity->user_id != Auth::user()->id){
        return $this->sendError('Activity Does Not Belong To You !!');
       }

       $input=$request->all();

       $validator=validator::make($input,[
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

           if($Activity->user_id != Auth::user()->id){
            return $this->sendError('Activity Does Not Belong To You !!');
           }

           $Activity->delete();
           return response()->json($Activity_check,200);

       }
   }

}
