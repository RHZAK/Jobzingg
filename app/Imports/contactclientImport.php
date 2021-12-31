<?php

namespace App\Imports;

use App\Models\contactClient;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class contactclientImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new contactClient([
            'client_ID'  => 'ee56deff-fb58-4bb9-ab4c-44798b8985ce',
            'first_name' => $row['first_name'],
            'last_name'  => $row['last_name'],
            'post'       => $row['post'],
            'email'      => $row['email'],
            'phone'      => $row['phone'],
        ]);
    }
}
