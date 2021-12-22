<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\CentralUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant;
use Illuminate\Support\Str;

class CentralUserController extends BaseController
{
    //Register//
    public function register(Request $request)
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

        //tenant creation and Central user
        $id = Str::uuid()->toString();
        $tenant = Tenant::create(['id'=>'_'.$request->last_name.'_'.$id]);
        $tenant->domains()->create(['domain' => $request->last_name.'_'.$id.'.localhost']);
        tenancy()->initialize($tenant);


        $gid= Str::uuid()->toString();
        $password= Hash::make($request->password);

        $user = CentralUser::create([
            'id'         => $id,
            'global_id'  => $gid,
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => $password,
        ]);

        $user = User::create([
            'id'         => $id,
            'global_id'  => $gid,
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => $password,
        ]);
        $user['token']=$user->createToken('app')->accessToken;

           // $add = user::create($input);

            return response()->json($user,200);

    }

    //Login//

    public function login(Request $request){

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
             $user = CentralUser::where('email', $request->email)->with('tenants')->first();

             //$user = user::tenants()->id;
             $user['token'] =  $user->createToken('MyApp')-> accessToken;

             return $this->send_Response($user, 200);

        }
        else{
             return $this->sendError('Error',404);
        }
    }
}
