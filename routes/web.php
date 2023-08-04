<?php

use App\Http\Controllers\Login;
use App\Http\Controllers\TacVu;
use App\Http\Controllers\Logout;
use App\Http\Controllers\Profile;
use App\Http\Controllers\dashboard;
use App\Http\Controllers\ReportPlan;
use App\Http\Controllers\ChartGoogle;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkPlanWeek;
use App\Http\Controllers\setting\Teams;
use App\Http\Controllers\setting\Users;
use App\Http\Controllers\WorkPlanDaily;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\notifacecation;
use App\Http\Controllers\TaoLichLamViec;
use App\Http\Controllers\ProjecManagement;
use App\Http\Controllers\ApproveDaiLyWeekly;
use App\Http\Controllers\ProjectProfessional;
use App\Http\Controllers\setting\Departments;

Route::get('/', function () {
    return redirect(route('LoginGet'));
});


//------------------------------------------ ĐĂNG NHẬP --------------------------------------//

Route::get('/login', [Login::class, 'loginGet'])->name('LoginGet')->middleware('checkUser');
Route::post('/login', [Login::class, 'loginPost'])->name('LoginPost');
Route::get('/back', [Login::class, 'back'])->name('back');

//------------------------------------------ QUÊN MẬT KHẨU --------------------------------------//
Route::get('/Recover-PassWord', [Login::class, 'Recover'])->name('recover')->middleware('checkUser');
Route::post('/Recover-PassWord', [Login::class, 'RecoverPost'])->name('recoverPost')->middleware('checkUser');

//------------------------------------------ THAY ĐỔI MẬT KHẨU --------------------------------------//
Route::get('/reset-PassWord', [Login::class, 'Reset'])->name('Reset')->middleware('checkUser');
Route::post('/reset-PassWord', [Login::class, 'ResetPost'])->name('ResetPost')->middleware('checkUser');


//------------------------------------------ Đăng xuất --------------------------------------//
Route::get('/logout', [Logout::class, 'logout'])->name('Logout');


//------------------------------------------ Thông tin cá nhân --------------------------------------//
Route::middleware('checkLogin')->prefix('/profile')->group(function () {
    Route::get('/Your-personal-information', [Profile::class, 'profile'])->name('profile');
});

//------------------------------------------ QUẢN LÝ PHÒNG BAN --------------------------------------//
Route::middleware('checkLogin')->prefix('/departments')->group(function () {
    Route::get('/Your-Department-information', [Departments::class, 'listDepartment'])->name('departments.view');
});

//------------------------------------------ QUẢN LÝ NHÂN SỰ --------------------------------------//
Route::middleware('checkLogin')->prefix('/User')->group(function () {
    Route::get('/Your-Users-information', [Users::class, 'listUsers'])->name('listUser.view');
    Route::post('/Your-Users-information', [Users::class, 'searchUsers']);
    //--------------------------------------THÊM NHÂN SỰ --------------------------------------------//
    Route::get('/add-Users', [Users::class, 'addUsers'])->name('addUsers');
    Route::post('/add-Users', [Users::class, 'insertUsers'])->name('insertUsers');

    //--------------------------------------SỬA THÔNG TIN NHÂN SỰ --------------------------------------------//
    Route::get('/edit-Users/{id}', [Users::class, 'editUsers'])->name('editUsers');
    Route::post('/edit-Users/{id}', [Users::class, 'updateUsers'])->name('updateUsers');

    //-------------------------------------- XÓA THÔNG TIN NHÂN SỰ --------------------------------------------//
    Route::Delete('/Delete-Users/{id}', [Users::class, 'deleteUsers'])->name('deleteUsers');
});


//------------------------------------------ QUẢN LÝ NHÓM --------------------------------------//
Route::middleware('checkLogin')->prefix('/Team')->group(function () {
    Route::get('/Your-Teams-information', [Teams::class, 'listTeam'])->name('listTeam.view');
    //--------------------------------------THÊM NHÓM --------------------------------------------//
    Route::get('/add-Teams', [Teams::class, 'addTeams'])->name('addTeams');
    Route::post('/add-Teams', [Teams::class, 'creatTeams'])->name('addTeams.post');

    //--------------------------------------XÓA NHÓM --------------------------------------------//
    Route::Delete('/delete/{id}', [Teams::class, 'deleteTeam'])->name('deleteTeam');

    //--------------------------------------SỬA NHÓM --------------------------------------------//
    Route::get('/edit-Team/{id}', [Teams::class, 'editTeam'])->name('editTeam');
    Route::post('/edit-Team/{id}', [Teams::class, 'updateTeam'])->name('updateTeam');
});



