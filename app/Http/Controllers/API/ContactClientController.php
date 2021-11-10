<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\ContactClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactClientController extends BaseController
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ContactClient_List=ContactClient::all();
        $ContactClient_List_Check=$this->send_Response($ContactClient_List);

        if($ContactClient_List_Check == true){

            return response()->json($ContactClient_List_Check,200);

        }else{

            return response()->json($ContactClient_List_Check,404);
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
            'client_ID'  => 'required',
            'first_name' => 'required',
            'last_name'  => 'required',
            'post'       => 'required',
            'email'      => 'required',
            'phone'      => 'required',
        ]);

        $ContactClient_Create_Check=$this->send_Response($input);

        if($validator->fails() || $ContactClient_Create_Check == false){

            return response()->json($ContactClient_Create_Check,404);

        }
            $add = ContactClient::create($input);
            return response()->json($add,200);
    }


    public function show($id)
    {
        $ContactClient=ContactClient::find($id);

        if(is_null($ContactClient)){

            return response()->json($ContactClient,404);

        }else{

            return response()->json($ContactClient,200);

        }
    }


    public function update(Request $request, $id)
    {
        $ContactClient=ContactClient::find($id);

        if(is_null($ContactClient)){
            return response()->json($ContactClient,404);
        }

        $input=$request->all();

        $validator=validator::make($input,[
            'client_ID'  => 'required',
            'first_name' => 'required',
            'last_name'  => 'required',
            'post'       => 'required',
            'email'      => 'required',
            'phone'      => 'required',
         ]);

        if($validator->fails()){
             return $this->sendError('Please Validate Error',$validator->errors());
        }

         $ContactClient->client_ID   = $input['client_ID'];
         $ContactClient->first_name  = $input['first_name'];
         $ContactClient->last_name   = $input['last_name'];
         $ContactClient->post        = $input['post'];
         $ContactClient->phone       = $input['phone'];
         $ContactClient->email       = $input['email'];
         $ContactClient->phone       = $input['phone'];

         $ContactClient->update();

         return $this->send_Response($ContactClient,' Updated successfully');
    }


    public function softDeletes($id)
    {
        $ContactClient=ContactClient::find($id);
        $ContactClient_check=$this->send_Response($ContactClient);

        if(is_null($ContactClient)){

            return response()->json($ContactClient_check,404);

        }else{

            $ContactClient->delete();
            return response()->json($ContactClient_check,200);

        }
    }

}
