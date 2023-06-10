<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Team;
use App\Models\User;
use App\Models\Workweek;
use App\Models\Workdaily;
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
           
            ->where('startdate', '>=', $start)
            ->get();
            }elseif ($user['position_id'] == 3) {
                $workWeek = Workweek::select('workweek.*')
               
                ->join('departments', 'workweek.department_id', '=', 'departments.id')
                ->join('trademark', 'departments.trademark_id', '=', 'trademark.id')
                ->where(function($query) use ($start) {
                    $query->where('startdate', '>=', $start)
                          ->orWhere('workweek.responsibility', 'Tô Tấn Sơn');
                })
                ->where('trademark.id', '=', 1)
                ->get();
                // dd($workWeek->toArray());
            }elseif ($user['position_id'] == 4) {
                $workWeek = Workweek::select('workweek.*')
               
                ->join('departments', 'workweek.department_id', '=', 'departments.id')
                ->join('trademark', 'departments.trademark_id', '=', 'trademark.id')
                ->where('startdate', '>=', $start)
                ->where('trademark.id', '=', 2)
                ->get();    
            }else{
                $workWeek = Workweek::select('workweek.*')
               
                ->join('departments', 'workweek.department_id', '=', 'departments.id')
                ->where('startdate', '>=', $start)
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
        
            ->where('startdate', '>=', $start)
            ->get();
            }elseif ($user['position_id'] == 3) {
                $workWeek = Workweek::select('workweek.*')
            
                ->join('departments', 'workweek.department_id', '=', 'departments.id')
                ->join('trademark', 'departments.trademark_id', '=', 'trademark.id')
                ->where(function($query) use ($start) {
                    $query->where('startdate', '>=', $start)
                        ->orWhere('workweek.responsibility', 'Tô Tấn Sơn');
                })
                ->where('trademark.id', '=', 1)
                ->get();
                // dd($workWeek->toArray());
            }elseif ($user['position_id'] == 4) {
                $workWeek = Workweek::select('workweek.*')
            
                ->join('departments', 'workweek.department_id', '=', 'departments.id')
                ->join('trademark', 'departments.trademark_id', '=', 'trademark.id')
                ->where('startdate', '>=', $start)
                ->where('trademark.id', '=', 2)
                ->get();    
            }else{
                $workWeek = Workweek::select('workweek.*')
            
                ->join('departments', 'workweek.department_id', '=', 'departments.id')
                ->where('startdate', '>=', $start)
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
                $workdaily->ResultByWookWeek = $percentagePerDay;
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

}
        
    


