<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\TaskLink;
use Illuminate\Http\Request;
use App\Models\work_lv4_project;
use App\Models\ProjectDepartment;
use App\Services\TaskLinkService;
use App\Models\Work_By_Project_Department;

class TacVu extends Controller
{
    public function TacVuLv1($id){
        // Get the current task
        $data = ProjectDepartment::find($id);
        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        // Get dependent tasks
        $dependentTasks = TaskLink::where('dependent_task_id', $id)
            ->where('dependent_task_table', 'project_department')
            ->get();

        // Loop through each dependent task and get the related task's name
        foreach ($dependentTasks as $task) {
            $relatedTaskTable = $task->related_task_table;
            $relatedTaskId = $task->related_task_id;
            $relatedTaskName = null;

            // Get the related task's name by table name
            switch ($relatedTaskTable) {
                case 'project_department':
                    $relatedTask = ProjectDepartment::find($relatedTaskId);
                    break;
                case 'work_lv4_project':
                    $relatedTask = work_lv4_project::find($relatedTaskId);
                    break;
                case 'work_by_project_department':
                    $relatedTask = Work_By_Project_Department::find($relatedTaskId);
                    break;
                // Add more case statements as needed for other tables
                default:
                    $relatedTask = null;
            }

            // If the related task is found, get its name
            if ($relatedTask) {
                if ($relatedTask instanceof ProjectDepartment) {
                    $relatedTaskName = $relatedTask->name;
                } elseif ($relatedTask instanceof work_lv4_project || $relatedTask instanceof Work_By_Project_Department) {
                    $relatedTaskName = $relatedTask->name_work;
                }
            }

            // Add a new attribute for the related task's name
            $task->related_task_name = $relatedTaskName;
        }

        // Prepare the response
        $response = [
            'task' => $data,
            'dependentTasks' => $dependentTasks
        ];

        return response()->json($response);
    }
    public function TacVuLv2($id){
        // Lấy công việc hiện tại
        $data = Work_By_Project_Department::find($id);
        if (!$data) {
            return response()->json(['error' => 'Không tìm thấy dữ liệu'], 404);
        }
    
        // Lấy các công việc phụ thuộc
        $dependentTasks = TaskLink::where('dependent_task_id', $id)
            ->where('dependent_task_table', 'work_by_project_department')
            ->get();
    
        // Duyệt qua từng công việc phụ thuộc và lấy tên của công việc liên quan
        foreach ($dependentTasks as $task) {
            $relatedTaskTable = $task->related_task_table;
            $relatedTaskId = $task->related_task_id;
            $relatedTaskName = null;
    
            // Lấy tên của công việc liên quan dựa vào tên bảng
            switch ($relatedTaskTable) {
                case 'project_department':
                    $relatedTask = ProjectDepartment::find($relatedTaskId);
                    break;
                case 'work_lv4_project':
                    $relatedTask = work_lv4_project::find($relatedTaskId);
                    break;
                case 'work_by_project_department':
                    $relatedTask = Work_By_Project_Department::find($relatedTaskId);
                    break;
                // Thêm các câu lệnh case khác nếu cần cho các bảng khác
                default:
                    $relatedTask = null;
            }
    
            // Nếu tìm thấy công việc liên quan, lấy tên của nó
            if ($relatedTask) {
                if ($relatedTask instanceof ProjectDepartment) {
                    $relatedTaskName = $relatedTask->name;
                } elseif ($relatedTask instanceof work_lv4_project || $relatedTask instanceof Work_By_Project_Department) {
                    $relatedTaskName = $relatedTask->name_work;
                }
            }
    
            // Thêm một thuộc tính mới cho tên của công việc liên quan
            $task->related_task_name = $relatedTaskName;
        }
    
        // Chuẩn bị phản hồi
        $response = [
            'task' => $data,
            'dependentTasks' => $dependentTasks
        ];
    
        return response()->json($response);
    }
    
        
    

    public function updateTacVu(Request $request) {
        $taskId = $request->input('id');
        $dependencyType = $request->input('dependencyType');
        $numberOfDays = $request->input('numberOfDays');
        $task = TaskLink::find($taskId);
        if(!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }
        $task->relationship_type = $dependencyType;
        $task->day = $numberOfDays;
        $task->save();
        return response()->json(['message' => 'Task updated successfully.'], 200);
    }
    

    public function deleteTacVu(Request $request){
        $taskLink = TaskLink::find($request->id);
        if ($taskLink) {
            $taskLink->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
    

    public function getAllWorks($id) {
        // Get Project data with all its ProjectDepartments, LV2, LV3 and LV4 tasks
        $project = Project::with([
            'projectDepartments' => function($query) {
                $query->whereNotNull('name');
            }, 
            'projectDepartments.works',
            'projectDepartments.works.work_lv4_projects',
        ])
        ->find($id);
    
        if ($project) {
            return response()->json($project);
        } 
    
        // If no Project is found, return a 404 response
        return response()->json(null, 404);
    }
    
    
    public function saveTacVu(Request $request) {
        $taskLinkService = new TaskLinkService(); // hoặc bạn có thể inject TaskLinkService vào controller
    
        foreach ($request->taskLinks as $taskLink) {
            try {
                $taskLinkService->addTaskLink($taskLink);
            } catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage()], 400);
            }
        }
    
        return response()->json(['message' => 'Các liên kết công việc đã được lưu thành công'], 200);
    }
    
    public function CheckTacVu(request $request){
        $taskId = $request->get('id');
        $tasks = TaskLink::where('dependent_task_id', $taskId)
                    ->where('related_task_table', '<>', 'work_lv4_project')
                    ->get();
        // dd($tasks->toArray());
        return response()->json($tasks);
       
    }
    
    
    public function kiemtraLv4(Request $request) {
        $taskId = $request->id;
        $task = Work_lv4_Project::find($taskId);
        return response()->json(['task' => $task]);
    }
    
}
