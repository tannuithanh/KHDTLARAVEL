<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Work_By_Project_Department;
use App\Models\work_lv4_project;
use Carbon\Carbon;
use App\Models\Workdaily;
use App\Models\Workweek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function dashboardGet()
    {
        $mydate = date('Y-m-d');
        $isLoggedIn = Auth::check();
        $user = Auth::user();
        $workDaily = Workdaily::select('workdaily.*')->where('date', $mydate)->where('responsibility', $user['name'])->get();
        $dueDate = Carbon::now()->addDays(2)->toDateString();

        // Truy vấn công việc sắp hết hạn
        $upcomingDueTasks = Workweek::select('workweek.*')
            ->where('responsibility', $user['name'])
            ->where('enddate', '<=', $dueDate)
            ->where('enddate', '>', $mydate)
            ->get();
            $totalTasks = count($workDaily);
           
            $currentMonth = Carbon::now()->month;

            $currentWeekInMonth = Carbon::now()->weekOfMonth;
            $startOfWeek = Carbon::now()->startOfWeek()->toDateString();
            $endOfWeek = Carbon::now()->endOfWeek()->toDateString();

            // Truy vấn công việc tuần này
            $tasksThisWeek = Workweek::select('workweek.*')
                ->where('responsibility', $user['name'])
                ->whereBetween('startdate', [$startOfWeek, $endOfWeek])
                ->whereBetween('enddate', [$startOfWeek, $endOfWeek])
                ->get();
                
        // Truy vấn tất cả dự án mà người dùng này đang tham gia
        $projects = Project::whereHas('projectDepartments.works', function ($query) use ($user) {
            $query->where('responsibility', $user->name);
        })->get();
        
        // Truy vấn tất cả công việc liên quan đến người dùng này
        $tasks = work_lv4_project::where('responsibility', $user->name)->get();
        // dd($tasks->toarray());
        return view('DashBoard', compact('user', 'isLoggedIn', 'workDaily','upcomingDueTasks','tasksThisWeek','mydate','currentWeekInMonth','startOfWeek','endOfWeek','currentMonth', 'projects', 'tasks'));
    }
}