//------------------------------------------ DASHBOARD --------------------------------------//
Route::get('/dashboard', [Dashboard::class, 'dashboardGet'])->name('DashBoard')->middleware('checkLogin');




//------------------------------------------ QUẢN LÝ KẾ HOẠCH TUẦN --------------------------------------//
 //-------------------------------------- DUYỆT VÀ KIỂM TRA --------------------------------------------//
    Route::middleware('checkLogin')->prefix('/Work-Weeko')->group(function () {
        Route::get('/Approve-Week', [ApproveDaiLyWeekly::class, 'viewApproveWeek'])->name('viewApproveWeek');
        Route::Post('/Approve-Week', [ApproveDaiLyWeekly::class, 'viewApproveWeekPost'])->name('viewApproveWeekPost');

        Route::get('/deny-week', [ApproveDaiLyWeekly::class, 'viewDenyWeek'])->name('viewDenyWeek');
        Route::Post('/deny-week', [ApproveDaiLyWeekly::class, 'viewDenyWeekPost'])->name('viewDenyWeekPost');
        
        Route::get('/chart-week', [ApproveDaiLyWeekly::class, 'ChartWeek'])->name('ChartWeek');

        Route::POST('/WeekAprroveTN', [ApproveDaiLyWeekly::class, 'WeekAprroveTN'])->name('WeekAprroveTN');
        Route::POST('/WeekdenyTN', [ApproveDaiLyWeekly::class, 'WeekdenyTN'])->name('WeekdenyTN');
        Route::POST('/WeekaprroveTP', [ApproveDaiLyWeekly::class, 'WeekaprroveTP'])->name('WeekaprroveTP');
        Route::POST('/WeedenyTP', [ApproveDaiLyWeekly::class, 'WeedenyTP'])->name('WeedenyTP');
    });
//--------------------------------------Danh sách --------------------------------------------//
    Route::middleware('checkLogin')->prefix('/plan')->group(function () {
        Route::get('/workWeek', [WorkPlanWeek::class, 'viewListWorkWeek'])->name('listWorkWeek');
        Route::post('/workWeek', [WorkPlanWeek::class, 'searchListWork'])->name('searchlistWorkWeek');
        //-------------------------------------- PHẢN HỒI TRẢ JSON VỀ AJAX  --------------------------------------------//    
        Route::get('/workWeek/departments', [WorkPlanWeek::class, 'getDepartments'])->name('listWorkWeekdepartments');;
        Route::get('/workWeek/users', [WorkPlanWeek::class, 'getUsers'])->name('listWorkWeekUsers');;
        //-------------------------------------- PHẢN HỒI TRẢ JSON VỀ AJAX LÝ DO --------------------------------------------//  
        Route::post('/update-reason', [WorkPlanWeek::class, 'updateReason'])->name('updateReason');

        //-------------------------------------- PHẢN HỒI TRẢ JSON VỀ ĐỒNG Ý LÝ DO --------------------------------------------//  
        Route::post('/accept-reason', [WorkPlanWeek::class, 'acceptReason'])->name('acceptReason');
        //-------------------------------------- PHẢN HỒI TRẢ JSON VỀ TỪ CHỐI LÝ DO --------------------------------------------//  
        Route::post('/deny-reason', [WorkPlanWeek::class, 'denyReason'])->name('denyReason');
    });

