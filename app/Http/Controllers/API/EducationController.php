<?php

namespace App\Http\Controllers\API;

use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EducationController extends BaseController
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Education_List=Education::all();
        $Education_List_Check=$this->send_Response($Education_List);

        if($Education_List_Check == true){

            return response()->json($Education_List_Check,200);

        }else{

            return response()->json($Education_List_Check,404);
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
            'candidate_id' => 'required',
            'school'       => 'required',
            'degree'       => 'required',
            'industry'     => 'required',
            'start_date'   => 'required',
            'score'        => 'required',
            'address'      => 'required',
            'description'  => 'required',
        ]);

        $Education_Create_Check=$this->send_Response($input);

        if($validator->fails() || $Education_Create_Check == false){

            return response()->json($Education_Create_Check,404);

        }
            $add = Education::create($input);
            return response()->json($add,200);
    }


    public function show($id)
    {
        $Education=Education::find($id);

        if(is_null($Education)){

            return response()->json($Education,404);

        }else{

            return response()->json($Education,200);

        }
    }


    public function update(Request $request, $id)
    {
        $Education=Education::find($id);

        if(is_null($Education)){
            return response()->json($Education,404);
        }

        $input=$request->all();

        $validator=validator::make($input,[
            'candidate_id' => 'required',
            'school'       => 'required',
            'degree'       => 'required',
            'industry'     => 'required',
            'start_date'   => 'required',
            'score'        => 'required',
            'address'      => 'required',
            'description'  => 'required',
         ]);

        if($validator->fails()){
             return $this->sendError('Please Validate Error',$validator->errors());
        }

         $Education->candidate_id = $input['candidate_id'];
         $Education->school       = $input['school'];
         $Education->degree       = $input['degree'];
         $Education->industry     = $input['industry'];
         $Education->start_date   = $input['start_date'];
         $Education->score        = $input['score'];
         $Education->address      = $input['address'];
         $Education->description  = $input['description'];

         $Education->update();

         return $this->send_Response($Education,' Updated successfully');
    }


    public function softDeletes($id)
    {
        $Education=Education::find($id);
        $Education_check=$this->send_Response($Education);

        if(is_null($Education)){

            return response()->json($Education_check,404);

        }else{

            $Education->delete();
            return response()->json($Education_check,200);

        }
    }
}
