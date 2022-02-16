<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\CentralUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant;
use Illuminate\Support\Str;


class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function resetPassword(Request $request){

        $input=$request->all();

        $validator=validator::make($input,[
            'oldpass' => 'required',
            'newpass'  => 'required',
            'confirmpass'  => 'required',
         ]);

         if ($validator->fails()) {

            return response()->json($validator->error, 404);
        }

        $user = User::where('email',Auth::user()->email)->first();

        if ($user) {

            if (Hash::check($request->oldpass, $user->password)) {

                if($request->newpass == $request->confirmpass){
                        $user->password=Hash::make($request->confirmpass);

                        $user->update();

                        $response = ["success" => "Password reset"];
                        return response($response, 200);
                }else{
                        $response = ["failed" => "Password Confirmation incorrect"];
                        return response($response, 404);
                }

            }else{
                $response = ["failed" => "Password incorrect"];
                return response($response, 404);
            }
        }


    }


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



    public function show()
    {
        $authuser=Auth::user()->id;
        $user=user::find($authuser);

        if(is_null($user)){

            return response()->json($user,404);

        }else{

            return response()->json($user,200);

        }
    }


    public function update(Request $request)
    {
        $authuser=Auth::user()->id;
        $user=user::find($authuser);

        if(is_null($user)){
            return response()->json($user,404);
        }

        $input=$request->all();

        $validator=validator::make($input,[
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required',
            // 'password'   => 'required'
         ]);

        if($validator->fails()){
             return $this->sendError('Please Validate Error',$validator->errors());
        }

         $user->first_name = $input['first_name'];
         $user->last_name  = $input['last_name'];
         $user->email      = $input['email'];
        //  $user->password   = $input['password'];

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
