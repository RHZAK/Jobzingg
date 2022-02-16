<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Imports\candidateImport;
use App\Models\Candidate;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Exports\candidateExport;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use SebastianBergmann\Environment\Console;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Str;


class CandidateController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { //todo file covert to string
        $Candidate_List = DB::table('candidates')
            ->join('countries', 'countries.country_id', '=', 'candidates.country_id')
            ->select('candidates.*', 'countries.country')->where('deleted_at', '=', null)
            ->get();


        // $file=Candidate::get('file');
        // $filename ='public/img/profile/mvaU46PIKB.png';

        // $filename = (file_get_contents($filename));
        //    dd($filename);
        //    $image = Array('image'=>json_encode(base64_encode($filename)));
        // $ads[0]->image = $image;
        // dd($f);


        $Candidate_List_Check = $this->send_Response($Candidate_List);

        if ($Candidate_List_Check == true) {

            return response()->json($Candidate_List_Check, 200);
        } else {

            return response()->json($Candidate_List_Check, 404);
        }
    }

    //show candidate of auth user
    public function usercandidate()
    {
        $ContactClient_List = DB::table('candidates')
            ->where('candidates.user_id', Auth::user()->id)->get();

        $ContactClient_List_Check = $this->send_Response($ContactClient_List);

        if ($ContactClient_List_Check == true) {

            return response()->json($ContactClient_List_Check, 200);
        } else {

            return response()->json($ContactClient_List_Check, 404);
        }
    }

    public function store(Request $request)
    {

        $input = $request->all();
        $validator = validator::make($input, [
            'country_id'            => 'required',
            'user_id'               => 'required',
            'name'                  => 'required',
            'phone'                 => 'required',
            'email'                 => 'required',
            'address'               => 'required',
            'image'                 => 'required',
            'gender'                => 'required',
            'birthday'              => 'required',
            'year_first_experience' => 'required'
        ]);

        $Candidate_Create_Check = $this->send_Response($input);

        if ($validator->fails() || $Candidate_Create_Check == false) {

            return response()->json($Candidate_Create_Check, 404);
        }

        // $profilImg = $request->image;
        // $profilImg = $request->file('image');
        // $newPhoto = time().$profilImg->getClientOriginalName();
        // $profilImg->move('img/',$newPhoto);
        // $path='img/'.$newPhoto;
        // $mainpic = $request->file('image');
        // $newPhoto = time().$mainpic->getClientOriginalName();
        // $mainpic->move('img/profile/',$newPhoto);

        // if ($request->has('image')) {

        //     // $photo = $request->image;
        //     $photo = $request->file('image');
        //     // $newPhoto = time().$photo->getClientOriginalName();
        //     $newPhoto = date('Y-m-d-H:i:s')."-".$photo->getClientOriginalName();
        //     $photo->move('img/profile/',$newPhoto);


        // }

        // if($request['image']){
        //     $image=$request->image;
        //     $extension=$image->getClientOriginalExtension();
        //     $name=time().'_'.$image->getClientOriginalName();
        //     Storage::disk('public')->put($name,File::get($image));
        // }

        // $image=$request->image->store('img/profile');

        // $mainpic = $request->file('image');
        // $newPhoto = time().$mainpic->getClientOriginalName();
        // $mainpic->move('img/profile/',$newPhoto);
        // Multi candidate
        $add = Candidate::create([
            "user_id"      => $request->user_id,
            "country_id"   => $request->country_id,
            "name"         => $request->name,
            "phone"        => $request->phone,
            "email"        => $request->email,
            "address"      => $request->address,
            'image'        => "img",
            'gender'                => $request->gender,
            'birthday'              => $request->birthday,
            'year_first_experience' => $request->year_first_experience
        ]);
        return response()->json($add, 200);
    }


    public function show($id)
    {
        $Candidate = Candidate::find($id);

        if (is_null($Candidate)) {

            return response()->json($Candidate, 404);
        } else {

            // $file=getCandidateResume($id);
            $candidate['file'] = getCandidateResume($id);

            return response()->json($Candidate, 200);
        }
    }


    public function update(Request $request, $id)
    {

        $Candidate = Candidate::find($id);

        if (is_null($Candidate)) {
            return response()->json($Candidate, 404);
        }
        $input = $request->all();

        $validator = validator::make($input, [
            'country_id'            => 'required',
            'name'                  => 'required',
            'phone'                 => 'required',
            'email'                 => 'required',
            'address'               => 'required',
            // 'file'                 => 'required',
            'gender'                => 'required',
            'birthday'              => 'required',
            'year_first_experience' => 'required'
        ]);

           if($validator->fails()){
                return $this->sendError('Please Validate Error',$validator->errors());
           }

        //    if($Candidate->user_id != Auth::user()->id){
        //        return $this->sendError('Client Does Not Belong To You !!');
        //    }
        $Candidate->country_id            = $input['country_id'];
        $Candidate->name                  = $input['name'];
        $Candidate->phone                 = $input['phone'];
        $Candidate->email                 = $input['email'];
        $Candidate->address               = $input['address'];
        $Candidate->gender                = $input['gender'];
        $Candidate->birthday              = $input['birthday'];
        $Candidate->year_first_experience = $input['year_first_experience'];


        if ($request->has('file')) {

            //all type of image png jpeg jpg
            $image_64 = $request->file; //your base64 encoded data

            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf

            $replace = substr($image_64, 0, strpos($image_64, ',')+1);

            // find substring fro replace here eg: data:image/png;base64,

            $image = str_replace($replace, '', $image_64);

            $image = str_replace(' ', '+', $image);

            $imageName = Str::random(10).'.'.$extension;
            File::put(public_path('img/profile'). '/' . $imageName, base64_decode($image));
            //end

            $Candidate->file='public/img/profile/'.$imageName;
            $Candidate->filedata=$request->file;
            $Candidate->update();

            return $this->send_Response($Candidate, ' Updated successfully');


        }
        return $this->send_Response($request->file);
        //     return response()->json($Candidate, 404);

        // }

        // if($request->has('image')) {

        // $file = $request->file('file');

		// $filename = $file->getClientOriginalName();//or you can give a name
        // return $fileName;
		// $path = 'img/profile/'; // the path in public directory you want to save file, String, full path,

		// $file->move(public_path($path),$filename); // move the file from request to directory, public_path method is required!!
        // $Candidate->image = 'img/profile/' . $filename;
		// if (!file_exists($path)) {

    	// 	mkdir($path,0777,true);

    	// }

        // $photo = $request->file('file');
        // $newPhoto = $photo->getClientOriginalName();
        // // dd($newPhoto);
        // $photo->move('img/profile/', $newPhoto);
        // $Candidate->image = 'img/profile/' . $newPhoto;
        // $imageName = time().'.'.$request->image->getClientOriginalExtension();
        // $request->image->move(public_path('/img/profile'), $imageName);
        // $photo = $request->image;
        // $temp = file_get_contents($request->image);
        // $blob = base64_encode($temp);
        // $t=$blob->getClientOriginalName();

        // $fileName = rand(1, 999) . $temp->getClientOriginalName();
        // $filePath = "/uploads/" . date("Y") . '/' . date("m") . "/" . $fileName;

        // $file->storeAs('uploads/'. date("Y") . '/' . date("m") . '/', $fileName, 'uploads');


        // $photo->move('img/profile/',$blob);

        // }


    }


    public function softDeletes($id)
    {
        $Candidate = Candidate::find($id);
        $Candidate_check = $this->send_Response($Candidate);

        if (is_null($Candidate)) {

            return response()->json($Candidate_check, 404);
        } else {

            //    if($Candidate->user_id != Auth::user()->id){
            //      return $this->sendError('Client Does Not Belong To You !!');
            //     }

            $Candidate->delete();
            return response()->json($Candidate_check, 200);
        }
    }

    //Import Candidate List In Excel Format

    public function importcandidate(Request $request)
    {
        Excel::import(new candidateImport, $request->file);
        return response()->json('Success', 200);
    }

    // Export Data Excel File

    public function exportExcel()
    {
        return Excel::download(new CandidateExport, 'candidate.xlsx');
    }
}
