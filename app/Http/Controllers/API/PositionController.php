<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PositionController extends BaseController
{
      /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $Position_List=Position::all();
        $Position_List_Check=$this->send_Response($Position_List);

        if($Position_List_Check == true){

            return response()->json($Position_List_Check,200);

        }else{

            return response()->json($Position_List_Check,404);
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
            'job_id'       => 'required',
            'candidate_id' => 'required',
            'status'       => 'required',
        ]);

         $Position_Create_Check=$this->send_Response($input);

         if($validator->fails() || $Position_Create_Check == false){

            return response()->json($Position_Create_Check,404);

        }
            $add = Position::create($input);
            return response()->json($add,200);
    }


    public function show($id)
    {
        $Position=Position::find($id);

        if(is_null($Position)){

            return response()->json($Position,404);

        }else{

            return response()->json($Position,200);

        }
    }


    public function update(Request $request, $id)
    {
        $Position=Position::find($id);

        if(is_null($Position)){
            return response()->json($Position,404);
        }

        $input=$request->all();

        $validator=validator::make($input,[
         'job_id'       => 'required',
         'candidate_id' => 'required',
         'status'       => 'required',
        ]);

        if($validator->fails()){
             return $this->sendError('Please Validate Error',$validator->errors());
        }

         $Position->job_id        = $input['job_id'];
         $Position->candidate_id  = $input['candidate_id'];
         $Position->status        = $input['status'];

         $Position->update();

         return $this->send_Response($Position,' Updated successfully');
    }


    public function softDeletes($id)
    {
        $Position=Position::find($id);
        $Position_check=$this->send_Response($Position);

        if(is_null($Position)){

            return response()->json($Position_check,404);

        }else{

            $Position->delete();
            return response()->json($Position_check,200);

        }
    }
 }
