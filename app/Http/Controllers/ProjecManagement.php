<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Team;
use App\Models\User;
use App\Models\Project;
use App\Models\Workweek;
use App\Models\CarBrands;
use App\Models\Workdaily;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\CarBrandsChild;
use Illuminate\Support\Carbon;
use App\Models\work_lv4_project;
use App\Models\ProjectDepartment;
use Illuminate\Support\Facades\DB;
use App\Exports\DelayedWorksExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Work_By_Project_Department;


class ProjecManagement extends Controller
{

//--------------Danh sách thương hiệu---------------//
    public function listCarBrands(){
        $today = date('Y-m-d');
        $user = Auth::user();

        $CarBrandsChild = DB::table('car_brands_child')
            ->leftJoin('project', 'car_brands_child.id', '=', 'project.car_brands_child_id')
            ->select(
                'car_brands_child.*',
                DB::raw('COUNT(project.id) as project_count'),
                DB::raw('SUM(CASE WHEN project.status = 0 THEN 1 ELSE 0 END) as ongoing_project'),
                DB::raw('SUM(CASE WHEN project.status = 1 THEN 1 ELSE 0 END) as completed_project')
            )
            ->groupBy(DB::raw('car_brands_child.id, car_brands_child.name, car_brands_child.car_brands_id, car_brands_child.created_at, car_brands_child.updated_at'))
            ->get();

        $CarBrands = DB::table('car_brands')
            ->leftJoin('project', function ($join) {
                $join->on('car_brands.id', '=', 'project.car_brands_id')
                    ->whereNull('project.car_brands_child_id');
            })
            ->select(
                'car_brands.*',
                DB::raw('COUNT(project.id) as project_count'),
                DB::raw('SUM(CASE WHEN project.status = 0 THEN 1 ELSE 0 END) as ongoing_project'),
                DB::raw('SUM(CASE WHEN project.status = 1 THEN 1 ELSE 0 END) as completed_project')
            )
            ->groupBy(DB::raw('car_brands.id, car_brands.name,car_brands.created_at,car_brands.updated_at'))
            ->get();

        $totalProjects = 0;
        $totalOngoingProjects = 0;
        $totalCompletedProjects = 0;

        foreach ($CarBrands as $carBrand) {
            $carBrand->childProjects = $CarBrandsChild->where('car_brands_id', $carBrand->id)->values();
            $carBrand->project_count += $carBrand->childProjects->sum('project_count');
            $carBrand->ongoing_project += $carBrand->childProjects->sum('ongoing_project');
            $carBrand->completed_project += $carBrand->childProjects->sum('completed_project');

            $totalProjects += $carBrand->project_count;
            $totalOngoingProjects += $carBrand->ongoing_project;
            $totalCompletedProjects += $carBrand->completed_project;
        }

        return view('Project management.listCarBrands', compact('user', 'CarBrands', 'CarBrandsChild', 'totalProjects', 'totalOngoingProjects', 'totalCompletedProjects'));
    }

//--------------Danh sách dự án khi chọn thương hiệu---------------//
    public function listProjectManagement($id){
        // dd()
        $today = date('Y-m-d');
        $CarBrands = CarBrands::find($id);
        $user = Auth::user();
        $project = Project::with('projectDepartments')
            ->select('project.*')
            ->where('car_brands_id', $id)
            ->get();
        // dd($project->toArray());
        return view('Project management.projectManagerment', compact('user', 'project', 'CarBrands', 'id', 'today'));
    }
//--------------Danh sách dự án khi chọn thương hiệu (CHILD)---------------//
        public function listProjectManagementChild($car_brands_id, $car_brands_child_id){
            $today = date('Y-m-d');
            $user = Auth::user();
            $CarBrandsChild = CarBrandsChild::find($car_brands_child_id);
          
            $CarBrands = CarBrands::select('car_brands.*')->where('id',$CarBrandsChild->car_brands_id)->first();
           
            $project = Project::with('projectDepartments')
                ->select('project.*')
                ->where('car_brands_id', $CarBrands->id)
                ->where('car_brands_child_id', $CarBrandsChild->id)
                ->get();
            // dd($project->toArray());
            return view('Project management.projectManagermentChild', compact('user', 'project', 'CarBrands', 'car_brands_id', 'today','CarBrandsChild','car_brands_child_id'));
        }
//--------------FORM tạo dự án cha ( GET )---------------//
    public function formCreatProject($id, $car_brands_child_id = null) {
        $departments = Department::get();
        $user = Auth::user();

        return view('Project management.Creat Project.formCreat', compact('user', 'departments'));
    }


//--------------FORM tạo dự án cha ( POST )---------------//
    public function insertCreatProject($id, Request $request, $car_brands_child_id = null) {

        $end_date = DateTime::createFromFormat('d/m/Y', $request['enddate']); // Chuyển chuỗi thành đối tượng ngày
        // dd($today,$request['end_date']);
        $user = Auth::user();

        $today = DateTime::createFromFormat('d/m/Y', date('d/m/Y'));
        $end_date = DateTime::createFromFormat('d/m/Y', $request['enddate']);

        if ($end_date < $today) {
            return back()->with('no', '...');
        }
        if($request['departments']==Null){
            return back()->with('nono','...');
        }
    
        $date = Carbon::createFromFormat('d/m/Y', $request['startdate']);
        $date1 = Carbon::createFromFormat('d/m/Y', $request['enddate']);
        $newDate = $date->format('Y-m-d');
        $newDate1 = $date1->format('Y-m-d');
        
    
        $project = Project::create([
            'name_project' => $request['name_project'],
            'describe_project' => $request['describe_project'],
            'name_create'=> $user['name'],
            'start_date' => $newDate,
            'end_date' => $newDate1,
            'car_brands_id' => $id,
            'car_brands_child_id' => $car_brands_child_id,
        ]);

        $idProject = $project->id;
        $count = count($request['departments']);

        for ($i = 0; $i < $count; $i++) {
            ProjectDepartment::create([
                'project_id' => $idProject,
                'department_id' => $request['departments'][$i],
                'startdate' => $request['start_date'][$i],
                'enddate' => $request['end_date'][$i],
                'name' => $request['task_name'][$i],
            ]);
        }
        
        
        return redirect()->route('listProjectManagerment', ['id' => $id, 'car_brands_child_id' => $car_brands_child_id])->with('success', 'Tạo dự án Thành công');
        
    }

//--------------XÓA DỰ ÁN CHA JAVASCRIPT---------------//
    public function deleteProject($id) {
        $deleteProject = Project::find($id);
        
        if ($deleteProject) {
            $deleteProject->delete();
            $abc = ProjectDepartment::where('project_id', $id)->first();
            
            if ($abc) {
                $abc->delete();
                Work_By_Project_Department::where('project_department_id', $abc->id)->delete();
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Xóa kế hoạch thành công'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Có lỗi xảy ra khi xóa dự án.'
        ]);
    }
//--------------CẬP NHẬT DỰ ÁN CHA JAVASCRIPT---------------//
    public function updateStatus(Request $request){
        $project = Project::find($request->id);
        if ($project) {
            $project->status = 1; // Cập nhật trạng thái dự án thành hoàn thành
            $project->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Dự án đã được cập nhật thành công'
            ]);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Có lỗi xảy ra khi cập nhật dự án.'
        ]);
    }

