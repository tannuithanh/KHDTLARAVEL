<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function dashboardGet(){
        $user = Auth::user();
       return view('DashBoard',compact('user'));
    }
}
