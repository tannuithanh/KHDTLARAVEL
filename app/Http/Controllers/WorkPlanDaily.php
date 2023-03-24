<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\Workdaily;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WorkPlanDaily extends Controller
{

    public function viewListWorkDaily(){
      
        $today = date('Y-m-d');
        $user = Auth::user();
        //-------- LẤY DANH SÁCH NHÓM THEO CHỨC VỤ ------------//
        if ($user['position_id'] == 1 || $user['position_id'] == 2) {
            $teams = Team::get();
        } elseif ($user['position_id'] == 3) {
            $teams = Team::join('departments', 'teams.department_id', '=', 'departments.id')->join('trademark', 'departments.trademark_id', '=', 'trademark.id')->where('departments.trademark_id', 1)->select('teams.*')->get();
        } elseif ($user['position_id'] == 4) {
            $teams = Team::join('departments', 'teams.department_id', '=', 'departments.id')->join('trademark', 'departments.trademark_id', '=', 'trademark.id')->where('departments.trademark_id', 2)->select('teams.*')->get();
        } else {
            $teams = Team::where('department_id', $user['department_id'])->get();
        }
        //--------- LẤY DANH SÁCH NHÂN SỰ THEO CHỨC VỤ ----------//
        if ($user['position_id'] == 1 || $user['position_id'] == 2) {
            $excludedIds = [1, 2, 3, 4, 5];
            $userById = User::whereNotIn('id', $excludedIds)->get();
        } elseif ($user['position_id'] == 3) {
            $userById = User::join('departments', 'users.department_id', '=', 'departments.id')->join('trademark', 'departments.trademark_id', '=', 'trademark.id')->where('departments.trademark_id', 1)->select('users.*')->get();
        } elseif ($user['position_id'] == 4) {
            $userById = User::join('departments', 'users.department_id', '=', 'departments.id')->join('trademark', 'departments.trademark_id', '=', 'trademark.id')->where('departments.trademark_id', 2)->select('users.*')->get();
        } else {
            $userById = User::where('department_id', $user['department_id'])->get();
        }
        //--------- LẤY DANH SÁCH CÔNG VIỆC ----------//
        if ($user['position_id'] == 1 || $user['position_id'] == 2) {
            $workDaily = Workdaily::select('workdaily.*')
           
            ->where('date', '=', $today)
            ->get();
            }elseif ($user['position_id'] == 3) {
                $workDaily = Workdaily::select('workdaily.*')
               
                ->join('departments', 'workdaily.department_id', '=', 'departments.id')
                ->join('trademark', 'departments.trademark_id', '=', 'trademark.id')
                ->where(function($query) use ($today) {
                    $query->where('date', '=', $today)
                          ->orWhere('workdaily.responsibility', 'Tô Tấn Sơn');
                })
                ->where('trademark.id', '=', 1)
                ->get();
                // dd($workDaily->toArray());
            }elseif ($user['position_id'] == 4) {
                $workDaily = Workdaily::select('workdaily.*')
               
                ->join('departments', 'workdaily.department_id', '=', 'departments.id')
                ->join('trademark', 'departments.trademark_id', '=', 'trademark.id')
                ->where('date', '=', $today)
                ->where('trademark.id', '=', 2)
                ->get();    
            }else{
                $workDaily = Workdaily::select('workdaily.*')
               
                ->join('departments', 'workdaily.department_id', '=', 'departments.id')
                ->where('date', '=', $today)
                ->where('workdaily.department_id', '=', $user['department_id'])
                ->get();    
            }
        if ($user['position_id'] == 1 || $user['position_id'] == 2) {
            $departments = Department::get();
        } elseif ($user['position_id'] == 3) {
            $departments = Department::where('trademark_id', 1)->get();
        } elseif ($user['position_id'] == 4) {
            $departments = Department::where('trademark_id', 2)->get();
        } else {
            // dd($workDaily->toArray());
            return view('plan.listPlanDaily', compact('userById', 'user', 'teams','workDaily','today'));
        }
        // dd($workDaily->toArray());
        return view('plan.listPlanDaily',compact('user','teams','userById','departments','workDaily','today'));
    }

    public function viewCreatWorkDaily(){
        
        $allUser = User::get();
        $user = Auth::user();
        return view('plan.creat.creatWorkDaily',compact('user','allUser'));
        
    }
    public function insertWorkDaily(request $request){
        // dd($request->toArray());
        $mytime = date('Y-m-d H:i:s');
        $user = Auth::user();
        $alldata = $request->all();   
        if(isset($alldata['support'])){
            $supportJson = json_encode($alldata['support'], true);
            $supportArray =  json_decode($supportJson, true);
            $supportString = implode("\n", $supportArray);
        }else{
            $supportString = null;
        }
         Workdaily::insert(
            [
                'categoryDaily' => $alldata['categoryDaily'],
                'describeDaily' => $alldata['describeDaily'],
                'support' => isset($supportString) ? $supportString : null,
                'responsibility' => $user['name'],
                'ResultByWookWeek'=>100,
                'time'=>$alldata['time'],
                'date'=>$alldata['date'],
                'note' => $alldata['note'],
                'department_id' => $user['department_id'],
                'team_id' => $user['team_id'],
                'created_at' => $mytime,
                'updated_at' => $mytime
            ],);
            return redirect()->route('listWorkDaily')->with('successful', 'Thêm kế hoạch thành công');  
    }

    public function getDepartments(request $request){
        $user = Auth::user();
        if ($request['departments_id'] != 0) {
            $teamId = Team::where('department_id', $request['departments_id'])->get();
            $users = User::where('department_id', $request['departments_id'])->get();
        } else {
            if ($user['position_id'] == 1 || $user['position_id'] == 2) {
                $teamId = Team::get();
            } elseif ($user['position_id'] == 3) {
                $teamId = Team::join('departments', 'teams.department_id', '=', 'departments.id')->join('trademark', 'departments.trademark_id', '=', 'trademark.id')->where('departments.trademark_id', 1)->select('teams.*')->get();
            } elseif ($user['position_id'] == 4) {
                $teamId = Team::join('departments', 'teams.department_id', '=', 'departments.id')->join('trademark', 'departments.trademark_id', '=', 'trademark.id')->where('departments.trademark_id', 2)->select('teams.*')->get();
            }

            if ($user['position_id'] == 1 || $user['position_id'] == 2) {
                $excludedIds = [1, 2, 3, 4, 5];
                $users = User::whereNotIn('id', $excludedIds)->get();
            } elseif ($user['position_id'] == 3) {
                $users = User::join('departments', 'users.department_id', '=', 'departments.id')->join('trademark', 'departments.trademark_id', '=', 'trademark.id')->where('departments.trademark_id', 1)->select('users.*')->get();
            } elseif ($user['position_id'] == 4) {
                $users = User::join('departments', 'users.department_id', '=', 'departments.id')->join('trademark', 'departments.trademark_id', '=', 'trademark.id')->where('departments.trademark_id', 2)->select('users.*')->get();
            }
        }


        $data = ['teamId' => $teamId, 'users' => $users];

        return response()->json($data);
    }

    public function getUsers(Request $request)
    {
        $user = Auth::user();
        if ($request['team_id'] != 0) {
            $users = User::where('team_id', $request['team_id'])->get();
        } else {
            if ($user['position_id'] == 1 || $user['position_id'] == 2) {
                $excludedIds = [1, 2, 3, 4, 5];
                $users = User::whereNotIn('id', $excludedIds)->get();
            } elseif ($user['position_id'] == 3) {
                $users = User::join('departments', 'users.department_id', '=', 'departments.id')->join('trademark', 'departments.trademark_id', '=', 'trademark.id')->where('departments.trademark_id', 1)->select('users.*')->get();
            } elseif ($user['position_id'] == 4) {
                $users = User::join('departments', 'users.department_id', '=', 'departments.id')->join('trademark', 'departments.trademark_id', '=', 'trademark.id')->where('departments.trademark_id', 2)->select('users.*')->get();
            }
        }




        return response()->json($users);
    }

    public function updateWorkDaily($id){
        
        $allUser = User::get();
        $user = Auth::user();
        $workDaily = Workdaily::find($id);
        $countWorkWeek_id = Workdaily::where('workweek_id', $workDaily->workweek_id)
        ->select(DB::raw('SUM(ResultByWookWeek) as total'))
        ->first();
        // dd($workDaily->toArray());
        return view('plan.creat.updateWorkDailyFromWorkWeek',compact('user','workDaily','allUser','countWorkWeek_id'));
    }

    public function updateWorkDailyPost($id, request $request){
        if(isset($request['support'])){
            $supportJson = json_encode($request['support'], true);
            $supportArray =  json_decode($supportJson, true);
            $supportString = implode("\n", $supportArray);
        }else{
            $supportString = null;
        }
        $workDaily = Workdaily::find($id);
        $user = Auth::user();
        if($request->Result == null && $request->ResultByWookWeek == null){
            return back()->with('message', 'Bạn đã thực hiện thất bại!');
        }else{
        $countWorkWeek_id = Workdaily::where('workweek_id', $workDaily->workweek_id)
        ->select(DB::raw('SUM(ResultByWookWeek) as total'))
        ->first();
        if($countWorkWeek_id->total<100){
        $workDaily = Workdaily::find($id);
        $workDaily->support = $supportString;
        $workDaily->inadequacy = $request->inadequacy;
        $workDaily->propose = $request->propose;
        $workDaily->Result = $request->Result;
        $workDaily->ResultByWookWeek = $request->ResultByWookWeek;
        $workDaily->status = 0;
        $workDaily->update();
        $countWorkWeek_id = Workdaily::where('workweek_id', $workDaily->workweek_id)
        ->select(DB::raw('SUM(ResultByWookWeek) as total'))
        ->first();
        if($countWorkWeek_id->total<100){
            return redirect()->route('listWorkDaily')->with('report','Cập nhật thành công')->with('hack', $id);
        }else{
            $workweekWorkDailies = Workdaily::where('workweek_id', $workDaily->workweek_id)->get();
            foreach ($workweekWorkDailies as $daily) {
                if ($daily->ResultByWookWeek === null) {
                    $daily->delete();
                }
            }
        }
        }
        }
            return redirect()->route('listWorkDaily')->with('report','Cập nhật thành công')->with('hack', $id);
    }

    public function editWorkDailyGet($id){
        $allUser = User::get();
        $user = Auth::user();
        $workDaily = Workdaily::find($id);
        return view('plan.creat.editWorkDaily',compact('user','allUser','workDaily'));
    }

    public function editWorkDailyPost($id, request $request){
        if(isset($request['support']) && is_array($request['support'])){
            $supportJson = json_encode($request['support']);
            $supportArray = json_decode($supportJson, true);
            $supportString = implode("\n", $supportArray);
        } else {
            $supportString = null;
        }
        
        $workDaily = Workdaily::find($id);
        if($workDaily){
            $workDaily->categoryDaily = $request->categoryDaily;
            $workDaily->describeDaily = $request->describeDaily;
            $workDaily->support = $supportString;
            $workDaily->time = $request->time;
            $workDaily->date = $request->date;
            $workDaily->support = $request->support;
            $workDaily->note = $request->note;
            $workDaily->save();
        }
        return redirect()->route('listWorkDaily')->with('edit', 'Sửa thành công')->with('hack', $id);
    }

    public function deleteWorkDaily($id){
        $deleteWorkDaily = Workdaily::find($id);
        $deleteWorkDaily->delete();
        return redirect()->route('listWorkDaily')->with('deleteSuccess', 'Xóa kế hoạch thành công');
    }

    public function searchWorkDaily(request $request){
        
        $today = date('Y-m-d');
        $departments = Department::get();
        $alldata = $request->all();
        $month = date('m', strtotime($request['Day']));
        $user = Auth::user();
        
      
        if ($user['position_id'] == 1 || $user['position_id'] == 2) {
            $teams = Team::get();
        } elseif ($user['position_id'] == 3) {
            $teams = Team::join('departments', 'teams.department_id', '=', 'departments.id')->join('trademark', 'departments.trademark_id', '=', 'trademark.id')->where('departments.trademark_id', 1)->select('teams.*')->get();
        } elseif ($user['position_id'] == 4) {
            $teams = Team::join('departments', 'teams.department_id', '=', 'departments.id')->join('trademark', 'departments.trademark_id', '=', 'trademark.id')->where('departments.trademark_id', 2)->select('teams.*')->get();
        } else {
            $teams = Team::where('department_id', $user['department_id'])->get();
        }

        if ($user['position_id'] == 1 || $user['position_id'] == 2) {
            $excludedIds = [1, 2, 3, 4, 5];
            $userById = User::whereNotIn('id', $excludedIds)->get();
        } elseif ($user['position_id'] == 3) {
            $userById = User::join('departments', 'users.department_id', '=', 'departments.id')->join('trademark', 'departments.trademark_id', '=', 'trademark.id')->where('departments.trademark_id', 1)->select('users.*')->get();
        } elseif ($user['position_id'] == 4) {
            $userById = User::join('departments', 'users.department_id', '=', 'departments.id')->join('trademark', 'departments.trademark_id', '=', 'trademark.id')->where('departments.trademark_id', 2)->select('users.*')->get();
        } else {
            $userById = User::where('department_id', $user['department_id'])->get();
        }

       
        if($user['position_id'] == 1 || $user['position_id'] == 2 || $user['position_id'] == 3 || $user['position_id'] == 4){
            if($alldata['Day'] && $alldata['teamId']== 0 && $alldata['departmentsId']== 0 && $alldata['userName']==null){
                if ($user['position_id'] == 1 || $user['position_id'] == 2) {
                    $workDaily = Workdaily::select('workdaily.*')
                   
                    ->where('workdaily.date', '=', $request['Day'])->get();
                }elseif($user['position_id'] == 3 ){
                    $workDaily = Workdaily::select('workdaily.*')
                   
                    ->join('departments', 'departments.id', '=', 'workdaily.department_id')
                    ->join('trademark', 'trademark.id', '=', 'departments.trademark_id')
                    ->where('workdaily.date', '=', $request['Day'])
                    ->where('trademark_id', 1)->get();
                }else{
                    $workDaily = Workdaily::select('workdaily.*')
                   
                    ->join('departments', 'departments.id', '=', 'workdaily.department_id')
                    ->join('trademark', 'trademark.id', '=', 'departments.trademark_id')
                    ->where('workdaily.date', '=', $request['Day'])
                    ->where('trademark_id', 2)->get();
                } 
            }elseif($alldata['Day'] && $alldata['teamId']== 0 && $alldata['departmentsId']!= 0 && $alldata['userName']==null){
                $workDaily = Workdaily::select('workdaily.*')
               
                ->where('workdaily.date', '=', $request['Day'])
                ->where('workdaily.department_id', $alldata['departmentsId'])
                ->get();
            }elseif($alldata['Day'] && $alldata['teamId']!= 0 && $alldata['departmentsId']!= 0 && $alldata['userName']==null){
                $workDaily = Workdaily::select('workdaily.*')
               
                ->where('workdaily.date', '=', $request['Day'])
                ->where('workdaily.department_id', $alldata['departmentsId'])
                ->where('workdaily.team_id', $alldata['teamId'])
                ->get();
            }elseif($alldata['Day'] && $alldata['teamId']!= 0 && $alldata['departmentsId']==0 && $alldata['userName']==null){
                $workDaily = Workdaily::select('workdaily.*')
               
                ->where('workdaily.date', '=', $request['Day'])
                ->where('workdaily.team_id', $alldata['teamId'])
                ->get();
            }elseif($alldata['Day'] && $alldata['teamId']== 0 && $alldata['departmentsId']==0 && $alldata['userName']!=null ){
                $workDaily = Workdaily::select('workdaily.*')
               
                ->where('workdaily.date', '=', $request['Day'])
                ->where('workdaily.responsibility', $alldata['userName'])
                ->get();
            }elseif($alldata['Day'] && $alldata['teamId']== 0 && $alldata['departmentsId']!=0 && $alldata['userName']!=null ){
                $workDaily = Workdaily::select('workdaily.*')
               
                ->where('workdaily.date', '=', $request['Day'])
                ->where('workdaily.department_id', $alldata['departmentsId'])
                ->where('workdaily.responsibility', $alldata['userName'])
                ->get();
            }elseif($alldata['Day'] && $alldata['teamId']!= 0 && $alldata['departmentsId']!=0 && $alldata['userName']!=null ){
                $workDaily = Workdaily::select('workdaily.*')
               
                ->where('workdaily.date', '=', $request['Day'])
                ->where('workdaily.department_id', $alldata['departmentsId'])
                ->where('workdaily.team_id', $alldata['teamId'])
                ->where('workdaily.responsibility', $alldata['userName'])
                ->get();
            }elseif($alldata['Day'] && $alldata['teamId']!= 0 && $alldata['departmentsId']==0 && $alldata['userName']!=null ){
                $workDaily = Workdaily::select('workdaily.*')
               
                ->where('workdaily.date', '=', $request['Day'])
                ->where('workdaily.department_id', $alldata['departmentsId'])
                ->where('workdaily.team_id', $alldata['teamId'])
                ->where('workdaily.responsibility', $alldata['userName'])
                ->get();
            }
        }else{
            if($alldata['Day'] && $alldata['teamId']== 0 && $alldata['userName']==null){
                $workDaily = Workdaily::select('workdaily.*')
               
                ->where('workdaily.date', '=', $request['Day'])
                ->where('workdaily.department_id', $user['department_id'])
                ->get();
            }elseif($alldata['Day'] && $alldata['teamId']!= 0 && $alldata['userName']==null){
                $workDaily = Workdaily::select('workdaily.*')
               
                ->where('workdaily.date', '=', $request['Day'])
                ->where('workdaily.department_id', $user['department_id'])
                ->where('workdaily.team_id', $alldata['teamId'])
                ->get();
            }elseif($alldata['Day'] && $alldata['teamId']== 0 && $alldata['userName']!=null){
                $workDaily = Workdaily::select('workdaily.*')
               
                ->where('workdaily.date', '=', $request['Day'])
                ->where('workdaily.department_id', $user['department_id'])
                ->where('workdaily.responsibility', $alldata['userName'])
                ->get();
            }elseif($alldata['Day'] && $alldata['teamId']!= 0 && $alldata['userName']!=null){
                $workDaily = Workdaily::select('workdaily.*')
               
                ->where('workdaily.date', '=', $request['Day'])
                ->where('workdaily.department_id', $user['department_id'])
                ->where('workdaily.team_id', $alldata['teamId'])
                ->where('workdaily.responsibility', $alldata['userName'])
                ->get();
            }
        }
        if ($user['position_id'] == 1 || $user['position_id'] == 2) {
            $departments = Department::get();
        } elseif ($user['position_id'] == 3) {
            $departments = Department::where('trademark_id', 1)->get();
        } elseif ($user['position_id'] == 4) {
            $departments = Department::where('trademark_id', 2)->get();
        } else {
            // dd($workDaily->toArray());
            return view('plan.listPlanDaily', compact('userById', 'user', 'workDaily', 'teams','today'));
        }
        // dd($workDaily->toArray());
        return view('plan.listPlanDaily', compact('user', 'today', 'teams', 'userById'))->with(compact('start'))->with(compact('workDaily'))->with(compact('departments'));
    }

    public function assignCreatWorkDaily(){
        $allUser = User::get();
        $user = Auth::user();
        if ($user['position_id'] == 1 || $user['position_id'] == 2) {
            $userAssign = User::get();
        } elseif ($user['position_id'] == 3) {
            $userAssign = User::join('departments', 'users.department_id', '=', 'departments.id')->join('trademark', 'departments.trademark_id', '=', 'trademark.id')->where('departments.trademark_id', 1)->select('users.*')->get();
        } elseif ($user['position_id'] == 4) {
            $userAssign = User::join('departments', 'users.department_id', '=', 'departments.id')->join('trademark', 'departments.trademark_id', '=', 'trademark.id')->where('departments.trademark_id', 2)->select('users.*')->get();
        } else {
            $userAssign = User::where('department_id', $user['department_id'])->get();
        }
        return view('plan.creat.formAssignWork',compact('user','allUser','userAssign'));
    }

    public function assignCreatWorkDailyPost(request $request){
        $mytime = date('Y-m-d H:i:s');
        $user = Auth::user();
        $alldata = $request->all();
        $userAssign = User::where('id',$alldata['responsibility'])->first();
        // dd($userAssign->toarray());   
        if(isset($alldata['support'])){
            $supportJson = json_encode($alldata['support'], true);
            $supportArray =  json_decode($supportJson, true);
            $supportString = implode("\n", $supportArray);
        }else{
            $supportString = null;
        }
         Workdaily::insert(
            [
                'categoryDaily' => $alldata['categoryDaily'],
                'describeDaily' => $alldata['describeDaily'],
                'support' => isset($supportString) ? $supportString : null,
                'responsibility' => $userAssign['name'],
                'time'=>$alldata['time'],
                'ResultByWookWeek'=>100,
                'date'=>$alldata['date'],
                'note' => $alldata['note'],
                'department_id' => $userAssign['department_id'],
                'team_id' => $userAssign['team_id'],
                'created_at' => $mytime,
                'updated_at' => $mytime
            ],);
            return redirect()->route('listWorkDaily')->with('successfully', 'Giao việc thành công');  
    }
}