//-------------------------------------- TẠO/XÓA/SỬA KẾ HOẠCH  --------------------------------------------//    
    Route::middleware('checkLogin')->prefix('/creat')->group(function () {

        //-------------------------------------- TẠO KẾ HOẠCH TUẦN  --------------------------------------------//
        Route::get('/choosedate', [WorkPlanWeek::class, 'chooseDate'])->name('chooseDate.get');
        Route::POST('/choosedate', [WorkPlanWeek::class, 'showWeekdays'])->name('showWeekdays.get');


        Route::get('/creatWorkWeek', [WorkPlanWeek::class, 'creatWorkWeek'])->name('creatWorkWeek.get');
        Route::post('/creatWorkWeek', [WorkPlanWeek::class, 'insertWorkWeek']);
        //-------------------------------------- XÓA KẾ HOẠCH TUẦN  --------------------------------------------//
        Route::post('/deleteWorkWeek', [WorkPlanWeek::class, 'deleteWorkWeek'])->name('deleteWorkWeek');

        //-------------------------------------- SỬA KẾ HOẠCH TUẦN  --------------------------------------------//
        Route::get('/editWorkWeek/{id}', [WorkPlanWeek::class, 'editWorkWeek'])->name('editWorkWeek');
        Route::post('/editWorkWeek/{id}', [WorkPlanWeek::class, 'updateWorkWeek'])->name('updateWorkWeekEdit');

        //-------------------------------------- CẬP NHẬT KẾ HOẠCH TUẦN  --------------------------------------------//
        Route::get('/updateWorkWeek/{id}', [WorkPlanWeek::class, 'updateWorkWeekGet'])->name('updateWorkWeek');
        Route::post('/updateWorkWeek/{id}', [WorkPlanWeek::class, 'updateWorkWeekPost'])->name('updateWorkWeekpost');
    });




//------------------------------------------ QUẢN LÝ KẾ HOẠCH NGÀY --------------------------------------//
    //-------------------------------------- DUYỆT VÀ KIỂM TRA --------------------------------------------//
    Route::middleware('checkLogin')->prefix('/Work-Daily')->group(function () {
        Route::get('/approve-daily', [ApproveDaiLyWeekly::class, 'viewApproveDaily'])->name('viewApproveDaily');
        Route::POST('/approve-daily', [ApproveDaiLyWeekly::class, 'viewApproveDailyPost'])->name('viewApproveDailyPost');
        Route::get('/deny-daily', [ApproveDaiLyWeekly::class, 'viewDenyDaily'])->name('viewDenyDaily');
        Route::Post('/deny-daily', [ApproveDaiLyWeekly::class, 'viewDenyDailyPost'])->name('viewDenyDailyPost');
        Route::POST('/aprrovetruongphong', [ApproveDaiLyWeekly::class, 'aprroveTP'])->name('aprroveTP');
        Route::POST('/denyTP', [ApproveDaiLyWeekly::class, 'denyTP'])->name('denyTP');
        Route::POST('/aprroveTN', [ApproveDaiLyWeekly::class, 'aprroveTN'])->name('aprroveTN');
        Route::POST('/denyTN', [ApproveDaiLyWeekly::class, 'denyTN'])->name('denyTN');
    });
    

Route::middleware('checkLogin')->prefix('/Work-Plan-Daily')->group(function () {
    Route::get('/List-Work-Daily', [WorkPlanDaily::class, 'viewListWorkDaily'])->name('listWorkDaily');
    Route::post('/List-Work-Daily', [WorkPlanDaily::class, 'searchWorkDaily'])->name('searchWorkDaily');
});


