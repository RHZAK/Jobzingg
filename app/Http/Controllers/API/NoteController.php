<?php

namespace App\Http\Controllers\API;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoteController extends BaseController
{
           /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Note_List=Note::all();
        $Note_List_Check=$this->send_Response($Note_List);

        if($Note_List_Check == true){

            return response()->json($Note_List_Check,200);

        }else{

            return response()->json($Note_List_Check,404);
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
            'note'         => 'required'
        ]);

        $Note_Create_Check=$this->send_Response($input);

        if($validator->fails() || $Note_Create_Check == false){

            return response()->json($Note_Create_Check,404);

        }
            $add = Note::create($input);
            return response()->json($add,200);
    }


    public function show($id)
    {
        $Note=Note::find($id);

        if(is_null($Note)){

            return response()->json($Note,404);

        }else{

            return response()->json($Note,200);

        }
    }


    public function update(Request $request, $id)
    {
        $Note=Note::find($id);

        if(is_null($Note)){
            return response()->json($Note,404);
        }

        $input=$request->all();

        $validator=validator::make($input,[
            'candidate_id' => 'required',
            'note'         => 'required'
         ]);

        if($validator->fails()){
             return $this->sendError('Please Validate Error',$validator->errors());
        }

         $Note->candidate_id = $input['candidate_id'];
         $Note->note         = $input['note'];


         $Note->update();

         return $this->send_Response($Note,' Updated successfully');
    }


    public function softDeletes($id)
    {
        $Note=Note::find($id);
        $Note_check=$this->send_Response($Note);

        if(is_null($Note)){

            return response()->json($Note_check,404);

        }else{

            $Note->delete();
            return response()->json($Note_check,200);

        }
    }

}
