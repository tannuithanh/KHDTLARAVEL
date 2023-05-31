<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\RecoveryEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        $random_number = sprintf("%06d", rand(0, 999999));
        
        $email = $request->input('mail');
        $mail = User::where('email', $request['mail'])->first();

        if($mail){
            $mail->recover = $random_number;
            $mail->save();
            Mail::to($email)->send(new RecoveryEmail($mail));
            return redirect()->route('Reset');
        } else {
            return back()->with('fail','mail không tồn tại');
        }
    }

    public function Reset(){
        return view('resetPass');
    }

    public function ResetPost(request $request){
        // dd($request->toArray());
        if($request['pass'] != $request['passComfirm']){
            return back()->with('faild','Không được');
        }
        $pass = Hash::make($request['pass']);
        $confirm = User::where('recover', $request['recover'])->first();
            if($confirm){
                $confirm->password = $pass;
                $confirm->save();
                return redirect()->route('LoginGet')->with('reset','oke');
        }else{
            return back()->with('khongduoc','khong duoc');
        }
    }
    public function back(){
        return redirect()->back();
    }
}
