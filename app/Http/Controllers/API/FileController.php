<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\File;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\support\str;

class FileController extends BaseController
{
          /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $File_List=File::all();
        $File_List_Check=$this->send_Response($File_List);

        if($File_List_Check == true){

            return response()->json($File_List_Check,200);

        }else{

            return response()->json($File_List_Check,404);
        }
    }

    /**
     * Store Candidates Files in the Database and also in path='public/files/candidate'
     */

    public function storeCandidate(Request $request)
    {
        $input = $request->all();
        $validator = validator::make($input,[
            'file' => 'required',
        ]);

        $store_Create_Check=$this->send_Response($input);

        if($validator->fails() || $store_Create_Check == false){

           return response()->json($store_Create_Check,404);

        }

        $file    = $request->file;
        $newfile = Str::uuid()->toString();

        $file->move('files/candidate',$newfile);

        $addfile=File::create([
            "id"            => $newfile,
            "type"          => 'resume',
            "model"         => 'candidate',
            'original_name' => $file->getClientOriginalName(),            // We have to use the auth to know the id of the selected position
            "model_id"      => 'b51a93c9-1800-4007-9f85-60964d49494f',
            "file"          => 'files/candidate/'.$newfile
        ]);
         return response()->json($addfile,200);

    }

     /**
     * Store contract Files in the Database and also in path='public/files/position'
     */

    public function storePosition(Request $request)
    {
        $input = $request->all();
        $validator = validator::make($input,[
            'file' => 'required',
        ]);

        $store_Create_Check=$this->send_Response($input);

        if($validator->fails() || $store_Create_Check == false){

           return response()->json($store_Create_Check,404);

        }

        $file    = $request->file;
        $newfile = Str::uuid()->toString();
        $file->move('files/position',$newfile);

        $addfile=File::create([
            "id"            => $newfile,
            "type"          => 'contract',
            "model"         => 'position',
            'original_name' => $file->getClientOriginalName(),  // We have to use the auth to know the user and his Candidate
            "model_id"      => '8cd2714e-55bc-4f7d-8e02-94e82315c7aa',
            "file"          => 'files/position/'.$newfile
        ]);
         return response()->json($addfile,200);

    }


    public function show($id)
    {
        $File=File::find($id);

        if(is_null($File)){

            return response()->json($File,404);

        }else{

            return response()->json($File,200);

        }
    }

    public function softDeletes($id)
    {
        $File=File::find($id);
        $File_check=$this->send_Response($File);

        if(is_null($File)){

            return response()->json($File_check,404);

        }else{

            $File->delete();
            return response()->json($File_check,200);

        }
    }

}
