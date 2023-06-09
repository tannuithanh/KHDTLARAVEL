<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Team;
use App\Models\User;
use App\Models\Workweek;
use App\Models\Workdaily;
use App\Models\Workmonth;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApproveDaiLyWeekly extends Controller
{
    public function viewApproveDaily(){
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
            return view('plan.approveDaily', compact('userById', 'user', 'teams','workDaily','today'));
        }
        // dd($workDaily->toArray());
        return view('plan.approveDaily',compact('user','teams','userById','departments','workDaily','today'));
    }
    public function viewApproveDailyPost(request $request){
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
        $workDaily->whereIn('status', [1, 2]);
    
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
                return view('plan.approveDaily', compact('user','userById', 'today', 'teams', 'workDaily', 'departments'));
            case 3:
            case 4:
                $departments = Department::where('trademark_id', $user['position_id'] - 2)->get();
                return view('plan.approveDaily', compact('user','userById', 'today', 'teams', 'workDaily', 'departments'));
            default:
                return view('plan.approveDaily', compact('user','userById', 'today', 'teams', 'workDaily'));
        }
    
    }
    public function viewdenyDaily(){
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
            return view('plan.denyDaily', compact('userById', 'user', 'teams','workDaily','today'));
        }
        // dd($workDaily->toArray());
        return view('plan.denyDaily',compact('user','teams','userById','departments','workDaily','today'));
    }
    public function viewDenyDailyPost(request $request){
        // dd($request->toarray());
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
        $workDaily->whereIn('status', [3, -1]);
    
        // If department is chosen
        if($alldata['departmentsId'] ?? 0 != 0) {
            $workDaily->where('department_id', $alldata['departmentsId']);
        }
        
        // The same approach for 'teamId' and other keys
        if($alldata['teamId'] ?? 0 != 0) {
            $workDaily->where('team_id', $alldata['teamId']);
        }
        
        // For 'userName'
        if($alldata['userName'] ?? null != null) {
            $workDaily->where('responsibility', $alldata['userName']);
        }
        
        // For 'Day'
        if($alldata['Day'] ?? null != null) {
            $workDaily->where('date', '=', $request['Day']);
        }
    
        $workDaily = $workDaily->get();
    
        // Include more data according to the user's position.
        switch ($user['position_id']) {
            case 1:
            case 2:
                $departments = Department::get();
                return view('plan.denyDaily', compact('user','userById', 'today', 'teams', 'workDaily', 'departments'));
            case 3:
            case 4:
                $departments = Department::where('trademark_id', $user['position_id'] - 2)->get();
                return view('plan.denyDaily', compact('user','userById', 'today', 'teams', 'workDaily', 'departments'));
            default:
                return view('plan.denyDaily', compact('user','userById', 'today', 'teams', 'workDaily'));
        }
    
    }
    public function aprroveTP(request $request){
        $workdaily = Workdaily::find($request->id);
        if ($workdaily) {
            $workdaily->status = 0;
            $workdaily->save();

            return response()->json(['message' => 'Cập nhật thành công!'], 200);
        } else {
            return response()->json(['error' => 'Không tìm thấy dữ liệu'], 404);
        }
    }
    public function denyTP(request $request){
        $workdaily = Workdaily::find($request->id);
        if ($workdaily) {
            $workdaily->status = 3;
            $workdaily->save();

            return response()->json(['message' => 'Cập nhật thành công!'], 200);
        } else {
            return response()->json(['error' => 'Không tìm thấy dữ liệu'], 404);
        }
    }
    public function aprroveTN(request $request){
        $workdaily = Workdaily::find($request->id);
        if ($workdaily) {
            $workdaily->status = 2;
            $workdaily->save();

            return response()->json(['message' => 'Cập nhật thành công!'], 200);
        } else {
            return response()->json(['error' => 'Không tìm thấy dữ liệu'], 404);
        }
    }
    public function denyTN(request $request){
        $workdaily = Workdaily::find($request->id);
        if ($workdaily) {
            $workdaily->status = 3;
            $workdaily->save();

            return response()->json(['message' => 'Cập nhật thành công!'], 200);
        } else {
            return response()->json(['error' => 'Không tìm thấy dữ liệu'], 404);
        }
    }

    public function ChartWeek(request $request){
        $today = date('Y-m-d');
        $weekStart = $request->input('week_start', $today);
        $weekStart = Carbon::parse($weekStart);
        $weekEnd = $weekStart->copy()->endOfWeek()->toDateString();
        $weekStart = $weekStart->startOfWeek()->toDateString();
        
    
        // Get user from Auth
        $user = Auth::user();
    
        // Initialize the WorkWeeks
        $workWeeks = Workweek::query();
    
        switch ($user->position_id) {
            case 1:
            case 2:
                // Giám đốc và Phó giám đốc có quyền xem tất cả
                break;
            case 3:
                // Phó giám đốc khối thiết kế
                $workWeeks = $workWeeks->whereHas('department', function($query) {
                    $query->where('trademark_id', 1);
                });
                break;
            case 4:
                // Phó giám đốc xưởng sản xuất mẫu
                $workWeeks = $workWeeks->whereHas('department', function($query) {
                    $query->where('trademark_id', 2);
                });
                break;
            case 5:
            case 6:
            case 7:
            case 8:
            case 9:
            case 10:
                // Trưởng phòng, Phó phòng, Trưởng bộ phận, Trưởng nhóm, Chuyên viên, Chuyên viên (Hành chính đơn vị)
                $workWeeks = $workWeeks->where(function ($query) use ($user) {
                    $query->where('department_id', $user->department_id)
                        ->orWhere('department_id', $user->department_id1);
                });
                break;
            default:
                // Không có quyền
                $workWeeks = $workWeeks->whereNull('id');
                break;
        }
        
        // Filter by date
        $workWeeks = $workWeeks->whereBetween('startdate', [$weekStart, $weekEnd])->get();

    
        $workInProgressCount = $workWeeks->where('status', 0)->count();
        $completedWorkCount = $workWeeks->where('status', 4)->count();
        // dd($workWeeks->toarray());
        return view('plan.ChartWeek',compact('user','workInProgressCount', 'completedWorkCount','weekStart','weekEnd'));
    }

   

