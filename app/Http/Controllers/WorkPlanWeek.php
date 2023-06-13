<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Team;
use App\Models\User;
use App\Models\Workdaily;
use App\Models\Workweek;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class WorkPlanWeek extends Controller
{



    //--------------- TÌm kiếm công việc ----------------------///


    public function searchListWork(request $request){
        // dd($request->toArray());
        $mydate = date('Y-m-d');
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

        if ($alldata['Day']) {
            $date = Carbon::parse($alldata['Day']);
            $weekNumber = $date->weekOfMonth;
            // dd($weekNumber);
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
        };
        if($user['position_id'] == 1 || $user['position_id'] == 2 || $user['position_id'] == 3 || $user['position_id'] == 4){
            if($alldata['Day'] && $alldata['teamId']== 0 && $alldata['departmentsId']== 0 && $alldata['userName']==null){
                if ($user['position_id'] == 1 || $user['position_id'] == 2) {
                    $workWeek = Workweek::select('workweek.*')
                   
                    ->where('workweek.startdate', '>=', $start)
                    ->where('workweek.enddate', '<=', $end)->get();
                }elseif($user['position_id'] == 3 ){
                    $workWeek = Workweek::select('workweek.*')
                   
                    ->join('departments', 'departments.id', '=', 'workweek.department_id')
                    ->join('trademark', 'trademark.id', '=', 'departments.trademark_id')
                    ->where('workweek.startdate', '>=', $start)
                    ->where('workweek.enddate', '<=', $end)
                    ->where('trademark_id', 1)->get();
                }else{
                    $workWeek = Workweek::select('workweek.*')
                   
                    ->join('departments', 'departments.id', '=', 'workweek.department_id')
                    ->join('trademark', 'trademark.id', '=', 'departments.trademark_id')
                    ->where('workweek.startdate', '>=', $start)
                    ->where('workweek.enddate', '<=', $end)
                    ->where('trademark_id', 2)->get();
                } 
            }elseif($alldata['Day'] && $alldata['teamId']== 0 && $alldata['departmentsId']!= 0 && $alldata['userName']==null){
                $workWeek = Workweek::select('workweek.*')
               
                ->where('workweek.startdate', '>=', $start)
                ->where('workweek.enddate', '<=', $end)
                ->where('workweek.department_id', $alldata['departmentsId'])
                ->get();
            }elseif($alldata['Day'] && $alldata['teamId']!= 0 && $alldata['departmentsId']!= 0 && $alldata['userName']==null){
                $workWeek = Workweek::select('workweek.*')
               
                ->where('workweek.startdate', '>=', $start)
                ->where('workweek.enddate', '<=', $end)
                ->where('workweek.department_id', $alldata['departmentsId'])
                ->where('workweek.team_id', $alldata['teamId'])
                ->get();
            }elseif($alldata['Day'] && $alldata['teamId']!= 0 && $alldata['departmentsId']==0 && $alldata['userName']==null){
                $workWeek = Workweek::select('workweek.*')
               
                ->where('workweek.startdate', '>=', $start)
                ->where('workweek.enddate', '<=', $end)
                ->where('workweek.team_id', $alldata['teamId'])
                ->get();
            }elseif($alldata['Day'] && $alldata['teamId']== 0 && $alldata['departmentsId']==0 && $alldata['userName']!=null ){
                $workWeek = Workweek::select('workweek.*')
               
                ->where('workweek.startdate', '>=', $start)
                ->where('workweek.enddate', '<=', $end)
                ->where('workweek.responsibility', $alldata['userName'])
                ->get();
            }elseif($alldata['Day'] && $alldata['teamId']== 0 && $alldata['departmentsId']!=0 && $alldata['userName']!=null ){
                $workWeek = Workweek::select('workweek.*')
               
                ->where('workweek.startdate', '>=', $start)
                ->where('workweek.enddate', '<=', $end)
                ->where('workweek.department_id', $alldata['departmentsId'])
                ->where('workweek.responsibility', $alldata['userName'])
                ->get();
            }elseif($alldata['Day'] && $alldata['teamId']!= 0 && $alldata['departmentsId']!=0 && $alldata['userName']!=null ){
                $workWeek = Workweek::select('workweek.*')
               
                ->where('workweek.startdate', '>=', $start)
                ->where('workweek.enddate', '<=', $end)
                ->where('workweek.department_id', $alldata['departmentsId'])
                ->where('workweek.team_id', $alldata['teamId'])
                ->where('workweek.responsibility', $alldata['userName'])
                ->get();
            }elseif($alldata['Day'] && $alldata['teamId']!= 0 && $alldata['departmentsId']==0 && $alldata['userName']!=null ){
                $workWeek = Workweek::select('workweek.*')
               
                ->where('workweek.startdate', '>=', $start)
                ->where('workweek.enddate', '<=', $end)
                ->where('workweek.department_id', $alldata['departmentsId'])
                ->where('workweek.team_id', $alldata['teamId'])
                ->where('workweek.responsibility', $alldata['userName'])
                ->get();
            }
        }else{
            if($alldata['Day'] && $alldata['teamId']== 0 && $alldata['userName']==null){
                $workWeek = Workweek::select('workweek.*')
               
                ->where('workweek.startdate', '>=', $start)
                ->where('workweek.enddate', '<=', $end)
                ->where('workweek.department_id', $user['department_id'])
                ->get();
            }elseif($alldata['Day'] && $alldata['teamId']!= 0 && $alldata['userName']==null){
                $workWeek = Workweek::select('workweek.*')
               
                ->where('workweek.startdate', '>=', $start)
                ->where('workweek.enddate', '<=', $end)
                ->where('workweek.department_id', $user['department_id'])
                ->where('workweek.team_id', $alldata['teamId'])
                ->get();
            }elseif($alldata['Day'] && $alldata['teamId']== 0 && $alldata['userName']!=null){
                $workWeek = Workweek::select('workweek.*')
               
                ->where('workweek.startdate', '>=', $start)
                ->where('workweek.enddate', '<=', $end)
                ->where('workweek.department_id', $user['department_id'])
                ->where('workweek.responsibility', $alldata['userName'])
                ->get();
            }elseif($alldata['Day'] && $alldata['teamId']!= 0 && $alldata['userName']!=null){
                $workWeek = Workweek::select('workweek.*')
               
                ->where('workweek.startdate', '>=', $start)
                ->where('workweek.enddate', '<=', $end)
                ->where('workweek.department_id', $user['department_id'])
                ->where('workweek.team_id', $alldata['teamId'])
                ->where('workweek.responsibility', $alldata['userName'])
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
            return view('plan.listPlanWeek', compact('userById', 'user', 'workWeek', 'start', 'end', 'weekNumber', 'formattedDateStart', 'formattedDateEnd', 'mydate', 'teams','month','dates'));
        }
        
        return view('plan.listPlanWeek', compact('user', 'mydate', 'teams', 'userById','month','dates'))->with(compact('start'))->with(compact('workWeek'))->with(compact('end'))->with(compact('weekNumber'))->with(compact('departments'))->with(compact('formattedDateStart'))->with(compact('formattedDateEnd'));
    }

    //--------------- DANH SÁCH CÔNG VIỆC TUẦN ----------------------///  
    public function viewListWorkWeek()
    {
        
        $user = User::select('users.*', 'departments.name as department_name', 'teams.name as team_name')
        ->join('departments', 'departments.id', '=', 'users.department_id')
        ->leftjoin('teams', 'teams.id', '=', 'users.team_id')
        ->where('users.id', Auth::user()->id)
        ->first();
        // dD($user->toarray());
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
           
            return view('plan.listPlanWeek', compact('userById', 'user', 'workWeek', 'start', 'end', 'weekNumber', 'formattedDateStart', 'formattedDateEnd', 'mydate', 'teams','month','dates'));
        }

        return view('plan.listPlanWeek', compact('userById', 'user', 'workWeek', 'start', 'end', 'weekNumber', 'formattedDateStart', 'formattedDateEnd', 'mydate', 'teams', 'departments','month','dates'));
    }

    //----------------------SEACH BY AJAX ----------------------//
    public function getDepartments(Request $request)
    {
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
     //----------------------UPDATE REASON AJAX ----------------------//
     public function updateReason(Request $request){
        // dd($request['itemId']);
        $user = Auth::user();
        $workWeekById = Workweek::find($request['itemId']);
        $workWeekById->reason = $request->input('lydo');
        $workWeekById->idreason = 1;
        $workWeekById->update();
     }
    //----------------------ĐỒNG Ý LÝ DO  AJAX ----------------------//
     public function acceptReason(Request $request){
        $user = Auth::user();
        $workWeekById = Workweek::find($request['reason_id']);
        $workWeekById->idreason = 2;
        $workWeekById->update();
        return response()->json($workWeekById->idreason);
     }

    //----------------------TỪ CHỐI LÝ DO  AJAX ----------------------//
    public function denyReason(Request $request){
        $user = Auth::user();
        $workWeekById = Workweek::find($request['reason_id']);
        $workWeekById->idreason = 0;
        $workWeekById->reason = null;
        $workWeekById->update();
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
    //--------------- Tạo công việc tuần ----------------------///  



    //--------------- FORM----------------------///  

    public function showWeekdays(Request $request)
    {
        $allUser = User::get();
        $user = Auth::user();

        $weekStartDate = Carbon::parse($request->week)->startOfWeek();
        $weekEndDate = Carbon::parse($request->week)->endOfWeek();
        $weekNumber = Carbon::parse($request->week)->weekOfMonth;

        $month = Carbon::parse($request->week)->month;

        $weekdays = [];

        for ($day = $weekStartDate; $day->lte($weekEndDate); $day->addDay()) {
            $weekdays[] = $day->format('Y-m-d');
        }
        return redirect()->route('creatWorkWeek.get', ['weekdays' => $weekdays])->with('weekdays', $weekdays)->with('user', $user)->with('weekNumber', $weekNumber)->with('month', $month);
    }


    public function chooseDate()
    {
        $user = Auth::user();
        return view('plan.creat.chooseDate', compact('user'));
    }
    public function creatWorkWeek(Request $request)
    {
        if (empty($request->all())) {
            return redirect()->route('chooseDate.get')->with('faild', 'Không được');
        }
        $allUser = User::get();
        $user = Auth::user();
        return view('plan.creat.creatWorkWeek', compact('user', 'allUser'));
    }


    //--------------- Lấy thông tin từ FORM (POST) CÔNG VIỆC TUẦN ----------------------/// 
    public function insertWorkWeek(request $request)
    {
  
        $user = Auth::user();
        $status = 1; // default status
    
        if (empty($user['team_id']) || $user['position_id']==7) {
            $status = 2; // set status to 2 if team_id is not set
        }
    
        if (in_array($user['position_id'], [1, 2, 3, 4, 5, 6])) {
            $status = 0; // set status to 0 if position is one of the specified values
        }
        $alldata = $request->all();
        if(isset($alldata['support'])){
            $supportJson = json_encode($alldata['support'], true);
            $supportArray =  json_decode($supportJson, true);
            $supportString = implode("\n", $supportArray);
        }else{
            $supportString = null;
        }
        // dd($supportString);
        if (!isset($alldata['workDescription_mon'])) {
            $alldata['workDescription_mon'] = null;
        }
        if (!isset($alldata['workDescription_tue'])) {
            $alldata['workDescription_tue'] = null;
        }
        if (!isset($alldata['workDescription_wed'])) {
            $alldata['workDescription_wed'] = null;
        }
        if (!isset($alldata['workDescription_thu'])) {
            $alldata['workDescription_thu'] = null;
        }
        if (!isset($alldata['workDescription_fri'])) {
            $alldata['workDescription_fri'] = null;
        }
        if (!isset($alldata['workDescription_sat'])) {
            $alldata['workDescription_sat'] = null;
        }
        if (!isset($alldata['workDescription_sun'])) {
            $alldata['workDescription_sun'] = null;
        }
        // dd($alldata['workDescription_mon']);
        $mytime = date('Y-m-d H:i:s');
        if($alldata['enddate']>$alldata['startdate']){
        Workweek::insertGetId(
            [
                'categoryWeek' => $alldata['categoryWeek'],
                'describeWeek' => $alldata['describeWeek'],
                'support' => isset($supportString) ? $supportString : null,
                'responsibility' => $user['name'],
                'startdate' => $alldata['startdate'],
                'enddate' => $alldata['enddate'],
                'note' => $alldata['note'],
                'department_id' => $user['department_id'],
                'team_id' => $user['team_id'],
                'monday' => $alldata['workDescription_mon'],
                'tuesday' => $alldata['workDescription_tue'],
                'wednesday'=> $alldata['workDescription_wed'],
                'thursday'=> $alldata['workDescription_thu'],
                'friday'=> $alldata['workDescription_fri'],
                'saturday'=> $alldata['workDescription_sat'],
                'sunday'=> $alldata['workDescription_sun'],
                'status'=> $status,
                'created_at' => $mytime,
                'updated_at' => $mytime
            ],
        );
        }else{
            return redirect()->route('chooseDate.get')->with('failder', 'Thêm kế hoạch thất bại');     
        }

       
        return redirect()->route('viewApproveWeek')->with('successful', 'Thêm kế hoạch thành công');
    }
    //--------------- XÓA CÔNG VIỆC TUẦN----------------------/// 
    public function deleteWorkWeek(request $request)
    {
        $deleteWorkWeek = Workweek::find($request->id);
        Workdaily::where('workweek_id',$request->id)->delete();
        $deleteWorkWeek->delete();
        return response()->json(['message' => 'Cập nhật thành công!'], 200);
    }

    //--------------- SỬA CÔNG VIỆC TUẦN----------------------/// 
    public function editWorkWeek($id)
    {
        $allUser = User::get();
        $user = Auth::user();

        $workWeekById = Workweek::find($id);

        $weekStartDate = Carbon::parse($workWeekById->startdate)->startOfWeek();
        $weekEndDate = Carbon::parse($workWeekById->startdate)->endOfWeek();
        $weekNumber = Carbon::parse($workWeekById->startdate)->weekOfMonth;

        $month = Carbon::parse($workWeekById->startdate)->month;

        $weekdays = [];

        for ($day = $weekStartDate; $day->lte($weekEndDate); $day->addDay()) {
            $weekdays[] = $day->format('Y-m-d');
        }

        return view('plan.creat.editWorkWeek', compact('workWeekById'))->with(compact('user'))->with(compact('allUser'))->with(compact('weekdays'))->with(compact('weekNumber'))->with(compact('month'));
    }

    public function updateWorkWeek(Request $request, $id)
    {
        $user = Auth::user();
        $status = 1; // default status
    
        if (empty($user['team_id']) || $user['position_id']==7) {
            $status = 2; // set status to 2 if team_id is not set
        }
    
        if (in_array($user['position_id'], [1, 2, 3, 4, 5, 6])) {
            $status = 0; // set status to 0 if position is one of the specified values
        }
        if(isset($request['support'])){
            // If $request['support'] is a string, decode it to an array
            if (is_string($request['support'])) {
                $supportArray = json_decode($request['support'], true);
            }
            // If $request['support'] is already an array, use it as is
            elseif (is_array($request['support'])) {
                $supportArray = $request['support'];
            }
            // If $request['support'] is neither a string nor an array, set $supportArray to null
            else {
                $supportArray = null;
            }
        
            // If $supportArray is an array, implode it to a string
            if (is_array($supportArray)) {
                $supportString = implode("\n", $supportArray);
            }
            // If $supportArray is not an array, set $supportString to null
            else {
                $supportString = null;
            }
        } else {
            $supportString = null;
        }
        // dd($supportString);        
        
        if (!isset($request['workDescription_mon'])) {
            $request['workDescription_mon'] = null;
        }
        if (!isset($request['workDescription_tue'])) {
            $request['workDescription_tue'] = null;
        }
        if (!isset($request['workDescription_wed'])) {
            $request['workDescription_wed'] = null;
        }
        if (!isset($request['workDescription_thu'])) {
            $request['workDescription_thu'] = null;
        }
        if (!isset($request['workDescription_fri'])) {
            $request['workDescription_fri'] = null;
        }
        if (!isset($request['workDescription_sat'])) {
            $request['workDescription_sat'] = null;
        }
        if (!isset($request['workDescription_sun'])) {
            $request['workDescription_sun'] = null;
        }
        $mytime = date('Y-m-d H:i:s');
        $workWeek = Workweek::find($id);
        $workWeek->categoryWeek = $request->input('categoryWeek');
        $workWeek->describeWeek = $request->input('describeWeek');
        $workWeek->startdate = $request->input('startdate');
        $workWeek->enddate = $request->input('enddate');
        $workWeek->support = $workWeek->support = isset($supportString) ? $supportString : null;
        $workWeek->status = $status;
        $workWeek->monday = $request->input('workDescription_mon');
        $workWeek->tuesday = $request->input('workDescription_tue');
        $workWeek->wednesday = $request->input('workDescription_wed');
        $workWeek->thursday = $request->input('workDescription_thu');
        $workWeek->friday = $request->input('workDescription_fri');
        $workWeek->saturday = $request->input('workDescription_sat');
        $workWeek->sunday = $request->input('workDescription_sun');
        $workWeek->updated_at = $mytime;
        $workWeek->update();
        return redirect()->route('viewApproveWeek')->with('status', 'Cập nhật thành công')->with('hack', $id);
    }
    //-------------Cập nhật công việc từ dự án---------------------//
    public function updateWorkWeekGet($id){
        $allUser = User::get();
        $user = Auth::user();

        $workWeekById = Workweek::find($id);

        $weekStartDate = Carbon::parse($workWeekById->startdate)->startOfWeek();
        $weekEndDate = Carbon::parse($workWeekById->startdate)->endOfWeek();
        $weekNumber = Carbon::parse($workWeekById->startdate)->weekOfMonth;

        $month = Carbon::parse($workWeekById->startdate)->month;

        $weekdays = [];

        for ($day = $weekStartDate; $day->lte($weekEndDate); $day->addDay()) {
            $weekdays[] = $day->format('Y-m-d');
        }

        return view('plan.creat.updateWorkWeek', compact('workWeekById'))->with(compact('user'))->with(compact('allUser'))->with(compact('weekdays'))->with(compact('weekNumber'))->with(compact('month'));
    }
    public function updateWorkWeekPost(Request $request, $id){
        $user = Auth::user();
        $status = 1; // default status
    
        if (empty($user['team_id']) || $user['position_id']==7) {
            $status = 2; // set status to 2 if team_id is not set
        }
    
        if (in_array($user['position_id'], [1, 2, 3, 4, 5, 6])) {
            $status = 0; // set status to 0 if position is one of the specified values
        }
        if(isset($request['support'])){
            // If $request['support'] is a string, decode it to an array
            if (is_string($request['support'])) {
                $supportArray = json_decode($request['support'], true);
            }
            // If $request['support'] is already an array, use it as is
            elseif (is_array($request['support'])) {
                $supportArray = $request['support'];
            }
            // If $request['support'] is neither a string nor an array, set $supportArray to null
            else {
                $supportArray = null;
            }
        
            // If $supportArray is an array, implode it to a string
            if (is_array($supportArray)) {
                $supportString = implode("\n", $supportArray);
            }
            // If $supportArray is not an array, set $supportString to null
            else {
                $supportString = null;
            }
        } else {
            $supportString = null;
        }
        if (!isset($request['workDescription_mon'])) {
            $request['workDescription_mon'] = null;
        }
        if (!isset($request['workDescription_tue'])) {
            $request['workDescription_tue'] = null;
        }
        if (!isset($request['workDescription_wed'])) {
            $request['workDescription_wed'] = null;
        }
        if (!isset($request['workDescription_thu'])) {
            $request['workDescription_thu'] = null;
        }
        if (!isset($request['workDescription_fri'])) {
            $request['workDescription_fri'] = null;
        }
        if (!isset($request['workDescription_sat'])) {
            $request['workDescription_sat'] = null;
        }
        if (!isset($request['workDescription_sun'])) {
            $request['workDescription_sun'] = null;
        }
        $mytime = date('Y-m-d H:i:s');
        $workWeek = Workweek::find($id);
        $workWeek->categoryWeek = $request->input('categoryWeek');
        $workWeek->describeWeek = $request->input('describeWeek');
        $workWeek->startdate = $request->input('startdate');
        $workWeek->enddate = $request->input('enddate');
        $workWeek->support = $workWeek->support = isset($supportString) ? $supportString : null;
        $workWeek->monday = $request->input('workDescription_mon');
        $workWeek->tuesday = $request->input('workDescription_tue');
        $workWeek->wednesday = $request->input('workDescription_wed');
        $workWeek->thursday = $request->input('workDescription_thu');
        $workWeek->friday = $request->input('workDescription_fri');
        $workWeek->saturday = $request->input('workDescription_sat');
        $workWeek->sunday = $request->input('workDescription_sun');
        $workWeek->updated_at = $mytime;
        $workWeek->status = $status;
        $workWeek->update();
        return redirect()->route('viewApproveWeek')->with('status', 'Cập nhật thành công')->with('hack', $id);
    }
}
