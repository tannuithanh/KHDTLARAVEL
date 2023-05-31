<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        return new User([
            'name'          => $row['name'],
            'email'         => $row['email'],
            'msnv'          => $row['msnv'],
            'password'      => Hash::make($row['password']),
            'department_id' => $row['department_id'],
            'department_id1' => $row['department_id1'],
            'position_id'   => $row['position_id'],
        ]);
    }
}
