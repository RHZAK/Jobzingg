<?php

namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class clientImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Client([
            'name'       => $row['name'],
            'email'      => $row['email'],
            'phone'      => $row['phone'],
            'address'    => $row['address'],
            'user_id'    => Auth::user()->id,
            'country_id' => "148",
            'image'      => "img/profile-icon.jpg",
        ]);
    }
}
