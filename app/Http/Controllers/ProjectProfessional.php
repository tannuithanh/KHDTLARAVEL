<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ProjectPro;
use Illuminate\Http\Request;
use App\Models\projectprochild1;
use App\Models\projectprochild2;
use Illuminate\Support\Facades\Auth;

class ProjectProfessional extends Controller
{
    public function listProfessional(){
        $ngayHienTai = date('Y-m-d');
        $user = Auth::user();
        $projectpro = ProjectPro::with('user', 'department')->get();
        // dd($projectpro->toArray());
        return view('Project Professional.listProfessional', compact('user','projectpro','ngayHienTai'));
    }
//------ DANH SÁCH DỰ ÁN CON LV1 ----//
    public function listProChild1($id){
        $ngayHienTai = date('Y-m-d');
        $projectpro = ProjectPro::with('user', 'department')->where('id', $id)->first();
        $projectprochild1 = projectprochild1::with('user', 'department')->where('projectpro_id', $id)->get();
        $userAll = User::with('department')->get();
        $user = Auth::user();
        return view('Project Professional.listProjectChild1',compact('user','projectpro','userAll','projectprochild1','ngayHienTai'));
    }
//------ DANH SÁCH DỰ ÁN CON LV2 ----//
    public function listProChild2($id){
        $user = Auth::user();
        $ngayHienTai = date('Y-m-d');
        $projectprochild1 = projectprochild1::with('user', 'department')->where('id', $id)->first();

        $projectprochild2 = projectprochild2::with('user', 'department')->where('projectprochild1_id', $id)->get();
        $userAll = User::with('department')->where('department_id',$user->department_id)->orWhere('department_id',$user->department_id1)->get();
       
        return view('Project Professional.listProjectChild2',compact('user','projectprochild2','userAll','projectprochild1','ngayHienTai'));
    }
//------ THÊM DỰ ÁN ---- //
    public function insertPP(request $request){
        $user = auth::user(); 
        $project = ProjectPro::create([
            'name' => $request->input('name'),
            'department_id' => $user->department_id,
            'user_id' => $user->id,
            'startdate' => $request->input('startdate'),
            'enddate' => $request->input('enddate'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return response()->json(['success' => 'Project created successfully.', 'project' => $project], 201);
    }
//------ THÊM CÔNG VIỆC CHILD 1 ----//
    public function insertWorkChild(request $request){
        $userById = User::find($request->input('user_id')); // Lấy đối tượng User dựa trên $id hoặc sử dụng phương thức userById($id) của bạn
        $departmentId = $userById->department_id;
        $projectChild1 = projectprochild1::create([
            'name' => $request->input('name'),
            'projectpro_id'=> $request->input('projectpro_id'),
            'department_id' => $departmentId,
            'user_id' => $request->input('user_id'),
            'startdate' => $request->input('startDate'),
            'enddate' => $request->input('endDate'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return response()->json(['success' => 'Project created successfully.', 'projectChild1' => $projectChild1], 201);
    }

//---- CẬP NHẬT KẾT QUẢ ----//
    public function updatePP(request $request){
        $id = $request->id;
        $value = $request->value;
        
        // Cập nhật giá trị completion cho projectprochild1
        $projectChild = ProjectProChild1::find($id);
        $projectChild->completion = round($value / 2) * 2; // làm tròn đến số chẵn gần nhất
        $projectChild->save();
    
        // Tính toán giá trị completion mới cho projectpro
        $projectPro = $projectChild->projectPro;
        $totalCompletion = 0;
        foreach ($projectPro->projectProChild1s as $child) {
            $totalCompletion += $child->completion;
        }
    
        // Đảm bảo completion của projectPro là một số chẵn
        $averageCompletion = round($totalCompletion / $projectPro->projectProChild1s->count());
        $averageCompletion = round($averageCompletion / 2) * 2; // làm tròn đến số chẵn gần nhất
    
        // Cập nhật completion cho projectpro
        $projectPro->completion = $averageCompletion;
        $projectPro->save();
    
        return response()->json(['message' => 'Cập nhật thành công!'], 200);
    }

//---- CẬP NHẬT GHI CHÚ ----//
    public function notePP(request $request){
        try {
            $project = ProjectProChild1::findOrFail($request->id);
            $project->update(['note' => $request->note]);
    
            // Trả về response thành công
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật ghi chú thành công!',
                'note' => $request->note
            ], 200);
        } catch (\Exception $e) {
            // Trả về response lỗi
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

//----- XÓA DỰ ÁN -----//
    public function deletePP(Request $request){
        try {
            $project = ProjectProChild1::findOrFail($request->id);
            $project->delete();
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    public function deletePP2(Request $request){
        try {
            $project = ProjectProChild2::findOrFail($request->id);
            $project->delete();
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
//----- SỬA DỰ ÁN -----//
    public function getPP(Request $request) {
        $project = ProjectProChild1::findOrFail($request->id);
        return response()->json($project);
    }
    public function editPP(Request $request){
        $userById = User::find($request->input('responsible'));
        $departmentId = $userById->department_id;
        try {
            $project = ProjectProChild1::findOrFail($request->input('id'));
            $project->name = $request->name;
            $project->user_id = $request->input('responsible');
            $project->department_id = $departmentId;
            $project->startDate = $request->startDate;
            $project->endDate = $request->endDate;
            $project->save();
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
//------ THÊM CÔNG VIỆC CHILD 2 ----//
    public function insertWorkChild2(request $request){
        $userById = User::find($request->input('user_id')); // Lấy đối tượng User dựa trên $id hoặc sử dụng phương thức userById($id) của bạn
        $departmentId = $userById->department_id;
        $projectChild2 = projectprochild2::create([
            'name' => $request->input('name'),
            'projectprochild1_id'=> $request->input('projectprochild1'),
            'department_id' => $departmentId,
            'user_id' => $request->input('user_id'),
            'startdate' => $request->input('startDate'),
            'enddate' => $request->input('endDate'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => 'Project created successfully.', 'projectChild2' => $projectChild2], 201);
    }
//----- CẬP NHẬT KẾT QUẢ ----// 
    public function updatePP2(request $request){
            $id = $request->id;
            $value = $request->value;
            $projectChild2 = ProjectProChild2::find($id);
            $projectChild2->completion = $value;
            $projectChild2->save();
            $projectChild1 = $projectChild2->projectProChild1;
            $totalCompletion = 0;
            foreach ($projectChild1->projectProChild2s as $child2) {
                $totalCompletion += $child2->completion;
            }
            $averageCompletion = round($totalCompletion / $projectChild1->projectProChild2s->count() / 2) * 2;
            $projectChild1->completion = $averageCompletion;
            $projectChild1->save();
            $projectChild1->projectPro->updateCompletion();

            return response()->json(['message' => 'Updated successfully!'], 200);
    }
//---- CẬP NHẬT GHI CHÚ ----//
    public function notePP2(request $request){
        try {
            $project = ProjectProChild2::findOrFail($request->id);
            $project->update(['note' => $request->note]);

            // Trả về response thành công
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật ghi chú thành công!',
                'note' => $request->note
            ], 200);
        } catch (\Exception $e) {
            // Trả về response lỗi
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
//---- SỬA DỰ ÁN 2 -----//
    public function getPP2(request $request){
        $project = ProjectProChild2::findOrFail($request->id);
        return response()->json($project);
    }
    public function editPP2(request $request){
        $userById = User::find($request->input('responsible'));
        $departmentId = $userById->department_id;
        try {
            $project = ProjectProChild2::findOrFail($request->input('id'));
            $project->name = $request->name;
            $project->user_id = $request->input('responsible');
            $project->department_id = $departmentId;
            $project->startDate = $request->startDate;
            $project->endDate = $request->endDate;
            $project->save();
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
