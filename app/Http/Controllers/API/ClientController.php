<?php

namespace App\Http\Controllers\API;

use App\Exports\clientExport;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Imports\clientImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientController extends BaseController
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client_List=DB::table('clients')
        ->join('countries', 'countries.country_id', '=', 'clients.country_id')
        ->select('clients.*','countries.country')->where('deleted_at','=',null)
        ->get();

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
            'country_id' => 'required',
            'name'       => 'required',
            'email'      => 'required',
            'phone'      => 'required',
            'address'    => 'required'
        ]);

        $client_Create_Check=$this->send_Response($input);

        if($validator->fails() || $client_Create_Check == false){

            return response()->json($client_Create_Check,404);

        }

            $add=client::create([
                "user_id"      => $request->user_id,
                "country_id"   => $request->country_id,
                "name"         => $request->name,
                "email"        => $request->email,
                "phone"        => $request->phone,
                "address"      => $request->address
            ]);
            return response()->json($add,200);
    }

    //Function to show client created by user
    public function userclient(){

        $userclient=client::where('user_id',Auth::user()->id)->get();

        if(is_null($userclient)){

            return response()->json($userclient,404);

        }else{

            return response()->json($userclient,200);

        }

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
            'country_id' => 'required',
            'name'       => 'required',
            'email'      => 'required',
            'phone'      => 'required',
            'address'    => 'required',
         ]);

        if($validator->fails()){
             return $this->sendError('Please Validate Error',$validator->errors());
        }

        // if($client->user_id != Auth::user()->id){
        //     return $this->sendError('Client Does Not Belong To You !!');
        // }

         $client->country_id  = $input['country_id'];
         $client->name        = $input['name'];
         $client->email       = $input['email'];
         $client->phone       = $input['phone'];
         $client->address     = $input['address'];
         $client->filedata    = $input['file'];

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

            // if($client->user_id != Auth::user()->id){
            //     return $this->sendError('Client Does Not Belong To You !!');
            // }

            $client->delete();
            return response()->json($client_check,200);

        }
    }


    //Import Client List In Excel Format

    public function importclient(Request $request){
       Excel::import( new clientImport,$request->file);
       return response()->json('Success',200);
    }

    // Export Data Excel File

    public function exportExcel(){
        return Excel::download(new clientExport,'client.xlsx');
    }
}