//-------------------------------------- TẠO CÔNG VIỆC NGÀY  --------------------------------------------//    
Route::middleware('checkLogin')->prefix('/Creat')->group(function () {
    Route::get('/Creat-Work-Daily', [WorkPlanDaily::class, 'viewCreatWorkDaily'])->name('creatWorkDaily.get');
    Route::post('/Creat-Work-Daily', [WorkPlanDaily::class, 'insertWorkDaily'])->name('creatWorkDaily.post');
    Route::post('/Checktime', [WorkPlanDaily::class, 'checktime'])->name('checktime');
    Route::get('/Assign-Work-Daily', [WorkPlanDaily::class, 'assignCreatWorkDaily'])->name('assignCreatWorkDaily.get');
    Route::post('/Assign-Work-Daily', [WorkPlanDaily::class, 'assignCreatWorkDailyPost'])->name('assignCreatWorkDaily.post');
    //-------------------------------------- NÚT TÌM KIẾM BẰNG AJAX HIHI  --------------------------------------------//    
    Route::get('/workDaily/departments', [WorkPlanDaily::class, 'getDepartments'])->name('listWorkDailydepartments');;
    Route::get('/workDaily/users', [WorkPlanDaily::class, 'getUsers'])->name('listWorkDailyUsers');;
});
//-------------------------------------- CẬP NHẬT CÔNG VIỆC NGÀY LẤY TỪ KẾ HOẠCH TUẦN  ------------------//    
Route::middleware('checkLogin')->prefix('/Update-WorkDaily-From-WorkWeek')->group(function () {
    Route::get('/Update-WorkDaily/{id}', [WorkPlanDaily::class, 'updateWorkDaily'])->name('updateWorkDaily.get');
    Route::post('/Update-WorkDaily/{id}', [WorkPlanDaily::class, 'updateWorkDailyPost'])->name('updateWorkDaily.Post');
});
//-------------------------------------- CHỈNH SỬA CÔNG VIỆC NGÀY  ------------------//    
Route::middleware('checkLogin')->prefix('/Edit-WorkDaily-From-WorkWeek')->group(function () {
    Route::get('/edit-WorkDaily/{id}', [WorkPlanDaily::class, 'editWorkDailyGet'])->name('editWorkDaily.get');
    Route::post('/edit-WorkDaily/{id}', [WorkPlanDaily::class, 'editWorkDailyPost'])->name('editWorkDaily.Post');
});
//-------------------------------------- XÓA CÔNG VIỆC NGÀY  ------------------//      
Route::POST('/Delete-WorkDaily', [WorkPlanDaily::class, 'deleteWorkDaily'])->name('deleteWorkDaily');





//------------------------------------------ BÁO CÁO KẾ HOẠCH --------------------------------------//

//--------------------------------------Danh sách --------------------------------------------//
Route::middleware('checkLogin')->prefix('/report')->group(function () {
    Route::get('/reportWeekly', [ReportPlan::class, 'listReportWeekly'])->name('listReportWeekly');
    Route::post('/reportWeekly', [ReportPlan::class, 'SearchlistReportWeekly'])->name('SearchlistReportWeekly');
    Route::get('/reportDaily', [ReportPlan::class, 'listReportDaily'])->name('listReportDaily');
    Route::post('/reportDaily', [ReportPlan::class, 'SearchlistReportDaily'])->name('SearchlistReportDaily');


    //--------------------------------------BÁO CÁO --------------------------------------------//
    Route::get('/formReportWeekly/{id}', [ReportPlan::class, 'formReportWeekly'])->name('formReportWeekly');
    Route::POST('/formReportWeekly/{id}', [ReportPlan::class, 'reportWeekly'])->name('reportWeekly');

    Route::get('/Report-Daily/{id}', [ReportPlan::class, 'formReportDaily'])->name('reportDaily.get');
    Route::POST('/Report-Daily/{id}', [ReportPlan::class, 'reportDaily'])->name('reportDaily.post');

    //--------------------------------------TẢI FILE --------------------------------------------//
    Route::get('/download/{file}', [ReportPlan::class, 'download'])->name('reportWeekly.download');

    //-------------------------------------- GỞI MAIL --------------------------------------------//
    Route::post('/sendmail', [ReportPlan::class, 'sendmail'])->name('sendmail');
});




