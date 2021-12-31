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
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CentralUserController extends BaseController
{
    //Register//
    public function register(Request $request)
    {
        $input = $request->all();
        $validator = validator::make($input, [
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required',
            'password'   => 'required'
        ]);

        $User_Create_Check = $this->send_Response($input);

        if ($validator->fails() || $User_Create_Check == false) {

            return response()->json($User_Create_Check, 404);
        }

        //tenant creation and Central user
        $id = Str::uuid()->toString();
         $tenant = Tenant::create(['id'=>'_'.$request->last_name.'_'.$id]);
        //$tenant = Tenant::create(['id' => '_' . $request->last_name]);
        // $tenant->domains()->create(['domain' => $request->last_name.'_'.$id.'.localhost']);



        $gid = Str::uuid()->toString();
        $password = Hash::make($request->password);

        /* Duplicate user in Central user Schema*/
        // $userC = CentralUser::create([
        //     'id'         => $id,
        //     'global_id'  => $gid,
        //     'first_name' => $request->first_name,
        //     'last_name'  => $request->last_name,
        //     'email'      => $request->email,
        //     'password'   => $password,

        // ]);

        tenancy()->initialize($tenant);

        $user = User::create([
            'id'         => $id,
            'global_id'  => $gid,
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => $password,
        ]);

        $user['token'] = $user->createToken('app')->accessToken;

        return response()->json($user, 200);
    }

    //Login//


    public function login(Request $request)
    {
        $login_credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $CUser = CentralUser::where('email', '=', $login_credentials['email'])->with('tenants')->first();

        if(is_null($CUser)){
            return $this->sendError('Error',404);
        }

        $tenant = Tenant::find($CUser->tenants()->first()->id);
        tenancy()->initialize($tenant);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token    = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['user' => $user,'token' => $token];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'User does not exist'];
            return response($response, 422);
        }


        //$CUser['token'] =  $CUser->createToken('MyApp')->accessToken;
        //test why user ID has value 0
        // $test_id=CentralUser::select('id')->get();
        //dd($test_id);
        // if(Auth::attempt($login_credentials)){
        //     //dd($test_id);
        //     Tenant::all()->runForEach(function () {

        //        $u= User::all();
        //        dd($u);
        //     //    return $this->send_Response($u, 200);
        //     });



        // }
           //dd(Auth::user());
    }

    // public function login(Request $request){

    //     if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){

    //         dd(Auth::user());
    //         //  $user = CentralUser::where('email', $request->email)->with('tenants')->first();

    //         //  //$user = user::tenants()->id;
    //         //  $user['token'] =  $user->createToken('MyApp')-> accessToken;

    //          return $this->send_Response($user, 200);

    //     }
    //     else{
    //          return $this->sendError('Error',404);
    //     }
    // }
}
