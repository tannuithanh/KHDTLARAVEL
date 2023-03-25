<?php

namespace App\Http\Controllers;

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

        $project = Project::select('project.*', DB::raw("GROUP_CONCAT(CONCAT('-', departments.name, '\n') SEPARATOR '\n') as department_names"))
        ->join('project_department', 'project.id', '=', 'project_department.project_id')
        ->join('departments', 'project_department.department_id', '=', 'departments.id')
        ->groupBy('project.id', 'name_project','describe_project','name_create','start_date','end_date','status','privacy','created_at','updated_at')
        ->get();        
        return view('Project management.projectManagerment',compact('user','teams','userById','project','today'));
    }
    
    public function formCreatProject(){
        $departments = Department::get();
        // dd($departments->toArray());
        $user = Auth::user();
        return view('Project management.Creat Project.formCreat',compact('user','departments'));
    }

    public function insertCreatProject(request $request){
        $today = date('d/m/Y'); 

        $user = Auth::user();

        if($request['end_date']<=$today){
            return back()->with('no','...');
        }
        if($request['departments']==Null){
            return back()->with('nono','...');
        }
     
        $date = Carbon::createFromFormat('d/m/Y', $request['start_date']);
        $date1 = Carbon::createFromFormat('d/m/Y', $request['end_date']);
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
        foreach($request['departments'] as $value){
            project_department::create([
                'project_id' => $idProject,
                'department_id' => $value,
            ]);
        }
        
        return redirect()->route('listProjectManagerment')->with('success','Tạo dự án Thành công');
        
    }
}
