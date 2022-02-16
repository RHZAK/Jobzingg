<?php

namespace App\Exports;

use App\Models\Candidate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class candidateExport implements FromCollection,WithHeadings
{

    public function headings():array{
        return ['Name','Phone','Email','Address','Gender','BirthDay','Year Experience','Nationality'];
    }

    public function collection()
    {
        return collect(Candidate::getList());
    }
}
