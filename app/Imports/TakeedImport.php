<?php

namespace App\Imports;

use App\Models\ACL\Takeed;
use Maatwebsite\Excel\Concerns\ToModel;

class TakeedImport implements ToModel
{
    public function model(array $row)
    {
        return new Takeed([
            'family_name' => $row[0],
            'name' => $row[1],
            'first_name' => $row[2],
            'second_name' => $row[3],
            'third_name' => $row[4],
            'forth_name' => $row[5],
            'family_name_one' => $row[6],
            'table_area' => $row[7],
            'table_gender' => $row[8],
            'internal_reference' => $row[9],
            'civil_reference' => $row[10],
            'birth_day' => $row[11],
            'job' => $row[12],
            'address' => $row[13],
            'registration_status' => $row[14],
            'registration_number' => $row[15],
            'registration_data' => $row[16],
            'circle' => $row[17]
        ]);
    }
}