//-------------------------------- TUẦN --------------------------/
    public function viewApproveWeek(){
            $user = User::select('users.*', 'departments.name as department_name', 'teams.name as team_name')
            ->join('departments', 'departments.id', '=', 'users.department_id')
            ->leftjoin('teams', 'teams.id', '=', 'users.team_id')
            ->where('users.id', Auth::user()->id)
            ->first();
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
    
            $mydate = date('Y-m-d');
            $date = Carbon::parse();
            $weekNumber = $date->weekOfMonth;
            $month = now()->format('m');
            // dd($weekNumber);
            $start = $date->startOfWeek()->toDateString();
            $end = $date->endOfWeek()->toDateString();
            $formattedDateStart = date_create_from_format('Y-m-d', $start)->format('d/m/Y');
            $formattedDateEnd = date_create_from_format('Y-m-d', $end)->format('d/m/Y');
            
            //------------ Lấy chuối ngày từ ngày bắt đầu đến ngày kết thúc ------------//
                $startDate = Carbon::parse()->startOfWeek();
                $endDate = Carbon::parse()->endOfWeek();
                $dates = array();
                for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                    $dates[] = $date->format('Y-m-d');
                }
                // dd($dates);
            //------------ Lấy dữ liệu công việc theo chức vụ ------------//    
            if ($user['position_id'] == 1 || $user['position_id'] == 2) {
                $workWeek = Workweek::select('workweek.*')
                ->whereBetween('startdate', [$start, $end])
                ->whereBetween('enddate', [$start, $end])
                ->get();
            } elseif ($user['position_id'] == 3) {
                $workWeek = Workweek::select('workweek.*')
                ->join('departments', 'workweek.department_id', '=', 'departments.id')
                ->join('trademark', 'departments.trademark_id', '=', 'trademark.id')
                ->where(function($query) use ($start, $end) {
                    $query->whereBetween('startdate', [$start, $end])
                          ->whereBetween('enddate', [$start, $end])
                          ->orWhere('workweek.responsibility', 'Tô Tấn Sơn');
                })
                ->where('trademark.id', '=', 1)
                ->get();
            } elseif ($user['position_id'] == 4) {
                $workWeek = Workweek::select('workweek.*')
                ->join('departments', 'workweek.department_id', '=', 'departments.id')
                ->join('trademark', 'departments.trademark_id', '=', 'trademark.id')
                ->whereBetween('startdate', [$start, $end])
                ->whereBetween('enddate', [$start, $end])
                ->where('trademark.id', '=', 2)
                ->get();
            } else {
                $workWeek = Workweek::select('workweek.*')
                ->join('departments', 'workweek.department_id', '=', 'departments.id')
                ->whereBetween('startdate', [$start, $end])
                ->whereBetween('enddate', [$start, $end])
                ->where('workweek.department_id', '=', $user['department_id'])
                ->get();
            }            
            if ($user['position_id'] == 1 || $user['position_id'] == 2) {
                $departments = Department::get();
            } elseif ($user['position_id'] == 3) {
                $departments = Department::where('trademark_id', 1)->get();
            } elseif ($user['position_id'] == 4) {
                $departments = Department::where('trademark_id', 2)->get();
            } else {
               
                return view('plan.approveWeek', compact('userById', 'user', 'workWeek', 'start', 'end', 'weekNumber', 'formattedDateStart', 'formattedDateEnd', 'mydate', 'teams','month','dates'));
            }
    
            return view('plan.approveWeek', compact('userById', 'user', 'workWeek', 'start', 'end', 'weekNumber', 'formattedDateStart', 'formattedDateEnd', 'mydate', 'teams', 'departments','month','dates'));
    }
    public function viewApproveWeekPost(request $request){
        $departments = Department::get();
        $alldata = $request->all();
        $user = Auth::user();
    
        // Get teams and users based on the position_id
        $teams="";
        $userById="";
        switch($user['position_id']) {
            case 1:
            case 2:
                $teams = Team::get();
                $excludes = [5,6];
                $userById = User::whereNotIn('position_id', $excludes)->get();
                break;
            case 3:
                $teams = Team::join('departments', 'teams.department_id', '=', 'departments.id')->join('trademark', 'departments.trademark_id', '=', 'trademark.id')->where('departments.trademark_id', 1)->select('teams.*')->get();
                $includes = [3,4];
                $userById = User::whereIn('position_id', $includes)->get();
                break;
            case 4:
                $teams = Team::join('departments', 'teams.department_id', '=', 'departments.id')->join('trademark', 'departments.trademark_id', '=', 'trademark.id')->where('departments.trademark_id', 2)->select('teams.*')->get();
                $includes = [3,4];
                $userById = User::whereIn('position_id', $includes)->get();
                break;
            default:
                $teams = Team::where('department_id', $user['department_id'])->get();
                $userById = User::where('department_id', $user['department_id'])->get();
                break;
        }
    
        // Handle the case when Day is present in the request
        if ($alldata['Day']) {
            $date = Carbon::parse($alldata['Day']);
            $weekNumber = $date->weekOfMonth;
            $month = now()->format('m');
            $start = $date->startOfWeek()->toDateString();
            $end = $date->endOfWeek()->toDateString();
            $formattedDateStart = date_create_from_format('Y-m-d', $start)->format('d/m/Y');
            $formattedDateEnd = date_create_from_format('Y-m-d', $end)->format('d/m/Y');
            $startDate = Carbon::parse($request['Day'])->startOfWeek();
            $endDate = Carbon::parse($request['Day'])->endOfWeek();
            $dates = array();
            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                $dates[] = $date->format('Y-m-d');
            }
    
            // Query Workweek base on provided criteria
            $query = Workweek::query();
            $query->where('workweek.startdate', '>=', $start)
                ->where('workweek.enddate', '<=', $end)
                ->whereIn('workweek.status', [1,2]);
    
            // Add filters
            if($alldata['teamId'] != 0) {
                $query->where('workweek.team_id', $alldata['teamId']);
            }
            
            if(isset($alldata['departmentsId']) && $alldata['departmentsId'] != 0) {
                $query->where('workweek.department_id', $alldata['departmentsId']);
            }
            
            if(isset($alldata['userName']) && $alldata['userName'] != null){
                $query->where('workweek.responsibility', $alldata['userName']);
            }
    
            // Execute the query
            $workWeek = $query->get();
        }
    
        return view('plan.approveWeek', compact('departments', 'teams', 'userById', 'workWeek','user','weekNumber','month','formattedDateStart','formattedDateEnd','dates'));
    }
    public function viewDenyWeek(){
            $user = User::select('users.*', 'departments.name as department_name', 'teams.name as team_name')
            ->join('departments', 'departments.id', '=', 'users.department_id')
            ->leftjoin('teams', 'teams.id', '=', 'users.team_id')
            ->where('users.id', Auth::user()->id)
            ->first();
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

            $mydate = date('Y-m-d');
            $date = Carbon::parse();
            $weekNumber = $date->weekOfMonth;
            $month = now()->format('m');
            // dd($weekNumber);
            $start = $date->startOfWeek()->toDateString();
            $end = $date->endOfWeek()->toDateString();
            $formattedDateStart = date_create_from_format('Y-m-d', $start)->format('d/m/Y');
            $formattedDateEnd = date_create_from_format('Y-m-d', $end)->format('d/m/Y');
            
            //------------ Lấy chuối ngày từ ngày bắt đầu đến ngày kết thúc ------------//
                $startDate = Carbon::parse()->startOfWeek();
                $endDate = Carbon::parse()->endOfWeek();
                $dates = array();
                for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                    $dates[] = $date->format('Y-m-d');
                }
                // dd($dates);
            //------------ Lấy dữ liệu công việc theo chức vụ ------------//    
            if ($user['position_id'] == 1 || $user['position_id'] == 2) {
                $workWeek = Workweek::select('workweek.*')
                ->whereBetween('startdate', [$start, $end])
                ->whereBetween('enddate', [$start, $end])
                ->get();
            } elseif ($user['position_id'] == 3) {
                $workWeek = Workweek::select('workweek.*')
                ->join('departments', 'workweek.department_id', '=', 'departments.id')
                ->join('trademark', 'departments.trademark_id', '=', 'trademark.id')
                ->where(function($query) use ($start, $end) {
                    $query->whereBetween('startdate', [$start, $end])
                          ->whereBetween('enddate', [$start, $end])
                          ->orWhere('workweek.responsibility', 'Tô Tấn Sơn');
                })
                ->where('trademark.id', '=', 1)
                ->get();
            } elseif ($user['position_id'] == 4) {
                $workWeek = Workweek::select('workweek.*')
                ->join('departments', 'workweek.department_id', '=', 'departments.id')
                ->join('trademark', 'departments.trademark_id', '=', 'trademark.id')
                ->whereBetween('startdate', [$start, $end])
                ->whereBetween('enddate', [$start, $end])
                ->where('trademark.id', '=', 2)
                ->get();
            } else {
                $workWeek = Workweek::select('workweek.*')
                ->join('departments', 'workweek.department_id', '=', 'departments.id')
                ->whereBetween('startdate', [$start, $end])
                ->whereBetween('enddate', [$start, $end])
                ->where('workweek.department_id', '=', $user['department_id'])
                ->get();
            }            
            if ($user['position_id'] == 1 || $user['position_id'] == 2) {
                $departments = Department::get();
            } elseif ($user['position_id'] == 3) {
                $departments = Department::where('trademark_id', 1)->get();
            } elseif ($user['position_id'] == 4) {
                $departments = Department::where('trademark_id', 2)->get();
            } else {
            
                return view('plan.denyWeekly', compact('userById', 'user', 'workWeek', 'start', 'end', 'weekNumber', 'formattedDateStart', 'formattedDateEnd', 'mydate', 'teams','month','dates'));
            }

            return view('plan.denyWeekly', compact('userById', 'user', 'workWeek', 'start', 'end', 'weekNumber', 'formattedDateStart', 'formattedDateEnd', 'mydate', 'teams', 'departments','month','dates'));
    }
    public function viewDenyWeekPost(request $request){
        $departments = Department::get();
        $alldata = $request->all();
        $user = Auth::user();
    
        // Get teams and users based on the position_id
        $teams="";
        $userById="";
        switch($user['position_id']) {
            case 1:
            case 2:
                $teams = Team::get();
                $excludes = [5,6];
                $userById = User::whereNotIn('position_id', $excludes)->get();
                break;
            case 3:
                $teams = Team::join('departments', 'teams.department_id', '=', 'departments.id')->join('trademark', 'departments.trademark_id', '=', 'trademark.id')->where('departments.trademark_id', 1)->select('teams.*')->get();
                $includes = [3,4];
                $userById = User::whereIn('position_id', $includes)->get();
                break;
            case 4:
                $teams = Team::join('departments', 'teams.department_id', '=', 'departments.id')->join('trademark', 'departments.trademark_id', '=', 'trademark.id')->where('departments.trademark_id', 2)->select('teams.*')->get();
                $includes = [3,4];
                $userById = User::whereIn('position_id', $includes)->get();
                break;
            default:
                $teams = Team::where('department_id', $user['department_id'])->get();
                $userById = User::where('department_id', $user['department_id'])->get();
                break;
        }
    
        // Handle the case when Day is present in the request
        if ($alldata['Day']) {
            $date = Carbon::parse($alldata['Day']);
            $weekNumber = $date->weekOfMonth;
            $month = now()->format('m');
            $start = $date->startOfWeek()->toDateString();
            $end = $date->endOfWeek()->toDateString();
            $formattedDateStart = date_create_from_format('Y-m-d', $start)->format('d/m/Y');
            $formattedDateEnd = date_create_from_format('Y-m-d', $end)->format('d/m/Y');
            $startDate = Carbon::parse($request['Day'])->startOfWeek();
            $endDate = Carbon::parse($request['Day'])->endOfWeek();
            $dates = array();
            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                $dates[] = $date->format('Y-m-d');
            }
    
            // Query Workweek base on provided criteria
            $query = Workweek::query();
            $query->where('workweek.startdate', '>=', $start)
                ->where('workweek.enddate', '<=', $end)
                ->whereIn('workweek.status', [-1,3]);
    
            // Add filters
            if($alldata['teamId'] != 0) {
                $query->where('workweek.team_id', $alldata['teamId']);
            }
            
            if(isset($alldata['departmentsId']) && $alldata['departmentsId'] != 0) {
                $query->where('workweek.department_id', $alldata['departmentsId']);
            }
            
            if(isset($alldata['userName']) && $alldata['userName'] != null){
                $query->where('workweek.responsibility', $alldata['userName']);
            }
    
            // Execute the query
            $workWeek = $query->get();
        }
    
        return view('plan.denyWeekly', compact('departments', 'teams', 'userById', 'workWeek','user','weekNumber','month','formattedDateStart','formattedDateEnd','dates'));
    }
    public function WeekAprroveTN(request $request){
        $Workweek = Workweek::find($request->id);
        if ($Workweek) {
            $Workweek->status = 2;
            $Workweek->save();

            return response()->json(['message' => 'Cập nhật thành công!'], 200);
        } else {
            return response()->json(['error' => 'Không tìm thấy dữ liệu'], 404);
        }
    }
    public function WeekdenyTN(request $request){
        $Workweek = Workweek::find($request->id);
        if ($Workweek) {
            $Workweek->status = 3;
            $Workweek->save();

            return response()->json(['message' => 'Cập nhật thành công!'], 200);
        } else {
            return response()->json(['error' => 'Không tìm thấy dữ liệu'], 404);
        }
    }
    public function WeekaprroveTP(request $request){
        $Workweek = Workweek::find($request->id);
        if ($Workweek) {
            $Workweek->status = 0;
            $Workweek->save();
            $startdate = Carbon::parse($Workweek->startdate);
            $enddate = Carbon::parse($Workweek->enddate);
            $totalDays = $startdate->diffInDays($enddate) + 1;
            $percentagePerDay = 100 / $totalDays;
            for ($date = $startdate; $date->lte($enddate); $date->addDay()) {
                $workdaily = new Workdaily;

                $workdaily->workweek_id = $Workweek->id;
                $workdaily->date = $date->format('Y-m-d');
                $workdaily->categoryDaily = $Workweek->categoryWeek;
                $workdaily->responsibility = $Workweek->responsibility;
                $workdaily->department_id = $Workweek->department_id;
                $workdaily->team_id = $Workweek->team_id;
                $workdaily->status = -1;
                $workdaily->save();
            }
    
            return response()->json(['message' => 'Cập nhật thành công!'], 200);
        } else {
            return response()->json(['error' => 'Không tìm thấy dữ liệu'], 404);
        }
    }
    public function WeedenyTP(request $request){
        $Workweek = Workweek::find($request->id);
        if ($Workweek) {
            $Workweek->status = 3;
            $Workweek->save();

            return response()->json(['message' => 'Cập nhật thành công!'], 200);
        } else {
            return response()->json(['error' => 'Không tìm thấy dữ liệu'], 404);
        }
    }


