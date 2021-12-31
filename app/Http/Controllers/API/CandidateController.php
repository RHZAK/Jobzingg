<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Imports\candidateImport;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Exports\candidateExport;
use Illuminate\Support\Facades\DB;

class CandidateController extends BaseController
{
  /**
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

   //show candidate of auth user

   public function usercandidate()
   {
       $ContactClient_List = DB::table('candidates')
       ->where('candidates.user_id',Auth::user()->id)->get();

       $ContactClient_List_Check=$this->send_Response($ContactClient_List);

       if($ContactClient_List_Check == true){

           return response()->json($ContactClient_List_Check,200);

       }else{

           return response()->json($ContactClient_List_Check,404);
       }
   }

   public function store(Request $request)
   {

       $input = $request->all();
       $validator = validator::make($input,[
        'country_id'            => 'required',
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

        $add=Candidate::create([
            "user_id"      => Auth::user()->id,
            "country_id"   => $request->country_id,
            "name"         => $request->name,
            "phone"        => $request->phone,
            "email"        => $request->email,
            "address"      => $request->address,
            'description'           => $request->description,
            'gender'                => $request->gender,
            'birthday'              => $request->birthday,
            'year_first_experience' => $request->year_first_experience
        ]);
           return response()->json($add,200);
    }


   public function show($id)
   {
       $Candidate=Candidate::find($id);

       if(is_null($Candidate)){

           return response()->json($Candidate,404);

       }else{

          // $file=getCandidateResume($id);
          $candidate['file']=getCandidateResume($id);

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
        'country_id'            => 'required',
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

       if($Candidate->user_id != Auth::user()->id){
           return $this->sendError('Client Does Not Belong To You !!');
       }
        $Candidate->country_id            = $input['country_id'];
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

           if($Candidate->user_id != Auth::user()->id){
             return $this->sendError('Client Does Not Belong To You !!');
            }

        $Candidate->delete();
        return response()->json($Candidate_check,200);

       }
   }

    //Import Candidate List In Excel Format

    public function importcandidate(Request $request){
        Excel::import( new candidateImport,$request->file);
        return response()->json('Success',200);
    }

    // Export Data Excel File

    public function exportExcel(){
        return Excel::download(new CandidateExport,'candidate.xlsx');
    }

}
