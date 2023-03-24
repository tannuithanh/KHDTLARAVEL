<?php

namespace App\Http\Controllers\setting;

use App\Models\Team;
use App\Models\User;
use App\Models\Position;
use App\Models\Trademark;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Workweek;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Users extends Controller
{
    public function listUsers()
    {
       
        $user = Auth::user();
        $tradeMark = Trademark::all();
        $department = Department::where('id', $user['department_id'])->get();
        if ($user['position_id'] == 1 || $user['position_id'] == 2 || $user['position_id'] == 10) {
            $allUser = User::join('departments', 'users.department_id', '=', 'departments.id')
                ->join('positions', 'users.position_id', '=', 'positions.id')
                ->leftJoin('teams', 'users.team_id', '=', 'teams.id')
                // ->where('users.id', 1)
                ->select('users.*', 'departments.name as tenphongban', 'positions.name as tenchucvu','teams.name as tennhom')->paginate(10);
        } elseif ($user['position_id'] == 3) {
            $allUser = User::join('departments', 'users.department_id', '=', 'departments.id')
                ->join('positions', 'users.position_id', '=', 'positions.id')
                ->leftJoin('teams', 'users.team_id', '=', 'teams.id')
                ->where('departments.trademark_id', 1)
                ->select('users.*', 'departments.name as tenphongban', 'positions.name as tenchucvu','teams.name as tennhom')->paginate(10);
        } elseif ($user['position_id'] == 4) {
            $allUser = User::join('departments', 'users.department_id', '=', 'departments.id')
                ->join('positions', 'users.position_id', '=', 'positions.id')
                ->leftJoin('teams', 'users.team_id', '=', 'teams.id')
                ->where('departments.trademark_id', 2)
                ->select('users.*', 'departments.name as tenphongban', 'positions.name as tenchucvu','teams.name as tennhom')->paginate(10);
        } else {
            $allUser = User::join('departments', 'users.department_id', '=', 'departments.id')
                ->join('positions', 'users.position_id', '=', 'positions.id')
                ->leftJoin('teams', 'users.team_id', '=', 'teams.id')
                ->where('users.department_id', $department[0]['id'])
                ->select('users.*', 'departments.name as tenphongban', 'positions.name as tenchucvu','teams.name as tennhom')->paginate(10);
        }
        if ($user['position_id'] == 1 || $user['position_id'] == 2) {
            $departmentAll = Department::get();
        } elseif ($user['position_id'] == 3) {
            $departmentAll = Department::where('trademark_id', 1)->get();
        } elseif ($user['position_id'] == 4) {
            $departmentAll = Department::where('trademark_id', 2)->get();
        } else {
            return view('setting.listUser', compact('user', 'allUser'));
        }


     

        return view('setting.listUser', compact('user', 'allUser', 'departmentAll'));
    }
    public function addUsers()
    {
        $user = Auth::user();
        // dd($trademark->toarray());
        if ($user['position_id'] == 1 || $user['position_id'] == 2) {
            return view('setting.addUser', compact('user'));
        } elseif ($user['position_id'] == 3) {
            return view('setting.addUser', compact('user'));
        } elseif ($user['position_id'] == 4) {
            return view('setting.addUser', compact('user'));
        } else {
            $position = Position::WhereIn('id', [5, 6, 7, 8, 9, 10])->get();
            $team = Team::where('department_id', $user['department_id'])->get();
            $department = Department::where('id', $user['department_id'])->get();
        }


        return view('setting.addUser', compact('user', 'department', 'team', 'position'));
    }

    public function insertUsers(request $request)
    {
        User::insert(
            [
                'name' => $request['name'],
                'email' => $request['email'],
                'msnv' => $request['msnv'],
                'department_id' => $request['department_id'],
                'team_id' => $request['team_id'],
                'position_id' => $request['position_id'],
                'password' => Hash::make('123456'),
            ],
        );
        return redirect()->route('listUser.view')->with('successful', 'Thêm thành công');
    }
    public function editUsers($id)
    {
        $user = Auth::user();
        if ($user['position_id'] == 1 || $user['position_id'] == 2) {
            return view('setting.addUser', compact('user'));
        } elseif ($user['position_id'] == 3) {
            return view('setting.addUser', compact('user'));
        } elseif ($user['position_id'] == 4) {
            return view('setting.addUser', compact('user'));
        } else {
            $position = Position::WhereIn('id', [5, 6, 7, 8, 9, 10])->get();
            $team = Team::where('department_id', $user['department_id'])->get();
            $department = Department::where('id', $user['department_id'])->get();
        }
        $userById = User::find($id);
        return view('setting.editUser', compact('userById','department','user','position','team'));
    }

    public function updateUsers(request $request,$id)
    {
        User::where('id',$id)->update(['name'=>$request->name,'email'=>$request->email,'msnv'=>$request->msnv,'department_id'=>$request->department_id,'team_id'=>$request->team_id,'position_id'=>$request->position_id]);
        return redirect()->route('listUser.view')->with('success','Sửa thành công');
    }

    public function searchUsers(request $request)
    {
        $tradeMark = Trademark::all();
        $user = Auth::user();
        if(!empty($request->departmentsId)){
        $allUser = User::where('users.department_id',$request->departmentsId)->join('positions', 'positions.id', '=', 'users.position_id')->join('departments', 'departments.id', '=', 'users.department_id')->leftJoin('teams', 'users.team_id', '=', 'teams.id')->select('users.*', 'departments.name as tenphongban', 'positions.name as tenchucvu','teams.name as tennhom')->paginate(10)   ;
        }else{
            if ($user['position_id'] == 1 || $user['position_id'] == 2) {
            $allUser = User::join('positions', 'positions.id', '=', 'users.position_id')->join('departments', 'departments.id', '=', 'users.department_id')->leftJoin('teams', 'users.team_id', '=', 'teams.id')->select('users.*', 'departments.name as tenphongban', 'positions.name as tenchucvu','teams.name as tennhom')->paginate(10);
            }elseif($user['position_id'] == 3){
                $allUser = User::where('trademark.id',1)->join('positions', 'positions.id', '=', 'users.position_id')->join('departments', 'departments.id', '=', 'users.department_id')->leftJoin('teams', 'users.team_id', '=', 'teams.id')->join('trademark', 'trademark.id', '=', 'departments.trademark_id')->select('users.*', 'departments.name as tenphongban', 'positions.name as tenchucvu','teams.name as tennhom')->paginate(10);
            }elseif($user['position_id'] == 4){
                $allUser = User::where('trademark.id',2)->join('positions', 'positions.id', '=', 'users.position_id')->join('departments', 'departments.id', '=', 'users.department_id')->leftJoin('teams', 'users.team_id', '=', 'teams.id')->join('trademark', 'trademark.id', '=', 'departments.trademark_id')->select('users.*', 'departments.name as tenphongban', 'positions.name as tenchucvu','teams.name as tennhom')->paginate(10);

            }
        }
        if ($user['position_id'] == 1 || $user['position_id'] == 2) {
            $departmentAll = Department::get();
        } elseif ($user['position_id'] == 3) {
            $departmentAll = Department::where('trademark_id', 1)->get();
        } elseif ($user['position_id'] == 4) {
            $departmentAll = Department::where('trademark_id', 2)->get();
        }

        return view('setting.listUser', compact('user', 'allUser'))->with(compact('departmentAll'));  

    }           
    public function deleteUsers($id)
    {
        $deleteUser = User::find($id);
        Workweek::where('responsibility',$deleteUser->name)->delete();
        $deleteUser->delete();
        return redirect()->route('listUser.view')->with('deleteSuccess', 'Xóa nhân sự thành công');
    }           
}