//--------------DANH SÁCH DỰ ÁN TRỌNG TÂM ( TRƯỞNG PHÒNG )---------------//
    public function ProjectConnectView($id){
        // $userAll = User::all();
        $departments = Department::all();
        $projectJson = Project::with(['projectDepartments' => function ($query) {
            $query->whereNotNull('name');
        }])->findOrFail($id);
        // dd($projectJson->toArray());
        $car_brands = CarBrands::select('car_brands.*')->where('id',$projectJson->car_brands_id)->first();
        // dd($car_brands->toarray());
        $workByProjectDepartments = Work_By_Project_Department::all();
        $today = date('Y-m-d');
        $user = Auth::user();
        $project = Project::find($id);
        // dd($project->toarray());
        $project_manager = ProjectDepartment::where('project_id', $project->id)->pluck('department_id')->toArray();
        // dd($projectJson->toarray());
        $project_department = ProjectDepartment::select('project_department.*', 'project_department.department_id as idphongban', 'project.name_project as tenduan', 'departments.name as tenphongban')
            ->join('project', 'project.id', '=', 'project_department.project_id')
            ->join('departments', 'departments.id', '=', 'project_department.department_id')
            ->where('project_id', $id)
            ->whereNotNull('project_department.name') // Thêm điều kiện này để lọc ra những hàng có cột `name` không bằng null
            ->get();
            // dd($project_department->toArray());
            $departmentIds = $project_department->pluck('department_id')->toArray();
            $projectLv1Departments = ProjectDepartment::where('project_id', $project->id)->get();
            // dd($projectLv1Departments->toArray());

        // Lấy danh sách department_id từ $projectLv1Departments
        $departmentIds = $projectLv1Departments->pluck('department_id')->unique();
        
        $departmentNames = Department::whereIn('id', $departmentIds)->pluck('name', 'id');
        // dd($departmentNames->toarray());
        // Lấy danh sách người dùng thuộc các phòng ban trong $departmentIds
        $userAll = User::whereIn('department_id', $departmentIds)->get();
        $userAllByDepartment = [];
        foreach ($departmentIds as $departmentId) {
            $usersInDepartment = User::where('department_id', $departmentId)->get();
            $userAllByDepartment[$departmentId] = $usersInDepartment;
        }
        // dd($userAllByDepartment);
        $sorted_project_department = $project_department->sortBy('tenduan');
        $project_name_counts = [];
        foreach ($sorted_project_department as $value) {
            if (isset($project_name_counts[$value->tenduan])) {
                $project_name_counts[$value->tenduan]++;
            } else {
                $project_name_counts[$value->tenduan] = 1;
            }
        }

        if (in_array($user['department_id'], $project_manager) || $user['name'] == $project->name_create || (in_array($user['position_id'], [1, 2,3 , 4])) || in_array($user['department_id1'], $project_manager) || $user['department_id'] == 2) {
            return view('Project management.projectConnect', compact('userAll','departments','user', 'project', 'project_department', 'project_name_counts', 'today', 'workByProjectDepartments', 'id', 'projectJson','car_brands','userAllByDepartment','departmentNames'));
        } else {
            return redirect()->back()->with('failder', 'không thành công');
        }
    }

