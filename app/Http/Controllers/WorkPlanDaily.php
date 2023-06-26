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
    // In your controller
    public function checkTime(Request $request) {
        $date = $request->input('date');
        $responsibility = $request->input('responsibility', auth()->user()->name);
    
        $workweekTime = Workdaily::whereDate('date', $date)
            ->where('responsibility', $responsibility)
            ->where(DB::raw('(CAST(time as UNSIGNED) IS NOT NULL)'), true)
            ->sum(DB::raw('CAST(time as UNSIGNED)'));
    
        return response()->json([
            'timeOverload' => $workweekTime > 8,
        ]);
    }
    

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
        $mytime = date('Y-m-d H:i:s');
        $user = Auth::user();
        $alldata = $request->all();   
        if(isset($alldata['support'])){
            $supportJson = json_encode($alldata['support'], true);
            $supportArray =  json_decode($supportJson, true);
            $supportString = implode("\n", $supportArray);
        } else {
            $supportString = null;
        }
    
        $status = 1; // default status
    
        if (empty($user['team_id']) || $user['position_id']==7) {
            $status = 2; // set status to 2 if team_id is not set
        }
    
        if (in_array($user['position_id'], [1, 2, 3, 4, 5, 6])) {
            $status = 0; // set status to 0 if position is one of the specified values
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
                'status' => $status,
                'created_at' => $mytime,
                'updated_at' => $mytime
            ],);
        return redirect()->route('viewApproveDaily')->with('successful', 'Thêm kế hoạch thành công');  
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
        // dd($request->toArray());
        if(isset($request['support'])){
            $supportJson = json_encode($request['support'], true);
            $supportArray =  json_decode($supportJson, true);
            $supportString = implode("\n", $supportArray);
        }else{
            $supportString = null;
        }
        $workDaily = Workdaily::find($id);
        $user = Auth::user();
        $status = 1; // default status
    
        if (empty($user['team_id']) || $user['position_id']==7) {
            $status = 2; // set status to 2 if team_id is not set
        }
    
        if (in_array($user['position_id'], [1, 2, 3, 4, 5, 6])) {
            $status = 0; // set status to 0 if position is one of the specified values
        }
        if($request->Result == null && $request->ResultByWookWeek == null){
            return back()->with('message', 'Bạn đã thực hiện thất bại!');
        }else{
        $countWorkWeek_id = Workdaily::where('workweek_id', $workDaily->workweek_id)
        ->select(DB::raw('SUM(ResultByWookWeek) as total'))
        ->first();
        if($countWorkWeek_id->total<100){
        $workDaily = Workdaily::find($id);
        // dd($workDaily->toArray());
        $workDaily->support = $supportString;
        $workDaily->inadequacy = $request->inadequacy;
        $workDaily->describeDaily = $request->describeDaily;
        $workDaily->time = $request->time;
        $workDaily->propose = $request->propose;
        $workDaily->Result = $request->Result;
        $workDaily->ResultByWookWeek = $request->ResultByWookWeek;
        $workDaily->status = $status;
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
        $user = Auth::user();
        if(isset($request['support']) && is_array($request['support'])){
            $supportJson = json_encode($request['support']);
            $supportArray = json_decode($supportJson, true);
            $supportString = implode("\n", $supportArray);
        } else {
            $supportString = null;
        }
        $status = 1; // default status
    
        if (empty($user['team_id']) || $user['position_id']==7) {
            $status = 2; // set status to 2 if team_id is not set
        }
    
        if (in_array($user['position_id'], [1, 2, 3, 4, 5, 6])) {
            $status = 0; // set status to 0 if position is one of the specified values
        }
        $workDaily = Workdaily::find($id);
        if($workDaily){
            $workDaily->categoryDaily = $request->categoryDaily;
            $workDaily->describeDaily = $request->describeDaily;
            $workDaily->support = $supportString;
            $workDaily->time = $request->time;
            $workDaily->date = $request->date;            
            $workDaily->status = $status;
            $workDaily->note = $request->note;
            $workDaily->save();
        }
        return redirect()->route('viewApproveDaily')->with('edit', 'Sửa thành công')->with('hack', $id);
    }

    public function deleteWorkDaily(request $request){
        $deleteWorkDaily = Workdaily::find($request->id);
        $deleteWorkDaily->delete();
            return response()->json(['message' => 'Cập nhật thành công!'], 200);
    }

    public function searchWorkDaily(Request $request)
    {
        
        $departments = Department::get();
        $teams = Team::get();
        $user = Auth::user();
        $alldata = $request->all();
        $today = date('Y-m-d');

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
        
        
        $workDaily = Workdaily::query();
    
        // Begin with status 0
        $workDaily->where('status', 0);
    
        // If department is chosen
        if($alldata['departmentsId'] ?? 0 != 0) {
            $workDaily->where('department_id', $alldata['departmentsId']);
        }
    
        // If team is chosen
        if($alldata['teamId'] ?? 0 != 0) {
            $workDaily->where('team_id', $alldata['teamId']);
        }
    
        // If user is chosen
        if($alldata['userName'] ?? null != null) {
            $workDaily->where('responsibility', $alldata['userName']);
        }
    
        // If date is chosen
        if($alldata['Day'] ?? null != null) {
            $workDaily->where('date', '=', $request['Day']);
        }
    
        $workDaily = $workDaily->get();
    
        // Include more data according to the user's position.
        switch ($user['position_id']) {
            case 1:
            case 2:
                $departments = Department::get();
                return view('plan.listPlanDaily', compact('user','userById', 'today', 'teams', 'workDaily', 'departments'));
            case 3:
            case 4:
                $departments = Department::where('trademark_id', $user['position_id'] - 2)->get();
                return view('plan.listPlanDaily', compact('user','userById', 'today', 'teams', 'workDaily', 'departments'));
            default:
                return view('plan.listPlanDaily', compact('user','userById', 'today', 'teams', 'workDaily'));
        }
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
        // dd($request->toarray());
        $mytime = date('Y-m-d H:i:s');
        $user = Auth::user();
        $alldata = $request->all();
        $userAssign = User::where('id',$alldata['responsibility'])->first();
        // dd($userAssign);   
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
                'status' => 0,
                'team_id' => $userAssign['team_id'],
                'created_at' => $mytime,
                'updated_at' => $mytime
            ],);
            return redirect()->route('listWorkDaily')->with('successfully', 'Giao việc thành công');  
    }

   
}

