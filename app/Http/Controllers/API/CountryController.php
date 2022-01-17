<?php

namespace App\Http\Controllers\API;

use App\Models\country;

class CountryController extends BaseController
{
    public function index()
    {
        $country_List=country::all();
        $country_List_Check=$this->send_Response($country_List);

        if($country_List_Check == true){

            return response()->json($country_List_Check,200);

        }else{

            return response()->json($country_List_Check,404);
        }
    }
}
