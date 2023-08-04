<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Project;
use App\Models\Workweek;
use App\Models\Workdaily;
use App\Models\Workmonth;
use App\Models\CarBrands;
use App\Models\ProjectPro;
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
            $userName = $user->name;
            $userPosition = $user->position_id;
            $userTeamId = $user->team_id;
            $userDepartmentId = $user->department_id;
            $userDepartmentId1 = $user->department_id1;

            // Khởi tạo các truy vấn
                $dailyQuery = Workdaily::query();
                $weekQuery = Workweek::query();
                $monthQuery = Workmonth::query();

            // Truy vấn dựa trên vị trí của người dùng
                if (in_array($userPosition, [10, 9, 8])) {
                    $dailyQuery->where('responsibility', $user->name);
                    $weekQuery->where('responsibility', $user->name);
                    $monthQuery->where('responsibility', $user->name);
                } elseif ($userPosition == 7) {
                    $dailyQuery->where('team_id', $userTeamId);
                    $weekQuery->where('team_id', $userTeamId);
                    $monthQuery->where('team_id', $userTeamId);
                } elseif (in_array($userPosition, [6, 5])) {
                    $dailyQuery->whereIn('department_id', [$userDepartmentId, $userDepartmentId1]);
                    $weekQuery->whereIn('department_id', [$userDepartmentId, $userDepartmentId1]);
                    $monthQuery->whereIn('department_id', [$userDepartmentId, $userDepartmentId1]);
                } elseif ($userPosition == 4) {
                    $dailyQuery->whereHas('department', function ($query) {
                        $query->where('trademark_id', 2);
                    });
                    $weekQuery->whereHas('department', function ($query) {
                        $query->where('trademark_id', 2);
                    });
                    $monthQuery->whereHas('department', function ($query) {
                        $query->where('trademark_id', 2);
                    });
                } elseif ($userPosition == 3) {
                    $dailyQuery->whereHas('department', function ($query) {
                        $query->where('trademark_id', 1);
                    });
                    $weekQuery->whereHas('department', function ($query) {
                        $query->where('trademark_id', 1);
                    });
                    $monthQuery->whereHas('department', function ($query) {
                        $query->where('trademark_id', 1);
                    });
                }

            // Tiếp tục với mã nhưng thay vào đó hãy sử dụng  $dailyQuery, $weekQuery, và  $monthQuery
                $unreportedTasks = clone $dailyQuery;
                $unreportedTasks = $unreportedTasks->where('status', 0)->where('date', '<', $mydate)->count();

                $ongoingTasks = clone $dailyQuery;
                $ongoingTasks = $ongoingTasks->where('status', 0)->where('date', $mydate)->count();

                $completedTasks = clone $dailyQuery;
                $completedTasks = $completedTasks->where('status', 4)->count();

                $noTasks = ($unreportedTasks == 0 && $ongoingTasks == 0 && $completedTasks == 0) ? 1 : 0;

                $taskCounts = [
                    'unreported' => $unreportedTasks,
                    'ongoing' => $ongoingTasks,
                    'completed' => $completedTasks,
                    'none' => $noTasks,
                ];
                
                $now = now()->startOfDay();
                $unreportedWeekTasks = clone $weekQuery;
                $unreportedWeekTasks = $unreportedWeekTasks->where('status', 0)->whereDate('enddate', '<', $now)->count();

                $ongoingWeekTasks = clone $weekQuery;
                $ongoingWeekTasks = $ongoingWeekTasks->where('status', 0)->whereDate('startdate', '<=', $now)->whereDate('enddate', '>=', $now)->count();

                $completedWeekTasks = clone $weekQuery;
                $completedWeekTasks = $completedWeekTasks->where('status', 4)->count();
                $noWeekTasks = ($unreportedWeekTasks == 0 && $ongoingWeekTasks == 0 && $completedWeekTasks == 0) ? 1 : 0;
                
                $weekTaskCounts = [
                    'unreported' => $unreportedWeekTasks,
                    'ongoing' => $ongoingWeekTasks,
                    'completed' => $completedWeekTasks,
                    'none' => $noWeekTasks,
                ];
                $unreportedMonthTasks = clone $monthQuery;
                $unreportedMonthTasks = $unreportedMonthTasks->where('status', 0)->whereDate('endMonth', '<', $now)->count();

                $ongoingMonthTasks = clone $monthQuery;
                $ongoingMonthTasks = $ongoingMonthTasks->where('status', 0)->whereDate('startMonth', '<=', $now)->whereDate('endMonth', '>=', $now)->count();

                $completedMonthTasks = clone $monthQuery;
                $completedMonthTasks = $completedMonthTasks->where('status', 4)->count();
                $noMonthTasks = ($unreportedMonthTasks == 0 && $ongoingMonthTasks == 0 && $completedMonthTasks == 0) ? 1 : 0;
                
                $monthTaskCounts = [
                    'unreported' => $unreportedMonthTasks,
                    'ongoing' => $ongoingMonthTasks,
                    'completed' => $completedMonthTasks,
                    'none' => $noMonthTasks,
                ];
            //PROJECT CAR
                $carBrands = CarBrands::withCount('projects')->get();

                $chartData = $carBrands->map(function ($carBrand) {
                    return [$carBrand->name, $carBrand->projects_count];
                })->toArray();
            //PROJECT PRO
                $projects = ProjectPro::all(); // Lấy tất cả các dự án
            //MODEL NOTIFICATION
                $overdueDailyTasks = Workdaily::where('date', '<', $now)
                    ->where('status', 0)
                    ->where('responsibility', $userName)
                    ->orderBy('date', 'desc')
                    ->get();

                $currentDailyTasks = Workdaily::where('date', $now)
                    ->where('status', 0)
                    ->where('responsibility', $userName)
                    ->get();

                $doneDailyTasks = Workdaily::where('date', $now)
                    ->where('status', 4)
                    ->where('responsibility', $userName)
                    ->get();

                $weekStartDate = Carbon::now()->startOfWeek();
                $weekEndDate = Carbon::now()->endOfWeek();
                $currentWeekTasks = Workweek::whereBetween('startdate', [$weekStartDate, $weekEndDate])
                    ->whereBetween('enddate', [$weekStartDate, $weekEndDate])
                    ->where('responsibility', $userName)
                    ->get();

                $doneWeekTasks = $currentWeekTasks->where('status', 4);

                $pendingWeekTasks = $currentWeekTasks->where('status', 0);

                $overdueWeekTasks = Workweek::where('enddate', '<', $weekStartDate)
                    ->where('status', 0)
                    ->where('responsibility', $userName)
                    ->orderBy('enddate', 'desc')
                    ->get();

                $overdueMonthlyTasks = Workmonth::where('endMonth', '<', $now)
                    ->where('status', 0)
                    ->where('responsibility', $userName)
                    ->get();

                $activeMonthlyTasks = Workmonth::where('startMonth', '<=', $now)
                    ->where('endMonth', '>=', $now)
                    ->where('status', 0)
                    ->where('responsibility', $userName)
                    ->get();

                $doneMonthlyTasks = Workmonth::where('startMonth', '<=', $now)
                    ->where('endMonth', '>=', $now)
                    ->where('status', 4)
                    ->where('responsibility', $userName)
                    ->get();
                // dd($overdueDailyTasks->toarray());
            return view(
                        'DashBoard', 
                        ['projects' => $projects], 
                        compact(
                            'user', 
                            'isLoggedIn', 
                            'taskCounts', 
                            'weekTaskCounts', 
                            'monthTaskCounts', 
                            'carBrands',
                            'chartData',
                            'overdueDailyTasks',
                            'currentDailyTasks',
                            'doneDailyTasks',
                            'currentWeekTasks',
                            'doneWeekTasks',
                            'pendingWeekTasks',
                            'overdueWeekTasks',
                            'overdueMonthlyTasks',
                            'activeMonthlyTasks',
                            'doneMonthlyTasks'
                        )
                    );
                }

}
