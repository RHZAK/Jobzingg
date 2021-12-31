<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class clientExport implements FromCollection,WithHeadings
{


    public function headings():array{
        return ['Name','Email','Phone','Address','Nationality'];
    }

    public function collection()
    {
        return collect(Client::getList());
    }

}
