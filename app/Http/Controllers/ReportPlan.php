<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Team;
use App\Models\User;
use App\Mail\ReportMail;
use App\Models\Workweek;
use App\Models\Workdaily;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ReportPlan extends Controller
{
    //------ DANH SÁCH BÁO CÁO ------//
    public function listReportWeekly(){
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
           
            return view('report.reportWeekly', compact('userById', 'user', 'workWeek', 'start', 'end', 'weekNumber', 'formattedDateStart', 'formattedDateEnd', 'mydate', 'teams','month','dates'));
        }

        return view('report.reportWeekly', compact('userById', 'user', 'workWeek', 'start', 'end', 'weekNumber', 'formattedDateStart', 'formattedDateEnd', 'mydate', 'teams', 'departments','month','dates'));
    }

    //------ FORM BÁO CÁO------//
    public function formReportWeekly($id){
        $workWeek = Workweek::select('workweek.*', 'users.name')->leftjoin('users', 'users.id', '=', 'workweek.support')->where('workweek.id',$id)->first();
        // dd($workWeek->toArray());
        $user = Auth::user();
        return view('report.formReport',compact('user'))->with(compact('workWeek'));
    }

     //------ BÁO CÁO------//

     public function reportWeekly(request $request, $id){
            $workWeek = Workweek::find($id);
            //kiểm tra xem file có tải lên không
            if ($request->hasFile('file_upload')) {
                    //tiến hành upload
                $file = $request->file('file_upload');
                    //lấy cái đuôi file
                $ext = $request->file('file_upload')->extension();
                $fileName = time().'-'.'FILE.'.$ext;
                    //Tới đây nhớ dd xem nó ra tên file chưa
                // dd($fileName);
                    //Lưu file vào public
                $file->move(public_path('uploadfile'), $fileName);
                $request->merge(['file'=>$fileName]);
                $workWeek->	fileupload = $request->input('file');
            }
            //Bước này quan trọng. Làm nhớ dd để hiểu chứ khó nói
            
            $workWeek->status = 1;
            $workWeek->inadequacy = $request->input('Inadequacy');
            $workWeek->propose = $request->input('Propose');
            $workWeek->Result = $request->input('result');
            $workWeek->update();
            return redirect()->route('listReportWeekly')->with('report','Cập nhật thành công');
    }

    
     //------ Tải về------//
    public function download($fileName)
        {

            $filePath = public_path('uploadfile/'.$fileName);
            return response()->download($filePath);
        }


   
    public function listReportDaily(){
        $today = date('Y-m-d');
        $allUser = User::get();
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
           
            return view('report.reportDaily', compact('allUser','user','teams','userById','workDaily'));
        }
        return view('report.reportDaily',compact('allUser','user','departments','teams','userById','workDaily'));
        }

    public function formReportDaily($id){
        $user = Auth::user();
        $workDaily = Workdaily::find($id);
        if($workDaily->workweek_id){
        $countWorkWeek_id = Workdaily::where('workweek_id', $workDaily->workweek_id)
        ->select(DB::raw('SUM(ResultByWookWeek) as total'))
        ->first();
        return view('report.formReportDaily',compact('user','workDaily','countWorkWeek_id'));
        }
        // dd($countWorkWeek_id->toArray());
        return view('report.formReportDaily',compact('user','workDaily'));
        }

    public function reportDaily($id,request $request){
        // dd($request->toArray());
        if($request->Result == null){
            return redirect()->back()->with('message','Cập nhật thành công');
        }else{
        $workDaily = Workdaily::find($id);
        $user = Auth::user();
        $workDaily->inadequacy = $request->inadequacy;
        $workDaily->propose = $request->propose;
        $workDaily->Result = $request->Result;
        $workDaily->status = 4;
        $workDaily->update();
        }
        return redirect()->route('listReportDaily')->with('report','Cập nhật thành công');
        }

    public function SearchlistReportDaily(request $request){
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
            return view('report.reportDaily', compact('userById', 'user', 'workDaily', 'teams','today'));
        }
        // dd($workDaily->toArray());
        return view('report.reportDaily', compact('user', 'today', 'teams', 'userById'))->with(compact('start'))->with(compact('workDaily'))->with(compact('departments'));
    }
    public function SearchlistReportWeekly(request $request){
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
            return view('report.reportWeekly', compact('userById', 'user', 'workWeek', 'start', 'end', 'weekNumber', 'formattedDateStart', 'formattedDateEnd', 'mydate', 'teams','month','dates'));
        }
        
        return view('report.reportWeekly', compact('user', 'mydate', 'teams', 'userById','month','dates'))->with(compact('start'))->with(compact('workWeek'))->with(compact('end'))->with(compact('weekNumber'))->with(compact('departments'))->with(compact('formattedDateStart'))->with(compact('formattedDateEnd'));
    }

    public function sendmail(Request $request) {
        $user = Auth::user();
    
        $tableData = $request->input('tableData');
        $mailData = [
            'tableData' => $tableData,
        ];
    
        $receivers = [];
        $cc = [];
    
        $departments = [$user['department_id']];
        if(!empty($user['department_id1'])){
            $departments[] = $user['department_id1'];
        }
    
        foreach($departments as $department_id){
            $department = Department::find($department_id);
    
            // Get managers of the department
            $managers = User::select('users.*')
                ->where('department_id', $department_id)
                ->whereIn('position_id', [5, 6]) // Manager and deputy
                ->get();
    
            // Get the team of the user
            $team = Team::find($user['team_id']);
    
            if($user['position_id'] == 9 || $user['position_id'] == 10){ // Staff
                // Send to managers
                foreach($managers as $manager){
                    $receivers[] = $manager['email'];
                }
    
                // CC the team leader and sub-leader if exists
                if($team){
                    $team_leader = User::select('users.*')
                        ->where('team_id', $team['id'])
                        ->where('position_id', 7) // Team leader
                        ->first();
    
                    if($team_leader){
                        $cc[] = $team_leader['email'];
    
                        $team_sub_leader = User::select('users.*')
                            ->where('team_id', $team['id'])
                            ->where('position_id', 8) // Team sub-leader
                            ->first();
                        
                        if($team_sub_leader){
                            $cc[] = $team_sub_leader['email'];
                        }
                    }
                }
            } else if($user['position_id'] == 7 || $user['position_id'] == 8){ // Team leader or sub-leader
                foreach($managers as $manager){
                    $receivers[] = $manager['email'];
                }
            } else if($user['position_id'] == 5 || $user['position_id'] == 6){ // Department leader or deputy
                if($department['trademark_id'] == 1){
                    $receivers[] = "totanson@thaco.com.vn";
                } else if($department['trademark_id'] == 2){
                    $receivers[] = "levandoanh@thaco.com.vn";
                }
                // If the sender is the deputy, CC the manager
                if($user['position_id'] == 6){
                    foreach($managers as $manager){
                        if($manager['position_id'] == 5){
                            $cc[] = $manager['email'];
                            break;
                        }
                    }
                }
            }
        }
    
        $cc[] = $user['email'];
    
        Mail::to($receivers)
            ->cc($cc)
            ->send(new ReportMail($mailData));
    
        return response()->json(['success'=>'Gởi mail thành công rồi đó Tân.']);
    }
    
}