//----------------- CẬP NHẬT TIẾN ĐỘ CÔNG VIỆC --------------------//
    public function updateResult(request $request){
        $updateResult = ProjectDepartment::find($request['id']);
        $updateResult->completion = $request['completion'];
        $updateResult->updated_at = Carbon::now();
        $updateResult->save();
        $project = $updateResult->project;
        $project->updateCompletion();
        return response()->json([
            'status' => 'success',
            'message' => 'Tiến độ đã được cập nhật',
            'new_completion' => $updateResult->completion,
        ]);
    }

//----------------- DANH SÁCH DỰ ÁN CON ( TBP, TN, CHUYÊN VIÊN ) ------------------------//
    public function ProjectCon($id){
        $today = date('Y-m-d');
        $user = Auth::user();
        $projectLv3 = Work_By_Project_Department::find($id);
        $projectlv2 = ProjectDepartment::find($projectLv3->project_department_id);
        $projectlv1 = Project::find($projectlv2->project_id);
        
        $responsibleUser = User::where('name', $projectLv3->responsibility)->first();
        $responsibleDepartmentId = $responsibleUser->department_id;

        $usersInResponsibleDepartment = User::where('department_id', $responsibleDepartmentId)->get();

        // dd($usersInResponsibleDepartment->toarray());
        
        // Lấy danh sách các phòng ban tham gia vào projectlv2 từ projectlv1
        $projectLv1Departments = ProjectDepartment::where('project_id', $projectlv1->id)->get();

        // Lấy danh sách department_id từ $projectLv1Departments
        $departmentIds = $projectLv1Departments->pluck('department_id');

        $departmentNames = Department::whereIn('id', $departmentIds)->pluck('name', 'id');

        // Lấy danh sách người dùng thuộc các phòng ban trong $departmentIds
        $userAll = User::whereIn('department_id', $departmentIds)->get();
        $userAllByDepartment = [];
        foreach ($departmentIds as $departmentId) {
            $usersInDepartment = User::where('department_id', $departmentId)->get();
            $userAllByDepartment[$departmentId] = $usersInDepartment;
        }
        $car_brands = CarBrands::select('car_brands.name')->where('id',$projectlv1->car_brands_id)->first();
        $projectLv4 = work_lv4_project::select('work_lv4_project.*')
        ->where('work_by_project_department_id', $id)
        ->paginate(10);

        return view('Project management.projectCon', compact('usersInResponsibleDepartment','user', 'projectLv4', 'id', 'car_brands', 'projectLv3', 'projectlv2', 'today', 'projectlv1', 'userAll', 'departmentNames','userAllByDepartment'));
    }

