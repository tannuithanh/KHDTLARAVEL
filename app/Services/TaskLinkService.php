<?php

namespace App\Services;

use App\Models\TaskLink;
use App\Models\ProjectDepartment;
use App\Models\Work_By_Project_Department;
use App\Models\work_lv4_project;

class TaskLinkService 
{
    //kiểm tra cha con
    public function checkParentChildTask($dependentTaskId, $dependentTaskTable, $relatedTaskId, $relatedTaskTable) {
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
        if ($dependentTaskTable == 'work_by_project_department' && $relatedTaskTable == 'project_department') {
            $dependentTask = Work_By_Project_Department::find($dependentTaskId);
            return $dependentTask->project_department_id != $relatedTaskId;
        }
        if ($dependentTaskTable == 'work_lv4_project' && $relatedTaskTable == 'project_department') {
            $dependentTask = Work_lv4_Project::find($dependentTaskId);
            $parentTask = Work_By_Project_Department::find($dependentTask->work_by_project_department_id);
            return $parentTask->project_department_id != $relatedTaskId;
        }
        if ($dependentTaskTable == 'work_lv4_project' && $relatedTaskTable == 'work_by_project_department') {
            $dependentTask = Work_lv4_Project::find($dependentTaskId);
            return $dependentTask->work_by_project_department_id != $relatedTaskId;
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
    // Hàm này để lấy thông tin công việc liên quan
    protected function layCongViecLienQuan($relatedTaskId, $relatedTaskTable) {
        if ($relatedTaskTable == 'project_department') {
            return ProjectDepartment::find($relatedTaskId);
        } elseif ($relatedTaskTable == 'work_by_project_department') {
            return Work_By_Project_Department::find($relatedTaskId);
        } else { 
            return Work_lv4_Project::find($relatedTaskId);
        }
    }

    // Hàm này để lấy thông tin công việc phụ thuộc
    protected function layCongViecPhuThuoc($dependentTaskId, $dependentTaskTable) {
        if ($dependentTaskTable == 'project_department') {
            return ProjectDepartment::find($dependentTaskId);
        } elseif ($dependentTaskTable == 'work_by_project_department') {
            return Work_By_Project_Department::find($dependentTaskId);
        } else { 
            return Work_lv4_Project::find($dependentTaskId);
        }
    }

    // Hàm này để cập nhật ngày bắt đầu và kết thúc dựa trên loại mối quan hệ
    public function capNhatNgayTheoQuanHe($relationshipType, $dependentTaskId, $dependentTaskTable, $relatedTaskId, $relatedTaskTable) {
        $relatedTask = $this->layCongViecLienQuan($relatedTaskId, $relatedTaskTable);
        $dependentTask = $this->layCongViecPhuThuoc($dependentTaskId, $dependentTaskTable);

        switch ($relationshipType) {
            case 'FS':
                // Quan hệ FS: công việc liên quan không thể bắt đầu cho đến khi công việc phụ thuộc hoàn thành.
                if ($relatedTask->startdate < $dependentTask->enddate) {
                    $relatedTask->startdate = $dependentTask->enddate->addDay(); // Hoặc thêm bất kỳ khoảng thời gian bạn muốn
                    $relatedTask->save();
                }
                break;
            case 'SS':
                // Quan hệ SS: công việc liên quan không thể bắt đầu cho đến khi công việc phụ thuộc bắt đầu.
                if ($relatedTask->startdate < $dependentTask->startdate) {
                    $relatedTask->startdate = $dependentTask->startdate;
                    $relatedTask->save();
                }
                break;
            case 'SF':
                // Quan hệ SF: công việc liên quan không thể kết thúc cho đến khi công việc phụ thuộc bắt đầu.
                if ($relatedTask->enddate < $dependentTask->startdate) {
                    $relatedTask->enddate = $dependentTask->startdate;
                    $relatedTask->save();
                }
                break;
            case 'FF':
                // Quan hệ FF: công việc liên quan không thể kết thúc cho đến khi công việc phụ thuộc hoàn thành.
                if ($relatedTask->enddate < $dependentTask->enddate) {
                    $relatedTask->enddate = $dependentTask->enddate;
                    $relatedTask->save();
                }
                break;
        }
        
        // Cập nhật các công việc khác liên kết với công việc liên quan vừa được cập nhật
        $congViecLienKet = TaskLink::where('dependent_task_id', $relatedTaskId)->get();
        foreach ($congViecLienKet as $task) {
            $this->capNhatNgayTheoQuanHe($task->relationship_type, $task->dependent_task_id, $task->dependent_task_table, $task->related_task_id, $task->related_task_table);
        }
    }

    public function addTaskLink($data) {
    
        if (!$this->checkParentChildTask($data['dependent_task_id'], $data['dependent_task_table'], $data['related_task_id'], $data['related_task_table'])) {
            throw new \Exception("Công việc này là cha/con của công việc liên kết");
        }
    
        if (!$this->checkLoop($data['dependent_task_id'], $data['related_task_id'])) {
            throw new \Exception("Công việc bạn thêm sẽ tạo ra vòng lặp vô hạn");
        }
    
        if (!$this->checkSelfLink($data['dependent_task_id'], $data['related_task_id'])) {
            throw new \Exception("Công việc bạn thêm trùng với công việc gốc");
        }
    
        if (!$this->checkTaskCompletion($data['dependent_task_id'], $data['dependent_task_table'], $data['related_task_id'], $data['related_task_table'])) {
            throw new \Exception("Công việc bạn thêm đã hoàn thành");
        }
    
        if (!$this->checkDuplicateLink($data['dependent_task_id'], $data['dependent_task_table'], $data['related_task_id'], $data['related_task_table'])) {
            throw new \Exception("Công việc bạn thêm đã thêm trước đó");
        }
        
        $taskLink = new TaskLink;
        $taskLink->dependent_task_id = $data['dependent_task_id'];
        $taskLink->dependent_task_table = $data['dependent_task_table'];
        $taskLink->related_task_id = $data['related_task_id'];
        $taskLink->related_task_table = $data['related_task_table'];
        $taskLink->relationship_type = $data['relationship_type'];
        $taskLink->save();
        
        // Cập nhật ngày bắt đầu và kết thúc của các công việc liên quan dựa trên mối quan hệ
        $this->capNhatNgayTheoQuanHe($data['relationship_type'], $data['dependent_task_id'], $data['dependent_task_table'], $data['related_task_id'], $data['related_task_table']);
    
        return true;
    }
    
    
    
    
}
