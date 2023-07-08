<?php

namespace App\Services;

use App\Models\TaskLink;
use App\Models\ProjectDepartment;
use App\Models\Work_By_Project_Department;
use App\Models\work_lv4_project;

class TaskLinkService 
{
    //kiểm tra cha con
    protected function checkParentChildTask($dependentTaskId, $dependentTaskTable, $relatedTaskId, $relatedTaskTable) {
        if ($dependentTaskTable == 'project_department' && $relatedTaskTable == 'work_by_project_department') {
            $relatedTask = Work_By_Project_Department::find($relatedTaskId);
            return $relatedTask->project_department_id != $dependentTaskId;
        }
    
        if ($dependentTaskTable == 'project_department' && $relatedTaskTable == 'work_lv4_project') {
            $relatedTask = Work_lv4_Project::find($relatedTaskId);
            $parentTask = Work_By_Project_Department::find($relatedTask->work_by_project_department_id);
            return $parentTask->project_department_id != $dependentTaskId;
        }
    
        if ($dependentTaskTable == 'work_by_project_department' && $relatedTaskTable == 'work_lv4_project') {
            $relatedTask = Work_lv4_Project::find($relatedTaskId);
            return $relatedTask->work_by_project_department_id != $dependentTaskId;
        }
    
        return true;
    }
    
    //kiểm tra có tạo ra vòng lặp không
    protected function checkLoop($dependentTaskId, $relatedTaskId) {
        return $this->searchLink($dependentTaskId, $relatedTaskId);
    }
    
    protected function searchLink($currentTaskId, $targetTaskId, $depth = 0) {
        $links = TaskLink::where('related_task_id', $currentTaskId)->get();
    
        foreach ($links as $link) {
            if ($link->dependent_task_id == $targetTaskId) {
                return false;
            }

            if ($depth < 10) {
                if (!$this->searchLink($link->dependent_task_id, $targetTaskId, $depth + 1)) {
                    return false;
                }
            }
        }
    
        return true;
    }
    //kiểm tra các công việc có trùng nhau không
    protected function checkSelfLink($dependentTaskId, $relatedTaskId) {
        return $dependentTaskId !== $relatedTaskId;
    }
    
    //kiểm tra xem công việc phụ thuộc đã hoàn thành hay chưa
    protected function checkTaskCompletion($dependentTaskId, $dependentTaskTable, $relatedTaskId, $relatedTaskTable) {
        if ($dependentTaskTable == 'project_department') {
            $task = ProjectDepartment::find($dependentTaskId);
        } elseif ($dependentTaskTable == 'work_by_project_department') {
            $task = Work_By_Project_Department::find($dependentTaskId);
        } else { 
            $task = work_lv4_project::find($dependentTaskId);
        }
    
        if ($task && $task->completion == 100) {
            return false; 
        }
    
        if ($relatedTaskTable == 'project_department') {
            $task = ProjectDepartment::find($relatedTaskId);
        } elseif ($relatedTaskTable == 'work_by_project_department') {
            $task = Work_By_Project_Department::find($relatedTaskId);
        } else { 
            $task = work_lv4_project::find($relatedTaskId);
        }
    
        if ($task && $task->completion == 100) {
            return false; 
        }
    
        return true;
    }
    //kiểm tra xem công việc sắp thêm có bị trùng với công việc trước đó
    protected function checkDuplicateLink($dependentTaskId, $dependentTaskTable, $relatedTaskId, $relatedTaskTable) {
        $existingLink = TaskLink::where('dependent_task_id', $dependentTaskId)
                                ->where('dependent_task_table', $dependentTaskTable)
                                ->where('related_task_id', $relatedTaskId)
                                ->where('related_task_table', $relatedTaskTable)
                                ->first();
        if ($existingLink) {
            return false;
        }
    
        return true;
    }
    
    

    public function addTaskLink($data) {
        if (!$this->checkParentChildTask(
                $data['dependent_task_id'], 
                $data['dependent_task_table'], 
                $data['related_task_id'], 
                $data['related_task_table']
            )
        ) {
            throw new \Exception("Công việc này là cha/con của công việc liên kết");
        }
    
        if (!$this->checkLoop(
                $data['dependent_task_id'], 
                $data['related_task_id']
            )
        ) {
            throw new \Exception("Công việc bạn thêm sẽ tạo ra vòng lặp vô hạn");
        }
    
        if (!$this->checkSelfLink(
                $data['dependent_task_id'], 
                $data['related_task_id']
            )
        ) {
            throw new \Exception("Công việc bạn thêm trùng với công việc gốc");
        }
    
        if (!$this->checkTaskCompletion(
                $data['dependent_task_id'], 
                $data['dependent_task_table'], 
                $data['related_task_id'], 
                $data['related_task_table']
            )
        ) {
            throw new \Exception("Công việc bạn thêm đã hoàn thành");
        }
        if (!$this->checkDuplicateLink(
            $data['dependent_task_id'], 
            $data['dependent_task_table'], 
            $data['related_task_id'], 
            $data['related_task_table']
        )
        ) {
            throw new \Exception("Công việc bạn thêm đã thêm trước đó");
        }
    
        TaskLink::create($data);
        return true;
    }
    
}
