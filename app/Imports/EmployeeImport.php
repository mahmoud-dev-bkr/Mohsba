<?php

namespace App\Imports;

use App\Employee;
use Maatwebsite\Excel\Concerns\ToModel;

class EmployeeImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
            return new Employee([
                'job_number' => $row[0],
                'name' => $row[1],
                'email' => $row[2],
                'address' => $row[3],
                'phone' => $row[4],
                'password' => $row[5],
                'gender' => $row[6],
                'age' => $row[7],
            ]);
    }
}
