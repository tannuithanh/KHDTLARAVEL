<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Team;
use App\Models\User;
use App\Models\Project;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\project_department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProjecManagement extends Controller
{
    public function listProjectManagement(){
        $today = date('Y-m-d');
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

        $project = Project::select('project.*', 
        DB::raw("GROUP_CONCAT(CONCAT('-', departments.name, '\n') SEPARATOR '\n') as department_names"),
        DB::raw("GROUP_CONCAT(project_department.department_id) as department_ids"))
        ->join('project_department', 'project.id', '=', 'project_department.project_id')
        ->join('departments', 'project_department.department_id', '=', 'departments.id')
        ->groupBy('project.id', 'name_project','describe_project','name_create','start_date','end_date','status','privacy','created_at','updated_at')
        ->get();   
        // dd($project->toArray());
        return view('Project management.projectManagerment',compact('user','teams','userById','project','today'));
    }
    
    public function formCreatProject(){
        $departments = Department::get();
        // dd($departments->toArray());
        $user = Auth::user();
        return view('Project management.Creat Project.formCreat',compact('user','departments'));
    }

    public function insertCreatProject(request $request){

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
        ]);

        $idProject = $project->id;
        $count = count($request['departments']);

        for ($i = 0; $i < $count; $i++) {
            project_department::create([
                'project_id' => $idProject,
                'department_id' => $request['departments'][$i],
                'startdate' => $request['start_date'][$i],
                'enddate' => $request['end_date'][$i],
                'name' => $request['task_name'][$i],
            ]);
        }
        
        
        return redirect()->route('listProjectManagerment')->with('success','Tạo dự án Thành công');
        
    }

    public function deleteProject($id){
        $deleteProject = Project::find($id);
        $deleteProject->delete();
        project_department::where('project_id',$id)->delete();
        return redirect()->route('listProjectManagerment')->with('deleteSuccess', 'Xóa kế hoạch thành công');
    }   

    public function formEditProject($id){
        $project = Project::find($id);
        $date = Carbon::createFromFormat('Y-m-d', $project['start_date']);
        $date1 = Carbon::createFromFormat('Y-m-d', $project['end_date']);
        $newDate = $date->format('d/m/Y');
        $newDate1 = $date1->format('d/m/Y');
        // dd($newDate);
        $departments = Department::get();
        $user = Auth::user();
        return view('Project management.Creat Project.editProject',compact('user','departments','project','newDate','newDate1'));
    }

    public function updateEditProject($id, request $request){
        $end_date = DateTime::createFromFormat('d/m/Y', $request['end_date']); // Chuyển chuỗi thành đối tượng ngày
        // dd($today,$request['end_date']);
        $user = Auth::user();

        $today = DateTime::createFromFormat('d/m/Y', date('d/m/Y'));
        $end_date = DateTime::createFromFormat('d/m/Y', $request['end_date']);

        if ($end_date < $today) {
            return back()->with('no', '...');
        }
        if($request['departments']==Null){
            return back()->with('nono','...');
        }

        $date = Carbon::createFromFormat('d/m/Y', $request['start_date']);
        $date1 = Carbon::createFromFormat('d/m/Y', $request['end_date']);
        $newDate = $date->format('Y-m-d');
        $newDate1 = $date1->format('Y-m-d');
        $project = Project::find($id);
        if($project){
            $project->name_project = $request->name_project;
            $project->describe_project = $request->describe_project;
            $project->privacy = $request->privacy;
            $project->save();
        }
        project_department::where('project_id',$id)->delete();
        $idProject = $project->id;
        foreach($request['departments'] as $value){
            project_department::create([
                'project_id' => $idProject,
                'department_id' => $value,
            ]);
        }
        return redirect()->route('listProjectManagerment')->with('edit', 'Sửa kế hoạch thành công');
    }

    public function ProjectConnectView($id){
        $user = Auth::user();
        $project = Project::find($id);
        $project_manager = project_department::where('project_id', $project->id)->pluck('department_id')->toArray();
        $project_department = project_department::select('project_department.*','project.name_project as tenduan','departments.name as tenphongban')
        ->join('project','project.id','=','project_department.project_id')
        ->join('departments','departments.id','=','project_department.department_id')
        ->where('project_id',$id)->get();
        // dd($project->toArray());
        // dd(in_array($user['department_id'], $project_manager));
        //----- Kiểm tra biến $user['department_id'] có nằm trong mảng không -----//
        if (in_array($user['department_id'], $project_manager) || $user['name'] == $project->name_create || (in_array($user['position_id'], [1, 2]))) {    
            return view('Project management.projectConnect',compact('user','project','project_department'));
        }else{
            return redirect()->route('listProjectManagerment')->with('failder','không thành công');
        }
        
    }

    public function ProjectUpdateView($id){
        $project = Project::find($id);
        $user = Auth::user();
        $start_date = Carbon::createFromFormat('Y-m-d', $project->start_date)->format('Y-m-d');
        $end_date = Carbon::createFromFormat('Y-m-d', $project->end_date)->format('Y-m-d');
        $project_manager = project_department::select('project_department.*','project.name_project as tenduan','departments.name as tenphongban')
        ->join('project','project.id','=','project_department.project_id')
        ->join('departments','departments.id','=','project_department.department_id')
        ->where('project_id',$id)->get();
        // dd($project_manager->toArray());
        return view('Project management.Creat Project.project_Department_Update', compact('user','project_manager','start_date','end_date'));
    }
    public function ProjectUpdate($id,request $request){

        foreach( $request['works'] as $value ){
            $PD =  project_department::find($value['id']);
            $PD->name = $value['name'];
            $PD->startdate = $value['startdate'];
            $PD->enddate = $value['enddate'];
            $PD->update();
            
        }
        return redirect()->route('projectConnect',$id)->with('success','cập nhật thành công');
    }

    public function updateStatus(Request $request, $id){
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['error' => 'Dự án không tồn tại'], 404);
        }
    
        $project->status = $request->input('status');
        $project->save();
    
        return response()->json(['success' => 'Trạng thái dự án đã được cập nhật'], 200);
    }
}