//----------------- IMPORT DỰ ÁN THỦ CÔNG CHO DỰ ÁN CON -----------------------//
    public function importHandmade(Request $request){
        $check = Work_By_Project_Department::create([
            'name_work' => $request['task_name'],
            'responsibility' => $request['responsibility'],
            'project_department_id' => $request['project_department_id'],
            'startdate' => $request['start_date'],
            'enddate' => $request['end_date'],
        ]);
        if($check){
            return response()->json([
                'success' => true,
                'message' => 'Xóa kế hoạch thành công'
            ]);
        }else{
            return response()->json([
                'error' => true,
                'message' => 'Thêm thất bại'
            ]);
        }
    }
//----------------- IMPORT DỰ ÁN THỦ CÔNG CHO DỰ ÁN CON LV4 -----------------------//
        public function importHandmadeLv4(Request $request){
            
            $users = Cache::remember('users', 60, function () {
                return User::all();
            });
            $user = $users->first(function ($user) use ($request) {
                return $user->name === $request['responsibility'];
            });
            // dd($user->toArray());
            $check = work_lv4_project::create([
                'name_work' => $request['task_name'],
                'responsibility' => $request['responsibility'],
                'work_by_project_department_id' => $request['project_department_id'],
                'startdate' => $request['start_date'],
                'enddate' => $request['end_date'],
            ]);
           
            if($check){
                
                $start_date = Carbon::parse($request['start_date']);
                $end_date = Carbon::parse($request['end_date']);

                // If start_date is equal to end_date, create a new Workdaily record
                if ($start_date->equalTo($end_date)) {
                    Workdaily::create([
                        'categoryDaily' => $request['task_name'],
                        'responsibility' => $request['responsibility'],
                        'date' => $start_date->toDateString(),
                        'department_id' => $user['department_id'],
                        'team_id' => $user['team_id'],
                        'status' => -1,
                    ]);
                } else {
                    while ($start_date->lte($end_date)) {
                        $week_start_date = $start_date->copy()->startOfWeek();
                        $week_end_date = $start_date->copy()->endOfWeek();

                        // Avoid exceeding the original end_date
                        if ($week_end_date->gt($end_date)) {
                            $week_end_date = $end_date;
                        }
                     
                        // Create Workweek record
                        // dd($request['responsibility']);
                        $workWeek = Workweek::create([
                            'categoryWeek' => $request['task_name'],
                            'responsibility' => $request['responsibility'],
                            'startdate' => $week_start_date->toDateString(),
                            'enddate' => $week_end_date->toDateString(),
                            'department_id' => $user['department_id'],
                            'team_id' => $user['team_id'],
                            'status' => -1,
                            // Add other necessary fields as required...
                        ]);
                        
                        // Calculate the days within the week
                        $dates = [];
                        for ($date = $week_start_date; $date->lte($week_end_date); $date->addDay()) {
                            $dates[] = $date->copy();
                        }
                        
                        // Create a Workdaily record for each day
                        foreach ($dates as $date) {
                            Workdaily::create([
                                'workweek_id' => $workWeek->id,
                                'categoryDaily' => $request['task_name'],
                                'responsibility' => $request['responsibility'],
                                'date' => $date->toDateString(),
                                'department_id' => $user['department_id'],
                                'team_id' => $user['team_id'],
                                'status' => -1,
                            ]);
                        }
                        

                        // Move to the start of the next week
                        $start_date->addWeek();
                    }
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Thêm công việc thành công'
                ]);
            }else{
                return response()->json([
                    'error' => true,
                    'message' => 'Thêm thất bại'
                ]);
            }
        }

