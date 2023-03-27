<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\RecoveryEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

    public function Recover(){
        return view('recoverPass');
    }

    public function RecoverPost(request $request){
        $email = $request->input('mail');
        $mail = User::where('email', $request['mail'])->first();
        if($mail){
            Mail::to($email)->send(new RecoveryEmail($mail));
            return 'Email sent successfully.';
        } else {
            return back()->with('fail','mail không tồn tại');
        }
    }
}
