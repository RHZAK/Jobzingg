<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_List=User::all();
        $user_List_Check=$this->send_Response($user_List);

        if($user_List_Check == true){

            return response()->json($user_List_Check,200);

        }else{

            return response()->json($user_List_Check,404);
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
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required',
            'password'   => 'required'
        ]);

        $User_Create_Check=$this->send_Response($input);

        if($validator->fails() || $User_Create_Check == false){

            return response()->json($User_Create_Check,404);

        }
            $add = user::create($input);
            return response()->json($add,200);
    }


    public function show($id)
    {
        $user=user::find($id);

        if(is_null($user)){

            return response()->json($user,404);

        }else{

            return response()->json($user,200);

        }
    }


    public function update(Request $request, $id)
    {
        $user=user::find($id);

        if(is_null($user)){
            return response()->json($user,404);
        }

        $input=$request->all();

        $validator=validator::make($input,[
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required',
            'password'   => 'required'
         ]);

        if($validator->fails()){
             return $this->sendError('Please Validate Error',$validator->errors());
        }

         $user->first_name = $input['first_name'];
         $user->last_name  = $input['last_name'];
         $user->email      = $input['email'];
         $user->password   = $input['password'];

         $user->update();

         return $this->send_Response($user,' Updated successfully');
    }


    public function softDeletes($id)
    {
        $user=user::find($id);
        $user_check=$this->send_Response($user);

        if(is_null($user)){

            return response()->json($user_check,404);

        }else{

            $user->delete();
            return response()->json($user_check,200);


        }
    }
}
