<?php

namespace App\Http\Controllers\API;

use App\Models\Contract;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\support\str;

class ContractController extends BaseController
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Contract_List=Contract::all();
        $Contract_List_Check=$this->send_Response($Contract_List);

        if($Contract_List_Check == true){

            return response()->json($Contract_List_Check,200);

        }else{

            return response()->json($Contract_List_Check,404);
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
            'position_id' => 'required',
            'type'        => 'required',
            'file'        => 'required'
        ]);

        $client_Create_Check=$this->send_Response($input);

        if($validator->fails() || $client_Create_Check == false){

            return response()->json($client_Create_Check,404);

        }

        $file    = $request->file;
        $newfile = Str::uuid()->toString();

        $file->move('Contract',$newfile);

        $addContract=Contract::create([
            "id"            => $newfile,
            "position_id"   => $request->position_id,
            "type"          => $request->type,
            'original_name' => $file->getClientOriginalName(),
            "file"          => 'Contract/'.$newfile
        ]);
            return response()->json($addContract,200);
    }


    public function show($id)
    {
        $Contract=Contract::find($id);

        if(is_null($Contract)){

          return response()->json($Contract,404);

        }else{

          return response()->json($Contract,200);

        }
    }

    public function softDeletes($id)
    {
        $Contract=Contract::find($id);

        $Contract_check=$this->send_Response($Contract);

        if(is_null($Contract)){

            return response()->json($Contract_check,404);

        }else{

            $Contract->delete();
            return response()->json($Contract_check,200);

        }
    }

}
