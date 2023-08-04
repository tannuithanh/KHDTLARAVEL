<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaoLichLamViec extends Controller
{
    public function TaoLichLamViec(){
        $user = Auth::user();
        return view('TaoLichLamViec',compact('user'));
    }
    public function TaoLichLamViec1(request $request){
        dd($request->toArray());
        $user = Auth::user();
    }
}
