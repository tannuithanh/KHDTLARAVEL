<?php

namespace App\Http\Controllers\setting;

use App\Models\Team;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\Trademark;
use Illuminate\Support\Facades\Auth;

class Teams extends Controller
{
    public function listTeam(){
        $user = Auth::user();
        $department = Department::where('id',$user['department_id'])->get();
        if($user['position_id']==1 || $user['position_id']==2 || $user['position_id']==11){
            $team = Team::join('departments', 'teams.department_id', '=', 'departments.id')
                            // ->where('users.id', 1)
                            ->select('teams.*','departments.name as tenphongban')
                            ->get();
        }elseif($user['position_id'] == 3 ){
            $team = Team::join('departments', 'teams.department_id', '=', 'departments.id')
                             ->where('departments.trademark_id', 1)
                             ->select('teams.*','departments.name as tenphongban')
                            ->get();
        }elseif($user['position_id'] == 4 ){
                $team = Team::join('departments', 'teams.department_id', '=', 'departments.id')
                                 ->where('departments.trademark_id', 2)
                                 ->select('teams.*','departments.name as tenphongban')
                                ->get();
        }else{
                $team = Team::join('departments', 'teams.department_id', '=', 'departments.id')
                                 ->where('teams.department_id', $department[0]['id'])
                                 ->select('teams.*','departments.name as tenphongban')
                                ->get();
        }
        
        // dd($team);
        return view('setting.listTeam',compact('user','team'));
    }

    public function addTeams(){
        $user = Auth::user();
        // dd($trademark->toarray());
        if($user['position_id']==1 || $user['position_id']==2 || $user['position_id']==10){
            $department = Department::get();
        }elseif($user['position_id'] == 3 ){
            $department = Department::where('trademark_id',1)->get();
        }elseif($user['position_id'] == 4 ){
            $department = Department::where('trademark_id',2)->get();
        }else{
            $department = Department::where('id',$user['department_id'])->get();
        }
        return view('setting.addTeam',compact('user','department'));
    }

    
    public function creatTeams(request $request){
         Team::create([
            'name' => $request->name,
            'department_id' => $request->departmentsId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('listTeam.view')->with('success','oke');

    }

    public function deleteTeam($id){
        $deleteTeam = Team::find($id);
        $deleteTeam->delete();
        return redirect()->route('listTeam.view')->with('deleteSuccess', 'Xóa kế hoạch thành công');
    }

    public function editTeam($id){
        $user = Auth::user();
        $team = Team::find($id);
        if($user['position_id']==1 || $user['position_id']==2){
            return view('setting.editTeam',compact('team','user'));
            }
        if($team['department_id']==$user['department_id'] && $user['position_id']==5 || $user['position_id']==6 || $user['position_id']==3){
        return view('setting.editTeam',compact('team','user'));
        }else{
            return redirect()->route('listTeam.view')->with('fail','không được phép');
        }
    }

    public function updateTeam(request $request,$id){
       Team::where('id',$id)->update(['name'=>$request->name]);
       return redirect()->route('listTeam.view')->with('oke','không được phép')->with('hack',$id);
    }
}