//----------------- IMPORT FILE EXCEL CHO DỰ ÁN CON -----------------------//
    public function importExcel(Request $request){
        $projectlv2 = ProjectDepartment::find($request->id);
        $projectlv1 = Project::find($projectlv2->project_id);
        $projectLv1Departments = ProjectDepartment::where('project_id', $projectlv1->id)->get();
       
        // Lấy danh sách department_id từ $projectLv1Departments
        $departmentIds = $projectLv1Departments->pluck('department_id');
        // dd($departmentIds->toarray());
        $file = $request->file('file');
   

        if ($file) {
            $reader = IOFactory::createReaderForFile($file->getPathName());
            $spreadsheet = $reader->load($file->getPathName());
            $worksheet = $spreadsheet->getActiveSheet();
            $isHeader = true;
            
            // Lấy danh sách tên người dùng từ cache hoặc truy vấn cơ sở dữ liệu nếu chưa có
            $user_names = Cache::remember('user_names', 60, function () {
                return User::select('name')->get()->pluck('name')->toArray();
            });
 
            // dd($worksheet->toArray());
            foreach ($worksheet->toArray() as $row) {
                // dd($row);
                if ($isHeader) {
                    $isHeader = false;
                    continue;
                }

                if (empty($row[1]) || empty($row[2]) || empty($row[3]) || empty($row[4])) {
                    continue;
                }
                $user = User::where('name', $row[2])->whereIn('department_id', $departmentIds)->orWhereIn('department_id1', $departmentIds)->first();
                
                if (!$user) {
                    return redirect()->back()->with('error', 'Nhân sự không thuộc phòng ban này.');
                }
                // Kiểm tra giá trị 'responsibility' có tồn tại trong bảng users không
                if (!in_array($row[2], $user_names)) {
                    return redirect()->back()->with('error', 'Giá trị responsibility không tồn tại trong bảng users.');
                }

                $check = Work_By_Project_Department::create([
                    'name_work' => $row[1],
                    'responsibility' => $row[2],
                    'project_department_id' => $request['id'],
                    'startdate' => $row[3],
                    'enddate' => $row[4],
                ]);

                if (!$check) {
                    return redirect()->back()->with('error', 'Không được.');
                }
            }
            return redirect()->back()->with('success', 'Nhập dữ liệu từ file Excel thành công!');
        } else {
            return redirect()->back()->with('error', 'Vui lòng chọn một file Excel để nhập dữ liệu.');
        }
    }
