<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    public function loginGet(){
        return view('login');
    }
    public function loginPost(request $request){
        $alldata = $request->all();
        if (Auth::attempt(['msnv' => $alldata['msnv'], 'password' => $alldata['password']])) {
           return redirect(route('DashBoard'));
        }else{
            return redirect()->route('LoginGet')->with('fail', 'Sai tên đăng nhập hoặc password');
        }
    }
}
