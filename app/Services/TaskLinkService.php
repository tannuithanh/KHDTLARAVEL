<?php

namespace App\Services;

use App\Models\TaskLink;
use Illuminate\Support\Carbon;
use App\Models\work_lv4_project;
use App\Models\ProjectDepartment;
use App\Models\Work_By_Project_Department;

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

    // Hàm này để lấy các công việc con 
    public function layCacCongViecCon($parentTaskId, $taskType) {
        switch ($taskType) {
            case 'project_department':
                $parentTask = ProjectDepartment::find($parentTaskId);
                return $parentTask->works;
                break;
            case 'work_by_project_department':
                $parentTask = Work_By_Project_Department::find($parentTaskId);
                return $parentTask->work_lv4_projects;
                break;
        }
        return [];
    }
    

    // Hàm này để cập nhật ngày bắt đầu và kết thúc dựa trên loại mối quan hệ

    public function capNhatNgayTheoQuanHe($relationshipType, $dependentTaskId, $dependentTaskTable, $relatedTaskId, $relatedTaskTable) {
        $relatedTask = $this->layCongViecLienQuan($relatedTaskId, $relatedTaskTable);
        $dependentTask = $this->layCongViecPhuThuoc($dependentTaskId, $dependentTaskTable);
    
        $oldStartdate = Carbon::parse($relatedTask->startdate);
        $oldEnddate = Carbon::parse($relatedTask->enddate);
        // Cập nhật các công việc con dựa trên chênh lệch ngày giữa công việc cha và con trước khi công việc cha được cập nhật
        switch ($relatedTaskTable) {
            case 'project_department':
                $this->capNhatCacCongViecCon($relatedTask, 'project_department');
                break;
            case 'work_by_project_department':
                $this->capNhatCacCongViecCon($relatedTask, 'work_by_project_department');
                break;
        }
        switch ($relationshipType) {
            case 'FS (Finish-to-Start)':
                // Quan hệ FS: công việc liên quan không thể bắt đầu cho đến khi công việc phụ thuộc hoàn thành.
                $newStartdate = Carbon::parse($dependentTask->enddate)->addDay();
                if ($oldStartdate < $newStartdate) {
                    $dateDiff = $oldStartdate->diffInDays($newStartdate);
                    $relatedTask->startdate = $newStartdate;
                    $relatedTask->enddate = $oldEnddate->addDays($dateDiff);
                    $relatedTask->save();
                }
                break;
            case 'SS (Start-to-Start)':
                // Quan hệ SS: công việc liên quan không thể bắt đầu cho đến khi công việc phụ thuộc bắt đầu.
                $newStartdate = Carbon::parse($dependentTask->startdate);
                if ($oldStartdate < $newStartdate) {
                    $dateDiff = $oldStartdate->diffInDays($newStartdate);
                    $relatedTask->startdate = $newStartdate;
                    $relatedTask->enddate = $oldEnddate->addDays($dateDiff);
                    $relatedTask->save();
                }
                break;
            case 'SF (Start-to-Finish)':
                // Quan hệ SF: công việc liên quan không thể kết thúc cho đến khi công việc phụ thuộc bắt đầu.
                $newEnddate = Carbon::parse($dependentTask->startdate);
                if ($oldEnddate < $newEnddate) {
                    $dateDiff = $oldEnddate->diffInDays($newEnddate);
                    $relatedTask->startdate = $oldStartdate->subDays($dateDiff);
                    $relatedTask->enddate = $newEnddate;
                    $relatedTask->save();
                }
                break;
            case 'FF (Finish-to-Finish)':
                // Quan hệ FF: công việc liên quan không thể kết thúc cho đến khi công việc phụ thuộc hoàn thành.
                $newEnddate = Carbon::parse($dependentTask->enddate);
                if ($oldEnddate < $newEnddate) {
                    $dateDiff = $oldEnddate->diffInDays($newEnddate);
                    $relatedTask->startdate = $oldStartdate->subDays($dateDiff);
                    $relatedTask->enddate = $newEnddate;
                    $relatedTask->save();
                }
                break;
        }
                // Cập nhật các công việc khác liên kết với công việc liên quan vừa được cập nhật
                $taskLinks = TaskLink::where('dependent_task_id', $relatedTaskId)
                ->where('dependent_task_table', $relatedTaskTable)
                ->get();
                foreach ($taskLinks as $taskLink) {
                    $this->capNhatNgayTheoQuanHe($taskLink->relationship_type, $taskLink->dependent_task_id, $taskLink->dependent_task_table, $taskLink->related_task_id, $taskLink->related_task_table);
                }
                
    }
    public function capNhatCacCongViecCon($parentTask, $taskType) {
        $congViecCon = $this->layCacCongViecCon($parentTask->id, $taskType);
        $oldStartdate = $parentTask->startdate;
        $oldEnddate = $parentTask->enddate;
        foreach ($congViecCon as $task) {
            // Lưu lại chênh lệch ngày bắt đầu và kết thúc giữa công việc cha cũ và con
            $startDiff = Carbon::parse($task->startdate)->diffInDays($oldStartdate);
            $endDiff = Carbon::parse($task->enddate)->diffInDays($oldEnddate);
    
            // Cập nhật ngày bắt đầu và kết thúc của công việc con dựa trên công việc cha mới và chênh lệch đã được lưu
            $task->startdate = Carbon::parse($parentTask->startdate)->addDays($startDiff);
            $task->enddate = Carbon::parse($parentTask->enddate)->addDays($endDiff);
            $task->save();
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
