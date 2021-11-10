<?php

namespace App\Http\Controllers\API;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class ClientController extends BaseController
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client_List=client::all();
        $client_List_Check=$this->send_Response($client_List);

        if($client_List_Check == true){

            return response()->json($client_List_Check,200);

        }else{

            return response()->json($client_List_Check,404);
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
            'user_ID'    => 'required',
            'country_ID' => 'required',
            'name'       => 'required',
            'email'      => 'required',
            'phone'      => 'required',
            'address'    => 'required',
            'image'      => 'required'
        ]);

        $client_Create_Check=$this->send_Response($input);

        if($validator->fails() || $client_Create_Check == false){

            return response()->json($client_Create_Check,404);

        }
            $add = client::create($input);
            return response()->json($add,200);
    }


    public function show($id)
    {
        $client=client::find($id);

        if(is_null($client)){

            return response()->json($client,404);

        }else{

            return response()->json($client,200);

        }
    }


    public function update(Request $request, $id)
    {
        $client=client::find($id);

        if(is_null($client)){
            return response()->json($client,404);
        }

        $input=$request->all();

        $validator=validator::make($input,[
            'user_ID'    => 'required',
            'country_ID' => 'required',
            'name'       => 'required',
            'email'      => 'required',
            'phone'      => 'required',
            'address'    => 'required',
            'image'      => 'required'
         ]);

        if($validator->fails()){
             return $this->sendError('Please Validate Error',$validator->errors());
        }

         $client->user_ID     = $input['user_ID'];
         $client->country_ID  = $input['country_ID'];
         $client->name        = $input['name'];
         $client->email       = $input['email'];
         $client->phone       = $input['phone'];
         $client->address     = $input['address'];
         $client->image       = $input['image'];

         $client->update();

         return $this->send_Response($client,' Updated successfully');
    }


    public function softDeletes($id)
    {
        $client=client::find($id);
        $client_check=$this->send_Response($client);

        if(is_null($client)){

            return response()->json($client_check,404);

        }else{

            $client->delete();
            return response()->json($client_check,200);

        }
    }
}
