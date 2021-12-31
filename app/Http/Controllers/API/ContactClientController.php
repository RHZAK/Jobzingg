<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Imports\contactclientImport;
use App\Models\ContactClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

    //show contact client of auth user

    public function usercontactclient()
    {
        $ContactClient_List = DB::table('contact_clients')
        ->join('clients', 'clients.id', '=', 'contact_clients.client_id')
        ->select('contact_clients.*')->where('clients.user_id',Auth::user()->id)
        ->get();
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
            'client_id'  => 'required',
            'first_name' => 'required',
            'last_name'  => 'required',
            'poste'      => 'required',
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
            'client_id'  => 'required',
            'first_name' => 'required',
            'last_name'  => 'required',
            'poste'       => 'required',
            'email'      => 'required',
            'phone'      => 'required',
         ]);

        if($validator->fails()){
             return $this->sendError('Please Validate Error',$validator->errors());
        }

         $ContactClient->client_id   = $input['client_id'];
         $ContactClient->first_name  = $input['first_name'];
         $ContactClient->last_name   = $input['last_name'];
         $ContactClient->poste       = $input['poste'];
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

    //Import Client List In Excel Format

    public function importcontactclient(Request $request){
       Excel::import( new contactclientImport,$request->file);
       return response()->json('Success',200);
    }

}
