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

        // Truy vấn tất cả dự án mà người dùng này đang tham gia
        $projects = Project::whereHas('projectDepartments.works', function ($query) use ($user) {
            $query->where('responsibility', $user->name);
        })->get();
        
        // Truy vấn tất cả công việc liên quan đến người dùng này
        $tasks = work_lv4_project::where('responsibility', $user->name)->get();
        // dd($tasks->toarray());
        return view('DashBoard', compact('user', 'isLoggedIn', 'workDaily','mydate', 'projects', 'tasks'));
    }
}
