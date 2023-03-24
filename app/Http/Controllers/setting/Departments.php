<?php

namespace App\Http\Controllers\setting;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Departments extends Controller
{
    public function listDepartment(){
        $departments = Department::get();
        $user = Auth::user();
        return view('setting.listDepartments',compact('user','departments'));
    }
}