//----------------- IMPORT FILE EXCEL CHO DỰ ÁN LV4 -----------------------//
        public function importExcelLv4(Request $request){
            $projectLv3 = Work_By_Project_Department::find($request['id']);
            $projectlv2 = ProjectDepartment::find($projectLv3->project_department_id);
            $projectlv1 = Project::find($projectlv2->project_id);
            $projectLv1Departments = ProjectDepartment::where('project_id', $projectlv1->id)->get();

            // Lấy danh sách department_id từ $projectLv1Departments
            $departmentIds = $projectLv1Departments->pluck('department_id');
            $file = $request->file('file');
            $users = Auth::user();
            if ($file) {
                $reader = IOFactory::createReaderForFile($file->getPathName());
                $spreadsheet = $reader->load($file->getPathName());
                $worksheet = $spreadsheet->getActiveSheet();
                $isHeader = true;

                $user_names = Cache::remember('user_names', 60, function () {
                    return User::select('name')->get()->pluck('name')->toArray();
                });
// dd($user_names);
                foreach ($worksheet->toArray() as $row) {
                    if ($isHeader) {
                        $isHeader = false;
                        continue;
                    }

                    if (empty($row[1]) || empty($row[2]) || empty($row[3]) || empty($row[4])) {
                        continue;
                    }
                    $user = User::where('name', $row[2])->whereIn('department_id', $departmentIds)->orWhereIn('department_id1', $departmentIds)->first();
                    // dd($user);
                    if (!$user) {
                        return redirect()->back()->with('error', 'Nhân sự không thuộc phòng ban này.');
                    }
                    if (!in_array($row[2], $user_names)) {
                        return redirect()->back()->with('error', 'Giá trị responsibility không tồn tại trong bảng users.');
                    }

                    $start_date = Carbon::parse($row[3]);
                    $end_date = Carbon::parse($row[4]);

                    if ($start_date->gt($end_date)) {
                        return redirect()->back()->with('error', 'Ngày bắt đầu không được lớn hơn ngày kết thúc.');
                    }

                    $check = work_lv4_project::create([
                        'name_work' => $row[1],
                        'responsibility' => $row[2],
                        'work_by_project_department_id' => $request['id'],
                        'startdate' => $row[3],
                        'enddate' => $row[4],
                    ]);

                    if (!$check) {
                        return redirect()->back()->with('error', 'Không được.');
                    }

                    // Get the user
                    $user = Auth::user(); // Replace this with your actual method of getting the logged in user

                    // If start_date is equal to end_date, create a new Workdaily record
                    if ($start_date->equalTo($end_date)) {
                        Workdaily::create([
                            'categoryDaily' => $row[1],
                            'responsibility' => $row[2],
                            'date' => $start_date->toDateString(),
                            'department_id' => $user['department_id'],
                            'team_id' => $user['team_id'],
                            'status' => -1,
                        ]);
                    } else {
                        while ($start_date->lte($end_date)) {
                            $week_start_date = $start_date->copy()->startOfWeek();
                            $week_end_date = $start_date->copy()->endOfWeek();

                            // Avoid exceeding the original end_date
                            if ($week_end_date->gt($end_date)) {
                                $week_end_date = $end_date;
                            }

                            // Create Workweek record
                            $workWeek = Workweek::create([
                                'categoryWeek' => $row[1],
                                'responsibility' => $row[2],
                                'startdate' => $week_start_date->toDateString(),
                                'enddate' => $week_end_date->toDateString(),
                                'department_id' => $user['department_id'],
                                'team_id' => $user['team_id'],
                                'status' => -1,
                                // Add other necessary fields
                                                    // as required...
                                ]);

                                // Calculate the days within the week
                                $dates = [];
                                for ($date = $week_start_date; $date->lte($week_end_date); $date->addDay()) {
                                    $dates[] = $date->copy();
                                }

                                // Create a Workdaily record for each day
                                foreach ($dates as $date) {
                                    Workdaily::create([
                                        'workweek_id' => $workWeek->id,
                                        'categoryDaily' => $row[1],
                                        'responsibility' => $row[2],
                                        'date' => $date->toDateString(),
                                        'department_id' => $user['department_id'],
                                        'team_id' => $user['team_id'],
                                        'status' => -1,
                                    ]);
                                }

                                // Move to the start of the next week
                                $start_date->addWeek();
                            }
                        }
                    }
                    return redirect()->back()->with('successful', 'Nhập dữ liệu từ file Excel thành công!');
                } else {
                    return redirect()->back()->with('deleteSuccess', 'Vui lòng chọn một file Excel để nhập dữ liệu.');
                }
            }