//------- QUẢN LÝ KẾ HOẠCH THÁNG -----//
    Route::middleware('checkLogin')->prefix('/WorkMonth')->group(function () {
        Route::get('/approve-Month', [ApproveDaiLyWeekly::class, 'viewApproveMonth'])->name('viewApproveMonth');
        Route::post('/approve-Month', [ApproveDaiLyWeekly::class, 'viewApproveMonthPost'])->name('viewApproveMonthPost');

        Route::get('/deny-Month', [ApproveDaiLyWeekly::class, 'viewDenyMonth'])->name('viewDenyMonth');
        Route::post('/deny-Month', [ApproveDaiLyWeekly::class, 'viewDenyMonthPost'])->name('viewDenyMonthPost');

        Route::get('/list-Month', [ApproveDaiLyWeekly::class, 'listStartMonth'])->name('listStartMonth');
        Route::Post('/list-Month', [ApproveDaiLyWeekly::class, 'listStartMonthPost'])->name('listStartMonthPost');

        Route::get('/report-Month', [ApproveDaiLyWeekly::class, 'listReportMonth'])->name('listReportMonth');
        Route::Post('/report-Month', [ApproveDaiLyWeekly::class, 'listReportMonthPost'])->name('listReportMonthPost');
        Route::POST('/aprroveMonthTP', [ApproveDaiLyWeekly::class, 'aprroveMonthTP'])->name('aprroveMonthTP');
        Route::POST('/denyMonthTP', [ApproveDaiLyWeekly::class, 'denyMonthTP'])->name('denyMonthTP');
        Route::POST('/aprroveMonthTN', [ApproveDaiLyWeekly::class, 'aprroveMonthTN'])->name('aprroveMonthTN');
        Route::POST('/denyMonthTN', [ApproveDaiLyWeekly::class, 'denyMonthTN'])->name('denyMonthTN');

        Route::get('/chart-Month', [ApproveDaiLyWeekly::class, 'ChartMonth'])->name('ChartMonth');
    });
    //-------------------------------------- TẠO CÔNG VIỆC THÁNG  --------------------------------------------//    
    Route::middleware('checkLogin')->prefix('/Creat')->group(function () {
        Route::get('/Creat-Work-Month', [ApproveDaiLyWeekly::class, 'viewCreatWorkMonth'])->name('creatWorkMonth');
        Route::POST('/Creat-Work-Month', [ApproveDaiLyWeekly::class, 'InsertWorkMonth'])->name('InsertWorkMonth');
    });
    //-------------------------------------- CHỈNH SỬA-------------------------------//
    Route::middleware('checkLogin')->prefix('/Edit-WorkMonth-From-WorkWeek')->group(function () {
        Route::get('/edit-WorkMonth/{id}', [ApproveDaiLyWeekly::class, 'editWorkMonthGet'])->name('editWorkMonth.get');
        Route::post('/edit-WorkMonth/{id}', [ApproveDaiLyWeekly::class, 'editWorkMonthPost'])->name('editWorkMonth.Post');
    });
     //-------------------------------------- XÓA CÔNG VIỆC THÁNG -------------------------------//
     Route::middleware('checkLogin')->prefix('/Delete-WorkMonth')->group(function () {
        Route::post('/delete-WorkMonth', [ApproveDaiLyWeekly::class, 'DeletetWorkMonth'])->name('DeletetWorkMonth');
    });
    //--------------------------------- BÁO CÁO ---------------------------------------//
    Route::get('/Report-Month/{id}', [ReportPlan::class, 'formReportMonth'])->name('reportMonth.get');
    Route::POST('/Report-Month/{id}', [ReportPlan::class, 'formReportMonthPost'])->name('reportMonth.post');

    //------------------- Tìm kiếm nhóm người dùng và phòng ban --------------//
    Route::get('/department/{id}/teams', [ApproveDaiLyWeekly::class, 'getTeams'])->name('getTeamByDP');
    Route::get('/department/{id}/users', [ApproveDaiLyWeekly::class, 'getDepartmentUsers'])->name('getTeamByUser');
    Route::get('/team/{id}/users', [ApproveDaiLyWeekly::class, 'getTeamUsers'])->name('getUserByTeams');
    



//------------------------------------------ QUẢN LÝ DỰ ÁN XE--------------------------------------//

// 1. -------------------------------------- DANH SÁCH DỰ ÁN --------------------------------------------//    
Route::middleware('checkLogin')->prefix('/Project-Managerment')->group(function () {
    Route::get('/listCarBrands', [ProjecManagement::class, 'listCarBrands'])->name('listCarBrands');
    Route::get('/List-Project-Management/{id}', [ProjecManagement::class, 'listProjectManagement'])->name('listProjectManagerment');
    Route::get('Project-Connect/{id}', [ProjecManagement::class, 'ProjectConnectView'])->name('projectConnect');
    Route::get('Project-con/{id}', [ProjecManagement::class, 'ProjectCon'])->name('ProjectCon');
    Route::get('/List-Project-Management-child/{car_brands_id}/{car_brands_child_id}', [ProjecManagement::class, 'listProjectManagementChild'])->name('listProjectManagementChild');
});

