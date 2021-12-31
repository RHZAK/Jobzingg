<?php

namespace App\Http\Controllers\API;

use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LevelController extends BaseController
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Level_List=Level::all();
        $Level_List_Check=$this->send_Response($Level_List);

        if($Level_List_Check == true){

            return response()->json($Level_List_Check,200);

        }else{

            return response()->json($Level_List_Check,404);
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
            'skill_id'     => 'required',
            'level'        => 'required',
        ]);

        $Level_Create_Check=$this->send_Response($input);

        if($validator->fails() || $Level_Create_Check == false){

            return response()->json($Level_Create_Check,404);

        }
            $add = Level::create($input);
            return response()->json($add,200);
    }


    public function show($id)
    {
        $Level=Level::find($id);

        if(is_null($Level)){

            return response()->json($Level,404);

        }else{

            return response()->json($Level,200);

        }
    }


    public function update(Request $request, $id)
    {
        $Level=Level::find($id);

        if(is_null($Level)){
            return response()->json($Level,404);
        }

        $input=$request->all();

        $validator=validator::make($input,[
            'candidate_id' => 'required',
            'skill_id'     => 'required',
            'level'        => 'required',
         ]);

        if($validator->fails()){
             return $this->sendError('Please Validate Error',$validator->errors());
        }

         $Level->candidate_id = $input['candidate_id'];
         $Level->skill_name   = $input['skill_name'];
         $Level->level        = $input['level'];

         $Level->update();

         return $this->send_Response($Level,' Updated successfully');
    }


    public function softDeletes($id)
    {
        $Level=Level::find($id);
        $Level_check=$this->send_Response($Level);

        if(is_null($Level)){

            return response()->json($Level_check,404);

        }else{

            $Level->delete();
            return response()->json($Level_check,200);

        }
    }

}