//-----------------CẬP NHẬT TIẾN ĐỘ CÔNG VIỆC CON----------------------------//
    public function updateResultCon(request $request){

        $updateResult = Work_By_Project_Department::find($request['id']);
        $updateResult->completion = $request['completion'];
        $updateResult->save();
        $projectDepartment = $updateResult->projectDepartment; // Sửa tại đây
        $projectDepartment->updateCompletion(); // Gọi hàm updateCompletion của projectDepartment
        return response()->json([
            'status' => 'success',
            'message' => 'Tiến độ đã được cập nhật',
            'new_completion' => $updateResult->completion,
        ]);
    }

//----------------- GHI CHÚ DỰ ÁN CON CUỐI CÙNG ----------------------------//
    public function saveNote(Request $request){
            // dd($request->toArray());
            $note = $request->input('note');
            $dataId = $request->input('data_id');

            // Lưu ghi chú vào cơ sở dữ liệu
            // Giả sử bạn có một model tên là YourModel liên kết với bảng cần lưu ghi chú
            $record = Work_By_Project_Department::find($dataId);
            $record->note = $note;
            $record->save();

            return response()->json(['message' => 'Ghi chú đã được lưu thành công']);
    }
//------------------CẬP NHẬT TIẾN ĐỘ CÔNG VIỆC LV4----------------------------//
    public function updateResultLv4(request $request){
        // dd($request->toArray());
        $updateResult = work_lv4_project::find($request['id']);
        $updateResult->completion = $request['completion'];
        $updateResult->save();
    
        // Cập nhật completion của các model cha liên quan
        $updateResult->updateCompletion();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Tiến độ đã được cập nhật',
            'new_completion' => $updateResult->completion,
            'start_date' => $updateResult->startdate, // Thêm dòng này
            'end_date' => $updateResult->enddate, // Thêm dòng này
        ]);

    }

//----------------- GHI CHÚ DỰ ÁN CON CUỐI CÙNG ----------------------------//
    public function saveNoteLv4(Request $request){
        // dd($request->toArray());
        $note = $request->input('note');
        $dataId = $request->input('data_id');

        // Lưu ghi chú vào cơ sở dữ liệu
        // Giả sử bạn có một model tên là YourModel liên kết với bảng cần lưu ghi chú
        $record = work_lv4_project::find($dataId);
        $record->note = $note;
        $record->save();

        return response()->json(['message' => 'Ghi chú đã được lưu thành công']);
    }

//----------------- EXPORT EXECL ----------------------------//

    public function downloadTempFile($fileName){
        $file = storage_path('app/temp/' . $fileName);

        // 4. Xóa tập tin Excel tạm thời sau khi người dùng tải xuống
        $response = response()->download($file);
        $response->deleteFileAfterSend(true);

        return $response;
    }
    public function exportExcel(){
    return Excel::download(new DelayedWorksExport(), 'delayed_works.xlsx');
    }

//------------------- CALL API ĐỂ SỬA DỰ ÁN CON LV2-----------------------//
    public function show($id){
        $projectDepartment = ProjectDepartment::findOrFail($id);
        return response()->json($projectDepartment);
    }

    public function update(Request $request, $id){
        // Tìm ProjectDepartment bằng ID
        $projectDepartment = ProjectDepartment::findOrFail($id);

        // Validate dữ liệu trước khi cập nhật
        $validatedData = $request->validate([
            'department_id' => 'required',
            'startdate' => 'required|date',
            'enddate' => ['required', 'date', 'after_or_equal:startdate'],
        ]);

        // Kiểm tra nếu department_id thay đổi
        if ($request->input('department_id') != $projectDepartment->department_id) {
            // Xóa các bản ghi work_lv4_project liên quan đến work_by_project_department
            Work_Lv4_Project::whereIn('work_by_project_department_id', function($query) use ($id) {
                $query->select('id')
                    ->from('work_by_project_department')
                    ->where('project_department_id', $id);
            })->delete();

            // Xóa các bản ghi work_by_project_department liên quan đến project_department
            Work_By_Project_Department::where('project_department_id', $id)->delete();
        }
        $projectDepartment->number_of_edits += 1;
        $projectDepartment->update($validatedData);

        return response()->json(['message' => 'Cập nhật thành công']);
    }