// 2. -------------------------------------- TẠO DỰ ÁN --------------------------------------------//    
Route::middleware('checkLogin')->prefix('/Creat-Project')->group(function () {
    Route::get('Creat-Projec-Form/{id}/{car_brands_child_id?}', [ProjecManagement::class, 'formCreatProject'])->name('creatProject.get')->where(['id' => '[0-9]+', 'car_brands_child_id' => '[0-9]+']);
    Route::post('Creat-Projec-Form/{id}/{car_brands_child_id?}', [ProjecManagement::class, 'insertCreatProject'])->name('creatProject.post')->where(['id' => '[0-9]+', 'car_brands_child_id' => '[0-9]+']);
});

// 3. -------------------------------------- XÓA DỰ ÁN  --------------------------------------------//   
Route::Delete('/Delete-projec/{id}', [ProjecManagement::class, 'deleteProject'])->name('deleteProject');
Route::delete('/project-department/{id}', [ProjecManagement::class, 'destroy'])->name('destroy');
Route::delete('/project-work/{id}', [ProjecManagement::class, 'deleteWork'])->name('deleteWork');
Route::delete('/project-Lv4/{id}', [ProjecManagement::class, 'deleteLv4'])->name('deleteLv4');


// 4.-------------------------------------- Cập nhật dự án  --------------------------------------------//   
    Route::put('/lock/{id}', [ProjecManagement::class, 'lock'])->name('lock');
    Route::put('/unlock/{id}', [ProjecManagement::class, 'unlock'])->name('unlock');
    Route::post('/updateProjectStatus', [ProjecManagement::class, 'updateStatus'])->name('update.status');
    Route::post('import-excel', [ProjecManagement::class, 'importExcel'])->name('importExcel');;
    Route::post('import-Handmade', [ProjecManagement::class, 'importHandmade'])->name('importHandmade');
    Route::post('import-Handmade-Lv4', [ProjecManagement::class, 'importHandmadeLv4'])->name('importHandmadeLv4');
    Route::post('import-excel-lv4', [ProjecManagement::class, 'importExcelLv4'])->name('importExcelLv4');
    Route::get('download-temp-file/{fileName}', [ProjecManagement::class, 'downloadTempFile'])->name('downloadTempFile');
    Route::post('/project-department', [ProjecManagement::class, 'store'])->name('store');


// 5 .-------------------------------------- CẬP NHẬT TIẾN ĐỘ CÔNG VIỆC  --------------------------------------------//   
Route::post('update-result-project-connect', [ProjecManagement::class, 'updateResult'])->name('updateResult');
Route::post('update-result-project-con', [ProjecManagement::class, 'updateResultCon'])->name('updateResultCon');
Route::post('update-result-project-lv4', [ProjecManagement::class, 'updateResultLv4'])->name('updateResultLv4');

// 6.----------------------------------------- GHI CHÚ ----------------------------------------------------------------//
Route::post('/save-note-Project', [ProjecManagement::class, 'saveNoteProject'])->name('saveNoteProject');
Route::post('/save-note', [ProjecManagement::class, 'saveNote'])->name('savenote');
Route::post('/save-note-Lv4', [ProjecManagement::class, 'saveNoteLv4'])->name('saveNoteLv4');
        


