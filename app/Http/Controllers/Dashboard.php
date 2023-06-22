<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Project;
use App\Models\Workweek;
use App\Models\Workdaily;
use Illuminate\Http\Request;
use App\Models\work_lv4_project;
use Illuminate\Support\Facades\Auth;
use App\Models\Work_By_Project_Department;

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

        $supportUsersWithPosition7 = User::where('position_id', 7)->get()->pluck('id')->toArray();
        $supportUsersWithPosition5Or6 = User::whereIn('position_id', [5, 6])->get()->pluck('id')->toArray();

        $count = Workdaily::where(function($query) use ($user, $supportUsersWithPosition7) {
            // Condition for status 1
            $query->where('status', 1)
                ->where(function($subQuery) use ($user) {
                    $subQuery->where('department_id', $user->department_id)
                                ->orWhere('department_id', $user->department_id1);
                })
                ->where('team_id', $user->team_id)
                ->whereIn('support', $supportUsersWithPosition7);
        })
        ->orWhere(function($query) use ($user, $supportUsersWithPosition5Or6) {
            // Condition for status 2
            $query->where('status', 2)
                ->where(function($subQuery) use ($user) {
                    $subQuery->where('department_id', $user->department_id)
                                ->orWhere('department_id', $user->department_id1);
                })
                ->whereIn('support', $supportUsersWithPosition5Or6);
        })
        ->count();
        // dd($tasks->toarray());
        return view('DashBoard', compact('user', 'isLoggedIn', 'workDaily','mydate', 'projects', 'tasks','count'));
    }
}