//---------------- XÓA DỰ ÁN LV2 -----------------------------//
    public function destroy($id){
        $projectDepartment = ProjectDepartment::findOrFail($id);
        $projectDepartment->delete();
        return response()->json(['message' => 'Xóa thành công']);
    }
//----------------------- THÊM DỰ ÁN --------------------//
    public function store(Request $request){
        // dd($request->toArray());
        $validatedData = $request->validate([
            'name' => '',
            'department_id' => 'required',
            'startdate' => 'required|date',
            'enddate' => 'required|date|after_or_equal:startdate',
            'project_id' => 'required',
        ]);

        $newProjectDepartment = ProjectDepartment::create($validatedData);
        return response()->json(['message' => 'Thêm thành công', 'projectDepartment' => $newProjectDepartment]);
    }
//----------------------- KHÓA DỰ ÁN ---------------------// 
    public function lock($id){
        // Tìm kế hoạch bằng ID
        $projectDepartment = project::findOrFail($id);

        // Cập nhật trạng thái khóa của kế hoạch và lưu vào cơ sở dữ liệu
        $projectDepartment->lock = 1;
        $projectDepartment->save();

        return response()->json(['message' => 'Kế hoạch đã được khóa']);
    }
//------------------------ UNLOCK DỰ ÁN -----------------//
    public function unlock($id){
        // Tìm kế hoạch bằng ID
        $projectDepartment = project::findOrFail($id);

        // Cập nhật trạng thái khóa của kế hoạch và lưu vào cơ sở dữ liệu
        $projectDepartment->lock = 0;
        $projectDepartment->save();

        return response()->json(['message' => 'Kế hoạch đã được mở khóa']);
    }

//----------------- CALL API ĐỂ SỬA DỰ ÁN LV3 ------------------//
    public function showWork($id)
    {
        $work = Work_By_Project_Department::findOrFail($id);
        return response()->json($work);
    }

    public function updateWork(Request $request, $id)
    {
        $work = Work_By_Project_Department::findOrFail($id);

        // Validate dữ liệu trước khi cập nhật
        $validatedData = $request->validate([
            'name_work' => 'required',
            'responsibility' => 'required',
            'startdate' => 'required|date',
            'enddate' => 'required|date|after_or_equal:startdate',
        ]);

        $work->update($validatedData);

        return response()->json(['message' => 'Cập nhật thành công']);
    }
//---------------- XÓA DỰ ÁN LV3 -----------------------------//
    public function deleteWork($id){
        $projectDepartment = Work_By_Project_Department::findOrFail($id);
        $projectDepartment->delete();
        return response()->json(['message' => 'Xóa thành công']);
    }
//----------------- CALL API ĐỂ SỬA DỰ ÁN LV4 ------------------//
    public function showLv4($id)
    {
        $work = work_lv4_project::findOrFail($id);
        return response()->json($work);
    }

    public function updateLv4(Request $request, $id){
        $work = work_lv4_project::findOrFail($id);

        // Validate dữ liệu trước khi cập nhật
        $validatedData = $request->validate([
            'name_work' => 'required',
            'responsibility' => 'required',
            'startdate' => 'required|date',
            'enddate' => 'required|date|after_or_equal:startdate',
        ]);

        $work->update($validatedData);

        return response()->json(['message' => 'Cập nhật thành công']);
    }
    public function deleteLv4($id){
        $projectDepartment = work_lv4_project::findOrFail($id);
        $projectDepartment->delete();
        return response()->json(['message' => 'Xóa thành công']);
    }
    
    public function saveNoteProject(Request $request){
        $note = $request->input('note');
        $dataId = $request->input('data_id');

        // Lưu ghi chú vào cơ sở dữ liệu
        // Giả sử bạn có một model tên là YourModel liên kết với bảng cần lưu ghi chú
        $record = ProjectDepartment::find($dataId);
        $record->note = $note;
        $record->save();

        return response()->json(['message' => 'Ghi chú đã được lưu thành công']);
    }
}