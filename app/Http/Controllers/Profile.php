<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Profile extends Controller
{
    public function Profile(){

        $user = Auth::user();
        //---- Phòng ban -----//
        if(empty($user['department_id'])){
            $user['department_id']='Không có phòng ban';
        }else{
           $departments = DB::table('departments')->where('id', $user['department_id'])->first();
           $user['department_id']=$departments->name;
        }
        // dd($user['department_id']);

        // //---- nhóm -----//
        if(empty($user['team_id'])){
            $user['team_id']='Không có nhóm';
        }else{
           $teams = Team::get()->where('id',$user['team_id'])->first();
           $user['team_id'] = $teams->name;
        }
        // dd($teams->toArray()); 

        //---- Chức vụ ----//
        if(empty($user['position_id'])){ 
            $user['position_id']='Không có chức vụ';
        }else{
            $positions = Position::get()->where('id',$user['position_id'])->first();
            $user['position_id'] = $positions->name;
        }
        
        return view('profile')->with(compact('user'));
    }
}
