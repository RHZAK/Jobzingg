<?php

namespace App\Imports;

use App\Models\Candidate;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class candidateImport implements ToModel , WithHeadingRow
{

    public function model(array $row)
    {
        return new Candidate([
            'name'                  => $row['name'],
            'phone'                 => $row['phone'],
            'email'                 => $row['email'],
            'address'               => $row['address'],
            'gender'                => $row['gender'],
            'birthday'              => $row['birthday'],
            'year_first_experience' => (int) $row['year_first_experience'],
            'country_id'            => "148",
            'user_id'               => Auth::user()->id,
            'image'                 => 'img'
        ]);
    }
}
