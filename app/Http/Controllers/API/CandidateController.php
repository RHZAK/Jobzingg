<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CandidateController extends BaseController
{     /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
       $Candidate_List=Candidate::all();
       $Candidate_List_Check=$this->send_Response($Candidate_List);

       if($Candidate_List_Check == true){

           return response()->json($Candidate_List_Check,200);

       }else{

           return response()->json($Candidate_List_Check,404);
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
        'country_ID'            => 'required',
        'name'                  => 'required',
        'phone'                 => 'required',
        'email'                 => 'required',
        'address'               => 'required',
        'description'           => 'required',
        'gender'                => 'required',
        'birthday'              => 'required',
        'year_first_experience' => 'required'
       ]);

        $Candidate_Create_Check=$this->send_Response($input);

        if($validator->fails() || $Candidate_Create_Check == false){

           return response()->json($Candidate_Create_Check,404);

       }
           $add = Candidate::create($input);
           return response()->json($add,200);
   }


   public function show($id)
   {
       $Candidate=Candidate::find($id);

       if(is_null($Candidate)){

           return response()->json($Candidate,404);

       }else{

           return response()->json($Candidate,200);

       }
   }


   public function update(Request $request, $id)
   {
       $Candidate=Candidate::find($id);

       if(is_null($Candidate)){
           return response()->json($Candidate,404);
       }

       $input=$request->all();

       $validator=validator::make($input,[
        'country_ID'            => 'required',
        'name'                  => 'required',
        'phone'                 => 'required',
        'email'                 => 'required',
        'address'               => 'required',
        'description'           => 'required',
        'gender'                => 'required',
        'birthday'              => 'required',
        'year_first_experience' => 'required'
       ]);

       if($validator->fails()){
            return $this->sendError('Please Validate Error',$validator->errors());
       }

        $Candidate->country_ID            = $input['country_ID'];
        $Candidate->name                  = $input['name'];
        $Candidate->phone                 = $input['phone'];
        $Candidate->email                 = $input['email'];
        $Candidate->address               = $input['address'];
        $Candidate->description           = $input['description'];
        $Candidate->gender                = $input['gender'];
        $Candidate->birthday              = $input['birthday'];
        $Candidate->year_first_experience = $input['year_first_experience'];

        $Candidate->update();

        return $this->send_Response($Candidate,' Updated successfully');
   }


   public function softDeletes($id)
   {
       $Candidate=Candidate::find($id);
       $Candidate_check=$this->send_Response($Candidate);

       if(is_null($Candidate)){

           return response()->json($Candidate_check,404);

       }else{

           $Candidate->delete();
           return response()->json($Candidate_check,200);

       }
   }

}