//-------------------------------- THÁNG ----------------------------//
    public function listStartMonth(){
        $user = Auth::user();
        $position_id = $user->position_id;
        $department_id = $user->department_id;
        $department_id1 = $user->department_id1;
        $team_id = $user->team_id;
        //------- CÔNG VIỆC THÁNG------//
        $query = Workmonth::query()->where('status', 0);

        $departments = [];
        $teams = [];
        $users = [];
        $mydate = date('Y-m-d');
        if (in_array($position_id, [10, 9, 8, 7, 6, 5])) {
            $query->where('department_id', $department_id)
                ->orWhere('department_id', $department_id1)
                ->where('team_id', $team_id);
            $departments = Department::whereIn('id', [$department_id, $department_id1])->get();
            $teams = Team::where('department_id', $department_id)
                ->orWhere('department_id', $department_id1)
                ->get();
            $users = User::where('department_id', $department_id)
                ->orWhere('department_id', $department_id1)
                ->get();
        } 
        else if ($position_id == 4) {
            $department_ids = Department::where('trademark_id', 2)->pluck('id');
            $query->whereIn('department_id', $department_ids);
            $departments = Department::whereIn('id', $department_ids)->get();
            $teams = Team::whereIn('department_id', $department_ids)->get();
            $users = User::whereIn('department_id', $department_ids)->get();
        } 
        else if ($position_id == 3) {
            $department_ids = Department::where('trademark_id', 1)->pluck('id');
            $query->whereIn('department_id', $department_ids);
            $departments = Department::whereIn('id', $department_ids)->get();
            $teams = Team::whereIn('department_id', $department_ids)->get();
            $users = User::whereIn('department_id', $department_ids)->get();
        } 
        else if (in_array($position_id, [2, 1])) {
            $departments = Department::all();
            $teams = Team::all();
            $users = User::all();
        }
        // dd($users->toarray());
        $workmonths = $query->get();
        
        return view('plan.listPlanMonth', compact('user', 'workmonths', 'departments', 'teams', 'users','mydate'));
    }
    public function listStartMonthPost(request $request){
            $user = auth::user();
            $departmentId = $request->get('departmentsId');
            $teamId = $request->get('teamId');
            $userId = $request->get('userName');
            $startDate = $request->get('startMonth');
            $endDate = $request->get('endMonth');
            $position_id = $user->position_id;
            $department_id = $user->department_id;
            $department_id1 = $user->department_id1;
            $team_id = $user->team_id;
            $mydate = date('Y-m-d');
        
            // Initialize the query builder
            $query = WorkMonth::query();
            $query->where('status', 0);
        
            if ($startDate && $endDate) {
                $query->where(function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('startMonth', [$startDate, $endDate])
                        ->whereBetween('endMonth', [$startDate, $endDate]);
                });
            }
        
            if ($departmentId && !$teamId && !$userId) {
                $query->where('department_id', $departmentId);
            }
        
            if (!$departmentId && $teamId && !$userId) {
                $query->where('team_id', $teamId);
            }
        
            if (!$departmentId && !$teamId && $userId) {
                $query->where('responsibility', $userId);
            }
        
            if ($departmentId && $teamId && !$userId) {
                $query->where(function ($query) use ($departmentId, $teamId) {
                    $query->where('department_id', $departmentId)
                        ->where('team_id', $teamId);
                });
            }
        
            if (!$departmentId && $teamId && $userId) {
                $query->where(function ($query) use ($teamId, $userId) {
                    $query->where('team_id', $teamId)
                        ->where('responsibility', $userId);
                });
            }
        
            if ($departmentId && !$teamId && $userId) {
                $query->where(function ($query) use ($departmentId, $userId) {
                    $query->where('department_id', $departmentId)
                        ->where('responsibility', $userId);
                });
            }
        
            if ($departmentId && $teamId && $userId) {
                $query->where(function ($query) use ($departmentId, $teamId, $userId) {
                    $query->where('department_id', $departmentId)
                        ->where('team_id', $teamId)
                        ->where('responsibility', $userId);
                });
            }
        
            //In accordance with the positions, add the related department, team, and user conditions
            if (in_array($position_id, [10, 9, 8, 7, 6, 5])) {
                $query->where(function ($query) use ($user) {
                    $query->where('department_id', $user->department_id)
                        ->orWhere('department_id', $user->department_id1)
                        ->where('team_id', $user->team_id);
                });
            }
        
            $workmonths = $query->get();
            $departments = [];
            $teams = [];
            $users = [];
        
            if (in_array($position_id, [10, 9, 8, 7, 6, 5])) {
                $departments = Department::whereIn('id', [$department_id, $department_id1])->get();
                $teams = Team::where('department_id', $department_id)
                    ->orWhere('department_id', $department_id1)
                    ->get();
                $users = User::where('department_id', $department_id)
                    ->orWhere('department_id', $department_id1)
                    ->get();
            } else if ($position_id == 4) {
                $department_ids = Department::where('trade_mark_id', 2)->pluck('id');
                $departments = Department::whereIn('id', $department_ids)->get();
                $teams = Team::whereIn('department_id', $department_ids)->get();
                $users = User::whereIn('department_id', $department_ids)->get();
            } else if ($position_id == 3) {
                $department_ids = Department::where('trade_mark_id', 1)->pluck('id');
                $departments = Department::whereIn('id', $department_ids)->get();
                $teams = Team::whereIn('department_id', $department_ids)->get();
                $users = User::whereIn('department_id', $department_ids)->get();
            } else if (in_array($position_id, [2, 1])) {
                $departments = Department::all();
                $teams = Team::all();
                $users = User::all();
            }
        
                return view('plan.listPlanMonth',compact('mydate','user', 'workmonths', 'departments', 'teams', 'users'));
    }
    // 
       
    public function viewApproveMonthPost(request $request){
        $user = auth::user();
        $departmentId = $request->get('departmentsId');
        $teamId = $request->get('teamId');
        $userId = $request->get('userName');
        $startDate = $request->get('startMonth');
        $endDate = $request->get('endMonth');
        $position_id = $user->position_id;
        $department_id = $user->department_id;
        $department_id1 = $user->department_id1;
        $team_id = $user->team_id;
        $mydate = date('Y-m-d');
    
        // Initialize the query builder
        $query = WorkMonth::query();
        $query->whereIn('status', [1, 2]);
    
        if ($startDate && $endDate) {
            $query->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('startMonth', [$startDate, $endDate])
                    ->whereBetween('endMonth', [$startDate, $endDate]);
            });
        }
    
        if ($departmentId && !$teamId && !$userId) {
            $query->where('department_id', $departmentId);
        }
    
        if (!$departmentId && $teamId && !$userId) {
            $query->where('team_id', $teamId);
        }
    
        if (!$departmentId && !$teamId && $userId) {
            $query->where('responsibility', $userId);
        }
    
        if ($departmentId && $teamId && !$userId) {
            $query->where(function ($query) use ($departmentId, $teamId) {
                $query->where('department_id', $departmentId)
                    ->where('team_id', $teamId);
            });
        }
    
        if (!$departmentId && $teamId && $userId) {
            $query->where(function ($query) use ($teamId, $userId) {
                $query->where('team_id', $teamId)
                    ->where('responsibility', $userId);
            });
        }
    
        if ($departmentId && !$teamId && $userId) {
            $query->where(function ($query) use ($departmentId, $userId) {
                $query->where('department_id', $departmentId)
                    ->where('responsibility', $userId);
            });
        }
    
        if ($departmentId && $teamId && $userId) {
            $query->where(function ($query) use ($departmentId, $teamId, $userId) {
                $query->where('department_id', $departmentId)
                    ->where('team_id', $teamId)
                    ->where('responsibility', $userId);
            });
        }
    
        //In accordance with the positions, add the related department, team, and user conditions
        if (in_array($position_id, [10, 9, 8, 7, 6, 5])) {
            $query->where(function ($query) use ($user) {
                $query->where('department_id', $user->department_id)
                    ->orWhere('department_id', $user->department_id1)
                    ->where('team_id', $user->team_id);
            });
        }
    
        $workmonths = $query->get();
        $departments = [];
        $teams = [];
        $users = [];
    
        if (in_array($position_id, [10, 9, 8, 7, 6, 5])) {
            $departments = Department::whereIn('id', [$department_id, $department_id1])->get();
            $teams = Team::where('department_id', $department_id)
                ->orWhere('department_id', $department_id1)
                ->get();
            $users = User::where('department_id', $department_id)
                ->orWhere('department_id', $department_id1)
                ->get();
        } else if ($position_id == 4) {
            $department_ids = Department::where('trade_mark_id', 2)->pluck('id');
            $departments = Department::whereIn('id', $department_ids)->get();
            $teams = Team::whereIn('department_id', $department_ids)->get();
            $users = User::whereIn('department_id', $department_ids)->get();
        } else if ($position_id == 3) {
            $department_ids = Department::where('trade_mark_id', 1)->pluck('id');
            $departments = Department::whereIn('id', $department_ids)->get();
            $teams = Team::whereIn('department_id', $department_ids)->get();
            $users = User::whereIn('department_id', $department_ids)->get();
        } else if (in_array($position_id, [2, 1])) {
            $departments = Department::all();
            $teams = Team::all();
            $users = User::all();
        }

        return view('plan.approveMonth', compact('mydate','user', 'workmonths', 'departments', 'teams', 'users'));
    }
    public function viewApproveMonth()
    {
        $user = Auth::user();
        $position_id = $user->position_id;
        $department_id = $user->department_id;
        $department_id1 = $user->department_id1;
        $team_id = $user->team_id;
        //------- CÔNG VIỆC THÁNG------//
            $query = Workmonth::query()
                ->where('status', 1)
                ->orWhere('status', 2);
            $departments = [];
            $teams = [];
            $users = [];
        if (in_array($position_id, [10, 9, 8, 7, 6, 5])) {
            $query->where('department_id', $department_id)
                ->orWhere('department_id', $department_id1)
                ->where('team_id', $team_id);
            $departments = Department::whereIn('id', [$department_id, $department_id1])->get();
            $teams = Team::where('department_id', $department_id)
                ->orWhere('department_id', $department_id1)
                ->get();
            $users = User::where('department_id', $department_id)
                ->orWhere('department_id', $department_id1)
                ->get();
        } 
        else if ($position_id == 4) {
            $department_ids = Department::where('trademark_id', 2)->pluck('id');
            $query->whereIn('department_id', $department_ids);
            $departments = Department::whereIn('id', $department_ids)->get();
            $teams = Team::whereIn('department_id', $department_ids)->get();
            $users = User::whereIn('department_id', $department_ids)->get();
        } 
        else if ($position_id == 3) {
            $department_ids = Department::where('trademark_id', 1)->pluck('id');
            $query->whereIn('department_id', $department_ids);
            $departments = Department::whereIn('id', $department_ids)->get();
            $teams = Team::whereIn('department_id', $department_ids)->get();
            $users = User::whereIn('department_id', $department_ids)->get();
        } 
        else if (in_array($position_id, [2, 1])) {
            $departments = Department::all();
            $teams = Team::all();
            $users = User::all();
        }
        // dd($users->toarray());
        $workmonths = $query->get();

        return view('plan.approveMonth', compact('user', 'workmonths', 'departments', 'teams', 'users'));
    }
    public function viewDenyMonth(request $request){
        $user = Auth::user();
        $position_id = $user->position_id;
        $department_id = $user->department_id;
        $department_id1 = $user->department_id1;
        $team_id = $user->team_id;
        //------- CÔNG VIỆC THÁNG------//
            $query = Workmonth::query()
                ->where('status', 3);
                $departments = [];
                $teams = [];
                $users = [];
        
                if (in_array($position_id, [10, 9, 8, 7, 6, 5])) {
                    $query->where('department_id', $department_id)
                        ->orWhere('department_id', $department_id1)
                        ->where('team_id', $team_id);
                    $departments = Department::whereIn('id', [$department_id, $department_id1])->get();
                    $teams = Team::where('department_id', $department_id)
                        ->orWhere('department_id', $department_id1)
                        ->get();
                    $users = User::where('department_id', $department_id)
                        ->orWhere('department_id', $department_id1)
                        ->get();
                } 
                else if ($position_id == 4) {
                    $department_ids = Department::where('trademark_id', 2)->pluck('id');
                    $query->whereIn('department_id', $department_ids);
                    $departments = Department::whereIn('id', $department_ids)->get();
                    $teams = Team::whereIn('department_id', $department_ids)->get();
                    $users = User::whereIn('department_id', $department_ids)->get();
                } 
                else if ($position_id == 3) {
                    $department_ids = Department::where('trademark_id', 1)->pluck('id');
                    $query->whereIn('department_id', $department_ids);
                    $departments = Department::whereIn('id', $department_ids)->get();
                    $teams = Team::whereIn('department_id', $department_ids)->get();
                    $users = User::whereIn('department_id', $department_ids)->get();
                } 
                else if (in_array($position_id, [2, 1])) {
                    $departments = Department::all();
                    $teams = Team::all();
                    $users = User::all();
                }
                // dd($users->toarray());
                $workmonths = $query->get();

        return view('plan.denyMonth', compact('user', 'workmonths', 'departments', 'teams', 'users'));
    }
    public function viewDenyMonthPost(request $request){
        $user = auth::user();
        $departmentId = $request->get('departmentsId');
        $teamId = $request->get('teamId');
        $userId = $request->get('userName');
        $startDate = $request->get('startMonth');
        $endDate = $request->get('endMonth');
        $position_id = $user->position_id;
        $department_id = $user->department_id;
        $department_id1 = $user->department_id1;
        $team_id = $user->team_id;
        $mydate = date('Y-m-d');
    
        // Initialize the query builder
        $query = WorkMonth::query();
        $query->whereIn('status', [3, -1]);
    
        if ($startDate && $endDate) {
            $query->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('startMonth', [$startDate, $endDate])
                    ->whereBetween('endMonth', [$startDate, $endDate]);
            });
        }
    
        if ($departmentId && !$teamId && !$userId) {
            $query->where('department_id', $departmentId);
        }
    
        if (!$departmentId && $teamId && !$userId) {
            $query->where('team_id', $teamId);
        }
    
        if (!$departmentId && !$teamId && $userId) {
            $query->where('responsibility', $userId);
        }
    
        if ($departmentId && $teamId && !$userId) {
            $query->where(function ($query) use ($departmentId, $teamId) {
                $query->where('department_id', $departmentId)
                    ->where('team_id', $teamId);
            });
        }
    
        if (!$departmentId && $teamId && $userId) {
            $query->where(function ($query) use ($teamId, $userId) {
                $query->where('team_id', $teamId)
                    ->where('responsibility', $userId);
            });
        }
    
        if ($departmentId && !$teamId && $userId) {
            $query->where(function ($query) use ($departmentId, $userId) {
                $query->where('department_id', $departmentId)
                    ->where('responsibility', $userId);
            });
        }
    
        if ($departmentId && $teamId && $userId) {
            $query->where(function ($query) use ($departmentId, $teamId, $userId) {
                $query->where('department_id', $departmentId)
                    ->where('team_id', $teamId)
                    ->where('responsibility', $userId);
            });
        }
    
        //In accordance with the positions, add the related department, team, and user conditions
        if (in_array($position_id, [10, 9, 8, 7, 6, 5])) {
            $query->where(function ($query) use ($user) {
                $query->where('department_id', $user->department_id)
                    ->orWhere('department_id', $user->department_id1)
                    ->where('team_id', $user->team_id);
            });
        }
    
        $workmonths = $query->get();
        $departments = [];
        $teams = [];
        $users = [];
    
        if (in_array($position_id, [10, 9, 8, 7, 6, 5])) {
            $departments = Department::whereIn('id', [$department_id, $department_id1])->get();
            $teams = Team::where('department_id', $department_id)
                ->orWhere('department_id', $department_id1)
                ->get();
            $users = User::where('department_id', $department_id)
                ->orWhere('department_id', $department_id1)
                ->get();
        } else if ($position_id == 4) {
            $department_ids = Department::where('trade_mark_id', 2)->pluck('id');
            $departments = Department::whereIn('id', $department_ids)->get();
            $teams = Team::whereIn('department_id', $department_ids)->get();
            $users = User::whereIn('department_id', $department_ids)->get();
        } else if ($position_id == 3) {
            $department_ids = Department::where('trade_mark_id', 1)->pluck('id');
            $departments = Department::whereIn('id', $department_ids)->get();
            $teams = Team::whereIn('department_id', $department_ids)->get();
            $users = User::whereIn('department_id', $department_ids)->get();
        } else if (in_array($position_id, [2, 1])) {
            $departments = Department::all();
            $teams = Team::all();
            $users = User::all();
        }

        return view('plan.denyMonth', compact('mydate','user', 'workmonths', 'departments', 'teams', 'users'));
    }
    
    public function viewCreatWorkMonth(){
        $user = Auth::user();
        $allUser = User::get();
        return view('plan.creat.createWorkMonth', compact('user','allUser'));
    }

    public function InsertWorkMonth(request $request){
        // dd($request->toarray());
        $user = Auth::user();
        $status = 1; // default status
        
        if (empty($user['team_id']) || $user['position_id']==7) {
            $status = 2; // set status to 2 if team_id is not set
        }

        if (in_array($user['position_id'], [1, 2, 3, 4, 5, 6])) {
            $status = 0; // set status to 0 if position is one of the specified values
        }
        if(isset($request['support'])){
            $supportJson = json_encode($request['support'], true);
            $supportArray =  json_decode($supportJson, true);
            $supportString = implode("\n", $supportArray);
        }else{
            $supportString = null;
        }
        $startMonth = \Carbon\Carbon::parse($request->startMonth);
        $endMonth = \Carbon\Carbon::parse($request->endMonth);
    
        // Check if the end date is less than the start date or the difference between them is less than or equal to 7
        if ($endMonth->lt($startMonth) || $startMonth->diffInDays($endMonth) <= 7) {
            // Redirect back with error message
            return redirect()->back()->withErrors(['date_error' => 'Ngày kết thúc không được nhỏ hơn ngày bắt đầu và phải cách ngày bắt đầu ít nhất 7 ngày.']);
        }
        $workmonth = Workmonth::create([
            'categoryMonth' => $request->categoryMonth,
            'describeMonth' => $request->describeMonth,
            'responsibility' => $user['name'],
            'support' => isset($supportString) ? $supportString : null,
            'startMonth'=> $request->startMonth,
            'endMonth'=> $request->endMonth,
            'note' => $request->note,
            'status' => $status,
            'department_id'=>$user['department_id'],
            'team_id'=>$user['team_id'],
        ]);
        if(!$workmonth){
            return redirect()->route('creatWorkMonth');
        }else{
            return redirect()->route('viewApproveMonth');
        }
    }

    public function aprroveMonthTP(request $request){
        $workmonth = Workmonth::find($request->id);
        if ($workmonth) {
            $workmonth->status = 0;
            $workmonth->save();

            $start = Carbon::parse($workmonth->startMonth);
            $end = Carbon::parse($workmonth->endMonth);
            $numberOfWeeks = $start->diffInWeeks($end) + 1;

            // Thêm thông tin vào bảng Workweek cho mỗi tuần
            for ($i = 0; $i < $numberOfWeeks; $i++) {
                $workweek = new Workweek;
                $workweek->categoryWeek = $workmonth->categoryMonth;
                $workweek->responsibility = $workmonth->responsibility;
                $workweek->support = $workmonth->support;
                $workweek->department_id = $workmonth->department_id;
                $workweek->team_id = $workmonth->team_id;
                $workweek->note = $workmonth->note;
                $workweek->status = -1;

                // Calculate the start and end dates for this week
                $weekStartDate = $start->copy()->addWeeks($i)->startOfWeek();
                $weekEndDate = $weekStartDate->copy()->endOfWeek();

                if ($weekEndDate->gt($end)) {
                    $weekEndDate = $end->copy();
                }

                $workweek->startdate = $weekStartDate->toDateString();
                $workweek->enddate = $weekEndDate->toDateString();

                // Check each day of the week and assign null if it's a Sunday
                $workweek->monday = ($weekStartDate->copy()->dayOfWeek == 0) ? null : $workmonth->workDescription_mon;
                $workweek->tuesday = ($weekStartDate->copy()->addDay()->dayOfWeek == 0) ? null : $workmonth->workDescription_tue;
                $workweek->wednesday = ($weekStartDate->copy()->addDays(2)->dayOfWeek == 0) ? null : $workmonth->workDescription_wed;
                $workweek->thursday = ($weekStartDate->copy()->addDays(3)->dayOfWeek == 0) ? null : $workmonth->workDescription_thu;
                $workweek->friday = ($weekStartDate->copy()->addDays(4)->dayOfWeek == 0) ? null : $workmonth->workDescription_fri;
                $workweek->saturday = ($weekStartDate->copy()->addDays(5)->dayOfWeek == 0) ? null : $workmonth->workDescription_sat;
                $workweek->sunday = null;

                $workweek->save();
            }

            return response()->json(['message' => 'Cập nhật thành công!'], 200);
        } else {
            return response()->json(['error' => 'Không tìm thấy dữ liệu'], 404);
        }
    }

    public function denyMonthTP(request $request){
          $workmonth = Workmonth::find($request->id);
        if ($workmonth) {
            $workmonth->status = 3;
            $workmonth->save();

            return response()->json(['message' => 'Cập nhật thành công!'], 200);
        } else {
            return response()->json(['error' => 'Không tìm thấy dữ liệu'], 404);
        }
    }

    public function aprroveMonthTN(request $request){
        $workmonth = Workmonth::find($request->id);
        if ($workmonth) {
            $workmonth->status = 2;
            $workmonth->save();

            return response()->json(['message' => 'Cập nhật thành công!'], 200);
        } else {
            return response()->json(['error' => 'Không tìm thấy dữ liệu'], 404);
        }
    }

    public function denyMonthTN(request $request){
        $workmonth = Workmonth::find($request->id);
        if ($workmonth) {
            $workmonth->status = 3;
            $workmonth->save();

            return response()->json(['message' => 'Cập nhật thành công!'], 200);
        } else {
            return response()->json(['error' => 'Không tìm thấy dữ liệu'], 404);
        }
    }
    public function editWorkMonthGet($id){
        $allUser = User::get();
        $user = Auth::user();
        $workmonth = Workmonth::find($id);
        // dd($workmonth->toarray());
        return view('plan.creat.editWorkMonth',compact('id','user','allUser','workmonth'));
    }

    public function editWorkMonthPost(request $request, $id){
        $user = Auth::user();
        $status = 1; // default status
        
        if (empty($user['team_id']) || $user['position_id']==7) {
            $status = 2; // set status to 2 if team_id is not set
        }
    
        if (in_array($user['position_id'], [1, 2, 3, 4, 5, 6])) {
            $status = 0; // set status to 0 if position is one of the specified values
        }
        if(isset($request['support'])){
            $supportJson = json_encode($request['support'], true);
            $supportArray =  json_decode($supportJson, true);
            $supportString = implode("\n", $supportArray);
        }else{
            $supportString = null;
        }
        
        // Compare the dates using Carbon
        $startMonth = \Carbon\Carbon::parse($request->startMonth);
        $endMonth = \Carbon\Carbon::parse($request->endMonth);
    
        // Check if the end date is less than the start date or the difference between them is less than or equal to 7
        if ($endMonth->lt($startMonth) || $startMonth->diffInDays($endMonth) <= 7) {
            // Redirect back with error message
            return redirect()->back()->withErrors(['date_error' => 'Ngày kết thúc không được nhỏ hơn ngày bắt đầu và phải cách ngày bắt đầu ít nhất 7 ngày.']);
        }
    
        $workmonth = Workmonth::find($id); // Get the specific workmonth record from database
    
        // Check if the workmonth record exists
        if(!$workmonth){
            // If not, redirect to some error page or show some error message
            return redirect()->route('creatWorkMonth');
        }
    
        $workmonth->update([
            'categoryMonth' => $request->categoryMonth,
            'describeMonth' => $request->describeMonth,
            'responsibility' => $user['name'],
            'support' => isset($supportString) ? $supportString : null,
            'startMonth'=> $request->startMonth,
            'endMonth'=> $request->endMonth,
            'note' => $request->note,
            'status' => $status,
            'department_id'=>$user['department_id'],
            'team_id'=>$user['team_id'],
        ]);
    
        return redirect()->route('viewApproveMonth');
    }
    
    public function DeletetWorkMonth(request $request){
        $workmonth = Workmonth::find($request->id);
        if ($workmonth) {
            $workmonth->delete();

            return response()->json(['message' => 'Cập nhật thành công!'], 200);
        } else {
            return response()->json(['error' => 'Không tìm thấy dữ liệu'], 404);
        }
    }
    
    public function listReportMonth(request $request){
        $user = Auth::user();
        $position_id = $user->position_id;
        $department_id = $user->department_id;
        $department_id1 = $user->department_id1;
        $team_id = $user->team_id;
        //------- CÔNG VIỆC THÁNG------//
            $query = Workmonth::query()
                ->where('status', 4);
                $departments = [];
                $teams = [];
                $users = [];
        
                if (in_array($position_id, [10, 9, 8, 7, 6, 5])) {
                    $query->where('department_id', $department_id)
                        ->orWhere('department_id', $department_id1)
                        ->where('team_id', $team_id);
                    $departments = Department::whereIn('id', [$department_id, $department_id1])->get();
                    $teams = Team::where('department_id', $department_id)
                        ->orWhere('department_id', $department_id1)
                        ->get();
                    $users = User::where('department_id', $department_id)
                        ->orWhere('department_id', $department_id1)
                        ->get();
                } 
                else if ($position_id == 4) {
                    $department_ids = Department::where('trademark_id', 2)->pluck('id');
                    $query->whereIn('department_id', $department_ids);
                    $departments = Department::whereIn('id', $department_ids)->get();
                    $teams = Team::whereIn('department_id', $department_ids)->get();
                    $users = User::whereIn('department_id', $department_ids)->get();
                } 
                else if ($position_id == 3) {
                    $department_ids = Department::where('trademark_id', 1)->pluck('id');
                    $query->whereIn('department_id', $department_ids);
                    $departments = Department::whereIn('id', $department_ids)->get();
                    $teams = Team::whereIn('department_id', $department_ids)->get();
                    $users = User::whereIn('department_id', $department_ids)->get();
                } 
                else if (in_array($position_id, [2, 1])) {
                    $departments = Department::all();
                    $teams = Team::all();
                    $users = User::all();
                }
                // dd($users->toarray());
                $workmonths = $query->get();
            return view('report.reportMonth', compact('user', 'workmonths', 'departments', 'teams', 'users'));
    }
    public function listReportMonthPost(request $request){
        $user = auth::user();
        $departmentId = $request->get('departmentsId');
        $teamId = $request->get('teamId');
        $userId = $request->get('userName');
        $startDate = $request->get('startMonth');
        $endDate = $request->get('endMonth');
        $position_id = $user->position_id;
        $department_id = $user->department_id;
        $department_id1 = $user->department_id1;
        $team_id = $user->team_id;
    
        // Tạo một query builder
        $query = WorkMonth::query();
        $query->where('status', 4);
        if ($startDate && $endDate) {
            $query->whereBetween('startMonth', [$startDate, $endDate])
                ->orWhereBetween('endMonth', [$startDate, $endDate]);
        }
        // Nếu chỉ chọn department
        if ($departmentId && !$teamId && !$userId) {
            $query->where('department_id', $departmentId);
        }
    
        // Nếu chỉ chọn team
        if (!$departmentId && $teamId && !$userId) {
            $query->where('team_id', $teamId);
        }
    
        // Nếu chỉ chọn user
        if (!$departmentId && !$teamId && $userId) {
            $query->where('responsibility', $userId);
        }
    
        // Nếu chọn department và team nhưng không chọn user
        if ($departmentId && $teamId && !$userId) {
            $query->where('department_id', $departmentId)->where('team_id', $teamId);
        }
    
        // Nếu chọn team và user nhưng không chọn department
        if (!$departmentId && $teamId && $userId) {
            $query->where('team_id', $teamId)->where('responsibility', $userId);
        }
    
        // Nếu chọn department và user nhưng không chọn team
        if ($departmentId && !$teamId && $userId) {
            $query->where('department_id', $departmentId)->where('responsibility', $userId);
        }
    
        // Nếu chọn cả ba
        if ($departmentId && $teamId && $userId) {
            $query->where('department_id', $departmentId)->where('team_id', $teamId)->where('responsibility', $userId);
        }
    
        // Thực hiện truy vấn và lấy kết quả
        $workMonths = $query->get();
    
        $query = Workmonth::query()
        ->where('status', 4);
            $departments = [];
            $teams = [];
            $users = [];
        if (in_array($position_id, [10, 9, 8, 7, 6, 5])) {
            $query->where('department_id', $department_id)
                ->orWhere('department_id', $department_id1)
                ->where('team_id', $team_id);
            $departments = Department::whereIn('id', [$department_id, $department_id1])->get();
            $teams = Team::where('department_id', $department_id)
                ->orWhere('department_id', $department_id1)
                ->get();
            $users = User::where('department_id', $department_id)
                ->orWhere('department_id', $department_id1)
                ->get();
        } 
        else if ($position_id == 4) {
            $department_ids = Department::where('trademark_id', 2)->pluck('id');
            $query->whereIn('department_id', $department_ids);
            $departments = Department::whereIn('id', $department_ids)->get();
            $teams = Team::whereIn('department_id', $department_ids)->get();
            $users = User::whereIn('department_id', $department_ids)->get();
        } 
        else if ($position_id == 3) {
            $department_ids = Department::where('trademark_id', 1)->pluck('id');
            $query->whereIn('department_id', $department_ids);
            $departments = Department::whereIn('id', $department_ids)->get();
            $teams = Team::whereIn('department_id', $department_ids)->get();
            $users = User::whereIn('department_id', $department_ids)->get();
        } 
        else if (in_array($position_id, [2, 1])) {
            $departments = Department::all();
            $teams = Team::all();
            $users = User::all();
        }
        // dd($users->toarray());
        $workmonths = $query->get();

        return view('report.reportMonth', ['workMonths' => $workMonths],compact('user', 'workmonths', 'departments', 'teams', 'users'));
    }

    public function getTeams($id)
    {
        $teams = Team::where('department_id', $id)->get();
        return response()->json($teams);
    }
    
    public function getDepartmentUsers($id)
    {
        // dd($id);
        $users = User::where('department_id', $id)->orWhere('department_id1', $id)->get();
        // dD($users->toSql());
        return response()->json($users);
    }
    
    public function getTeamUsers($id)
    {
        $users = User::where('team_id', $id)->get();
        return response()->json($users);
    }

    public function ChartMonth(){     
        $user = auth()->user();
        $currentDate = Carbon::now();
    
        // Determine user's access level
        $positionId = $user->position_id;
        $departmentId = $user->department_id;
        $trademarkId = Department::find($departmentId)->trademark_id;
        $query = Workmonth::query();
    
        if ($positionId >= 5 && $positionId <= 10) {
            $query->where('department_id', $departmentId);
        } elseif ($positionId == 4 && $trademarkId == 2) {
            $departments = Department::where('trademark_id', 2)->pluck('id');
            $query->whereIn('department_id', $departments);
        } elseif ($positionId == 3 && $trademarkId == 1) {
            $departments = Department::where('trademark_id', 1)->pluck('id');
            $query->whereIn('department_id', $departments);
        }
    
        // Query data
        $workmonths = $query->select('categoryMonth', 'status', 'endMonth')
            ->get()
            ->groupBy('categoryMonth')
            ->map(function ($workmonth) use ($currentDate) {
                $startMonth = $workmonth->min('startMonth');
                $endMonth = $workmonth->max('endMonth');
                return [
                    'completed' => $workmonth->where('status', 4)->count(),
                    'pending' => $workmonth->where('status', '>=', 1)->where('status', '<=', 2)->count(),
                    'in_progress' => $workmonth->where('status', 0)->where('endMonth', '>', $currentDate)->count(),
                    'late' => $workmonth->where('status', 0)->where('endMonth', '<', $currentDate)->count(),
                    'startMonth' => $startMonth,
                    'endMonth' => $endMonth,
                ];
            });
            // dd($workmonths->toarray());
        return view('plan.ChartMonth', compact('workmonths','user'));
    }
}