//------------------------------------------ QUẢN LÝ DỰ ÁN KHỐI NGHIỆP VỤ--------------------------------------//
    // 1. -------------------------------------- DANH SÁCH DỰ ÁN --------------------------------------------//    
        Route::middleware('checkLogin')->prefix('/Project-Professional')->group(function () {
            Route::get('/List-Project', [ProjectProfessional::class, 'listProfessional'])->name('listProfessional');
            Route::get('/List-Project-Child-1/{id}', [ProjectProfessional::class, 'listProChild1'])->name('listProChild1');
            Route::get('/List-Project-Child-2/{id}', [ProjectProfessional::class, 'listProChild2'])->name('listProChild2');
        });
    // 2. -------------------------------------- THÊM DỰ ÁN, CÔNG VIỆC  --------------------------------//
        Route::POST('/add-Project', [ProjectProfessional::class, 'insertPP'])->name('insertPP')->middleware('checkLogin');
        Route::POST('/add-work-Child-1', [ProjectProfessional::class, 'insertWorkChild'])->name('insertWorkChild')->middleware('checkLogin');
        Route::POST('/add-work-Child-2', [ProjectProfessional::class, 'insertWorkChild2'])->name('insertWorkChild2')->middleware('checkLogin');
    // 3. -------------------------------------- CẬP NHẬT KẾT QUẢ, GHI CHÚ --------------------------------//
        Route::POST('/update-work-Child-1', [ProjectProfessional::class, 'updatePP'])->name('updatePP')->middleware('checkLogin');
        Route::POST('/update-work-Child-2', [ProjectProfessional::class, 'updatePP2'])->name('updatePP2')->middleware('checkLogin');
        Route::POST('/note-work-Child-1', [ProjectProfessional::class, 'notePP'])->name('notePP')->middleware('checkLogin');
        Route::POST('/note-work-Child-2', [ProjectProfessional::class, 'notePP2'])->name('notePP2')->middleware('checkLogin');
        Route::POST('/lock-Projectpro', [ProjectProfessional::class, 'lockProjectpro'])->name('lockProjectpro')->middleware('checkLogin');
        Route::POST('/unlock-Projectpro', [ProjectProfessional::class, 'unlockProjectpro'])->name('unlockProjectpro')->middleware('checkLogin');
    // 4. -------------------------------------- XÓA --------------------------------//
        Route::POST('/Delete-projectpro', [ProjectProfessional::class, 'deletePPP'])->name('deletePPP')->middleware('checkLogin');
        Route::POST('/Delete-work-Child-1', [ProjectProfessional::class, 'deletePP'])->name('deletePP')->middleware('checkLogin');
        Route::POST('/Delete-work-Child-2', [ProjectProfessional::class, 'deletePP2'])->name('deletePP2')->middleware('checkLogin');
    // 5. -------------------------------------- SỬA --------------------------------//
        Route::post('/Get-work-Child-1', [ProjectProfessional::class, 'getPP'])->name('getPP')->middleware('checkLogin');
        Route::post('/Edit-work-Child-1', [ProjectProfessional::class, 'editPP'])->name('editPP')->middleware('checkLogin');
        Route::post('/Get-work-Child-2', [ProjectProfessional::class, 'getPP2'])->name('getPP2')->middleware('checkLogin');
        Route::POST('/Edit-work-Child-2', [ProjectProfessional::class, 'editPP2'])->name('editPP2')->middleware('checkLogin');
        
        
//------------------------------------------ TÁC VỤ CHO QUẢN LÝ DỰ án--------------------------------------//
        Route::get('/TAC-VU-LV1/{id}', [TacVu::class, 'TacVuLv1'])->name('TacVuLv1')->middleware('checkLogin');
        Route::get('/TAC-VU-LV2/{id}', [TacVu::class, 'TacVuLv2'])->name('TacVuLv2')->middleware('checkLogin');
        Route::get('/getAllWorks/{id}', [TacVu::class, 'getAllWorks'])->name('getAllWorks')->middleware('checkLogin');
        Route::get('/getAllWorksLv2/{id}', [TacVu::class, 'getAllWorksLv2'])->name('getAllWorksLv2')->middleware('checkLogin');
        Route::POST('/saveTacVu', [TacVu::class, 'saveTacVu'])->name('saveTacVu')->middleware('checkLogin');
        Route::POST('/updateTacVu', [TacVu::class, 'updateTacVu'])->name('updateTacVu')->middleware('checkLogin');
        Route::POST('/deleteTacVu', [TacVu::class, 'deleteTacVu'])->name('deleteTacVu')->middleware('checkLogin');
        Route::POST('/CheckTacVu', [TacVu::class, 'CheckTacVu'])->name('CheckTacVu')->middleware('checkLogin');
        Route::POST('/kiemtraLv4', [TacVu::class, 'kiemtraLv4'])->name('kiemtraLv4')->middleware('checkLogin');
        
//------------------------------------------ LICH LÀM VIỆC--------------------------------------//
        Route::get('/TaoLichLamviec', [TaoLichLamViec::class, 'TaoLichLamViec'])->name('TaoLichLamViec');
        Route::Post('/TaoLichLamviec1', [TaoLichLamViec::class, 'TaoLichLamViec1'])->name('TaoLichLamViec1');





 //-------------------- CHUÔNG THÔNG BÁO -----------------------//
Route::get('/notiface', [notifacecation::class, 'notiface']);




