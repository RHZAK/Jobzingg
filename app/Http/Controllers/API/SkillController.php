<?php

namespace App\Http\Controllers\API;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SkillController extends BaseController
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skill_List=Skill::all();
        $skill_List_Check=$this->send_Response($skill_List);

        if($skill_List_Check == true){

            return response()->json($skill_List_Check,200);

        }else{

            return response()->json($skill_List_Check,404);
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
            'skill_name'    => 'required',

        ]);

        $Skill_Create_Check=$this->send_Response($input);

        if($validator->fails() || $Skill_Create_Check == false){

            return response()->json($Skill_Create_Check,404);

        }
            $add = Skill::create($input);
            return response()->json($add,200);
    }


    public function show($id)
    {
        $Skill=Skill::find($id);

        if(is_null($Skill)){

            return response()->json($Skill,404);

        }else{

            return response()->json($Skill,200);

        }
    }


    public function update(Request $request, $id)
    {
        $Skill=Skill::find($id);

        if(is_null($Skill)){
            return response()->json($Skill,404);
        }

        $input=$request->all();

        $validator=validator::make($input,[
            'skill_name'    => 'required',
         ]);

        if($validator->fails()){
             return $this->sendError('Please Validate Error',$validator->errors());
        }

         $Skill->skill_name     = $input['skill_name'];


         $Skill->update();

         return $this->send_Response($Skill,' Updated successfully');
    }


    public function softDeletes($id)
    {
        $Skill=Skill::find($id);
        $Skill_check=$this->send_Response($Skill);

        if(is_null($Skill)){

            return response()->json($Skill_check,404);

        }else{

            $Skill->delete();
            return response()->json($Skill_check,200);

        }
    }

}
