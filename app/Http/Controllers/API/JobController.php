<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class JobController extends BaseController
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $job_List=job::all();
        $job_List_Check=$this->send_Response($job_List);

        if($job_List_Check == true){

            return response()->json($job_List_Check,200);

        }else{

            return response()->json($job_List_Check,404);
        }
    }

      //show Jobs client of auth user

      public function userclientjob()
      {
          $userclientjob_List = DB::table('jobs')
          ->join('clients', 'clients.id', '=', 'jobs.client_id')
          ->select('clients.name','jobs.*')->where('clients.user_id',Auth::user()->id)
          ->get();
          $userclientjob_Check=$this->send_Response($userclientjob_List);

          if($userclientjob_Check == true){

              return response()->json($userclientjob_Check,200);

          }else{

              return response()->json($userclientjob_Check,404);
          }
      }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = validator::make($input,[
            'client_id'          => 'required',
            'contact_clients_id' => 'required',
            'title'              => 'required',
            'headcount'          => 'required',
            'address'            => 'required',
            'dead_line'          => 'required',
            'tjm'                => 'required',
            'description'        => 'required',
            'contract_type'      => 'required',
            'location'           => 'required'
        ]);

        $job_Create_Check=$this->send_Response($input);

        if($validator->fails() || $job_Create_Check == false){

            return response()->json($job_Create_Check,404);

        }
            $add = job::create($input);
            return response()->json($add,200);
    }

    public function show($id)
    {
        $job=job::find($id);

        if(is_null($job)){

            return response()->json($job,404);

        }else{

            return response()->json($job,200);

        }
    }


    public function update(Request $request, $id)
    {
        $job=job::find($id);

        if(is_null($job)){
            return response()->json($job,404);
        }

        $input=$request->all();

        $validator=validator::make($input,[
            'client_id'          => 'required',
            'contact_clients_id' => 'required',
            'title'              => 'required',
            'headcount'          => 'required',
            'address'            => 'required',
            'dead_line'          => 'required',
            'tjm'                => 'required',
            'description'        => 'required',
            'contract_type'      => 'required',
            'location'           => 'required'
        ]);

        if($validator->fails()){
             return $this->sendError('Please Validate Error',$validator->errors());
        }

         $job->client_id           = $input['client_id'];
         $job->contact_clients_id  = $input['contact_clients_id'];
         $job->title               = $input['title'];
         $job->headcount           = $input['headcount'];
         $job->address             = $input['address'];
         $job->dead_line           = $input['dead_line'];
         $job->tjm                 = $input['tjm'];
         $job->description         = $input['description'];
         $job->contract_type       = $input['contract_type'];
         $job->location            = $input['location'];

         $job->update();

         return $this->send_Response($job,' Updated successfully');
    }


    public function softDeletes($id)
    {
        $job=job::find($id);
        $job_check=$this->send_Response($job);

        if(is_null($job)){

            return response()->json($job_check,404);

        }else{

            $job->delete();
            return response()->json($job_check,200);

        }
    }

}
