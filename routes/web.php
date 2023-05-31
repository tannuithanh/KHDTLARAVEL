<?php

use App\Http\Controllers\Login;
use App\Http\Controllers\Logout;
use App\Http\Controllers\Profile;
use App\Http\Controllers\dashboard;
use App\Http\Controllers\ReportPlan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkPlanWeek;
use App\Http\Controllers\setting\Teams;
use App\Http\Controllers\setting\Users;
use App\Http\Controllers\WorkPlanDaily;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProjecManagement;
use App\Http\Controllers\setting\Departments;

Route::get('/', function () {
    return redirect('/login');
});


//------------------------------------------ ĐĂNG NHẬP --------------------------------------//

route::get('/login', [Login::class, 'loginGet'])->name('LoginGet')->middleware('checkUser');
route::post('/login', [Login::class, 'loginPost'])->name('LoginPost');
route::get('/back', [Login::class, 'back'])->name('back');

//------------------------------------------ QUÊN MẬT KHẨU --------------------------------------//
route::get('/Recover-PassWord', [Login::class, 'Recover'])->name('recover')->middleware('checkUser');
route::post('/Recover-PassWord', [Login::class, 'RecoverPost'])->name('recoverPost')->middleware('checkUser');

//------------------------------------------ THAY ĐỔI MẬT KHẨU --------------------------------------//
route::get('/reset-PassWord', [Login::class, 'Reset'])->name('Reset')->middleware('checkUser');
route::post('/reset-PassWord', [Login::class, 'ResetPost'])->name('ResetPost')->middleware('checkUser');


//------------------------------------------ Đăng xuất --------------------------------------//
route::get('/logout', [Logout::class, 'logout'])->name('Logout');


//------------------------------------------ Thông tin cá nhân --------------------------------------//
route::middleware('checkLogin')->prefix('/profile')->group(function () {
    route::get('/Your-personal-information', [Profile::class, 'profile'])->name('profile');
});

//------------------------------------------ QUẢN LÝ PHÒNG BAN --------------------------------------//
route::middleware('checkLogin')->prefix('/departments')->group(function () {
    route::get('/Your-Department-information', [Departments::class, 'listDepartment'])->name('departments.view');
});

//------------------------------------------ QUẢN LÝ NHÂN SỰ --------------------------------------//
route::middleware('checkLogin')->prefix('/User')->group(function () {
    route::get('/Your-Users-information', [Users::class, 'listUsers'])->name('listUser.view');
    route::post('/Your-Users-information', [Users::class, 'searchUsers']);
    //--------------------------------------THÊM NHÂN SỰ --------------------------------------------//
    route::get('/add-Users', [Users::class, 'addUsers'])->name('addUsers');
    route::post('/add-Users', [Users::class, 'insertUsers'])->name('insertUsers');

    //--------------------------------------SỬA THÔNG TIN NHÂN SỰ --------------------------------------------//
    route::get('/edit-Users/{id}', [Users::class, 'editUsers'])->name('editUsers');
    route::post('/edit-Users/{id}', [Users::class, 'updateUsers'])->name('updateUsers');

    //-------------------------------------- XÓA THÔNG TIN NHÂN SỰ --------------------------------------------//
    route::Delete('/Delete-Users/{id}', [Users::class, 'deleteUsers'])->name('deleteUsers');
});


//------------------------------------------ QUẢN LÝ NHÓM --------------------------------------//
route::middleware('checkLogin')->prefix('/Team')->group(function () {
    route::get('/Your-Teams-information', [Teams::class, 'listTeam'])->name('listTeam.view');
    //--------------------------------------THÊM NHÓM --------------------------------------------//
    route::get('/add-Teams', [Teams::class, 'addTeams'])->name('addTeams');
    route::post('/add-Teams', [Teams::class, 'creatTeams'])->name('addTeams.post');

    //--------------------------------------XÓA NHÓM --------------------------------------------//
    route::Delete('/delete/{id}', [Teams::class, 'deleteTeam'])->name('deleteTeam');

    //--------------------------------------SỬA NHÓM --------------------------------------------//
    route::get('/edit-Team/{id}', [Teams::class, 'editTeam'])->name('editTeam');
    route::post('/edit-Team/{id}', [Teams::class, 'updateTeam'])->name('updateTeam');
});



//------------------------------------------ DASHBOARD --------------------------------------//
route::get('/dashboard', [Dashboard::class, 'dashboardGet'])->name('DashBoard')->middleware('checkLogin');




//------------------------------------------ QUẢN LÝ KẾ HOẠCH TUẦN --------------------------------------//

//--------------------------------------Danh sách --------------------------------------------//
route::middleware('checkLogin')->prefix('/plan')->group(function () {
    route::get('/workWeek', [WorkPlanWeek::class, 'viewListWorkWeek'])->name('listWorkWeek');
    route::post('/workWeek', [WorkPlanWeek::class, 'searchListWork'])->name('searchlistWorkWeek');
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
route::middleware('checkLogin')->prefix('/creat')->group(function () {

    //-------------------------------------- TẠO KẾ HOẠCH TUẦN  --------------------------------------------//
    route::get('/choosedate', [WorkPlanWeek::class, 'chooseDate'])->name('chooseDate.get');
    route::POST('/choosedate', [WorkPlanWeek::class, 'showWeekdays'])->name('showWeekdays.get');


    route::get('/creatWorkWeek', [WorkPlanWeek::class, 'creatWorkWeek'])->name('creatWorkWeek.get');
    route::post('/creatWorkWeek', [WorkPlanWeek::class, 'insertWorkWeek']);
    //-------------------------------------- XÓA KẾ HOẠCH TUẦN  --------------------------------------------//
    Route::delete('/deleteWorkWeek/{id}', [WorkPlanWeek::class, 'deleteWorkWeek'])->name('deleteWorkWeek');

    //-------------------------------------- SỬA KẾ HOẠCH TUẦN  --------------------------------------------//
    Route::get('/editWorkWeek/{id}', [WorkPlanWeek::class, 'editWorkWeek'])->name('editWorkWeek');
    Route::post('/editWorkWeek/{id}', [WorkPlanWeek::class, 'updateWorkWeek'])->name('updateWorkWeek');

    //-------------------------------------- CẬP NHẬT KẾ HOẠCH TUẦN  --------------------------------------------//
    Route::get('/updateWorkWeek/{id}', [WorkPlanWeek::class, 'updateWorkWeekGet'])->name('updateWorkWeek');
    Route::post('/updateWorkWeek/{id}', [WorkPlanWeek::class, 'updateWorkWeekPost'])->name('updateWorkWeekpost');
});




//------------------------------------------ QUẢN LÝ KẾ HOẠCH NGÀY --------------------------------------//

route::middleware('checkLogin')->prefix('/Work-Plan-Daily')->group(function () {
    route::get('/List-Work-Daily', [WorkPlanDaily::class, 'viewListWorkDaily'])->name('listWorkDaily');
    route::post('/List-Work-Daily', [WorkPlanDaily::class, 'searchWorkDaily'])->name('searchWorkDaily');
});


//-------------------------------------- TẠO CÔNG VIỆC NGÀY  --------------------------------------------//    
route::middleware('checkLogin')->prefix('/Creat')->group(function () {
    route::get('/Creat-Work-Daily', [WorkPlanDaily::class, 'viewCreatWorkDaily'])->name('creatWorkDaily.get');
    route::post('/Creat-Work-Daily', [WorkPlanDaily::class, 'insertWorkDaily'])->name('creatWorkDaily.post');

    route::get('/Assign-Work-Daily', [WorkPlanDaily::class, 'assignCreatWorkDaily'])->name('assignCreatWorkDaily.get');
    route::post('/Assign-Work-Daily', [WorkPlanDaily::class, 'assignCreatWorkDailyPost'])->name('assignCreatWorkDaily.post');
    //-------------------------------------- NÚT TÌM KIẾM BẰNG AJAX HIHI  --------------------------------------------//    
    Route::get('/workDaily/departments', [WorkPlanDaily::class, 'getDepartments'])->name('listWorkDailydepartments');;
    Route::get('/workDaily/users', [WorkPlanDaily::class, 'getUsers'])->name('listWorkDailyUsers');;
});
//-------------------------------------- CẬP NHẬT CÔNG VIỆC NGÀY LẤY TỪ KẾ HOẠCH TUẦN  ------------------//    
route::middleware('checkLogin')->prefix('/Update-WorkDaily-From-WorkWeek')->group(function () {
    route::get('/Update-WorkDaily/{id}', [WorkPlanDaily::class, 'updateWorkDaily'])->name('updateWorkDaily.get');
    route::post('/Update-WorkDaily/{id}', [WorkPlanDaily::class, 'updateWorkDailyPost'])->name('updateWorkDaily.Post');
});
//-------------------------------------- CHỈNH SỬA CÔNG VIỆC NGÀY  ------------------//    
route::middleware('checkLogin')->prefix('/Edit-WorkDaily-From-WorkWeek')->group(function () {
    route::get('/edit-WorkDaily/{id}', [WorkPlanDaily::class, 'editWorkDailyGet'])->name('editWorkDaily.get');
    route::post('/edit-WorkDaily/{id}', [WorkPlanDaily::class, 'editWorkDailyPost'])->name('editWorkDaily.Post');
});
//-------------------------------------- XÓA CÔNG VIỆC NGÀY  ------------------//      
route::Delete('/Delete-WorkDaily/{id}', [WorkPlanDaily::class, 'deleteWorkDaily'])->name('deleteWorkDaily');





//------------------------------------------ BÁO CÁO KẾ HOẠCH --------------------------------------//

//--------------------------------------Danh sách --------------------------------------------//
route::middleware('checkLogin')->prefix('/report')->group(function () {
    route::get('/reportWeekly', [ReportPlan::class, 'listReportWeekly'])->name('listReportWeekly');
    route::post('/reportWeekly', [ReportPlan::class, 'SearchlistReportWeekly'])->name('SearchlistReportWeekly');
    route::get('/reportDaily', [ReportPlan::class, 'listReportDaily'])->name('listReportDaily');
    route::post('/reportDaily', [ReportPlan::class, 'SearchlistReportDaily'])->name('SearchlistReportDaily');


    //--------------------------------------BÁO CÁO --------------------------------------------//
    route::get('/formReportWeekly/{id}', [ReportPlan::class, 'formReportWeekly'])->name('formReportWeekly');
    route::POST('/formReportWeekly/{id}', [ReportPlan::class, 'reportWeekly'])->name('reportWeekly');

    route::get('/Report-Daily/{id}', [ReportPlan::class, 'formReportDaily'])->name('reportDaily.get');
    route::POST('/Report-Daily/{id}', [ReportPlan::class, 'reportDaily'])->name('reportDaily.post');

    //--------------------------------------TẢI FILE --------------------------------------------//
    Route::get('/download/{file}', [ReportPlan::class, 'download'])->name('reportWeekly.download');

    //-------------------------------------- GỞI MAIL --------------------------------------------//
    Route::post('/sendmail', [ReportPlan::class, 'sendmail'])->name('sendmail');
});









//------------------------------------------ QUẢN LÝ DỰ ÁN --------------------------------------//

// 1. -------------------------------------- DANH SÁCH DỰ ÁN --------------------------------------------//    
route::middleware('checkLogin')->prefix('/Project-Managerment')->group(function () {
    route::get('/listCarBrands', [ProjecManagement::class, 'listCarBrands'])->name('listCarBrands');
    route::get('/List-Project-Management/{id}', [ProjecManagement::class, 'listProjectManagement'])->name('listProjectManagerment');
    route::get('Project-Connect/{id}', [ProjecManagement::class, 'ProjectConnectView'])->name('projectConnect');
    route::get('Project-con/{id}', [ProjecManagement::class, 'ProjectCon'])->name('ProjectCon');
    route::get('/List-Project-Management-child/{car_brands_id}/{car_brands_child_id}', [ProjecManagement::class, 'listProjectManagementChild'])->name('listProjectManagementChild');
});

// 2. -------------------------------------- TẠO DỰ ÁN --------------------------------------------//    
route::middleware('checkLogin')->prefix('/Creat-Project')->group(function () {
    Route::get('Creat-Projec-Form/{id}/{car_brands_child_id?}', [ProjecManagement::class, 'formCreatProject'])->name('creatProject.get')->where(['id' => '[0-9]+', 'car_brands_child_id' => '[0-9]+']);
    Route::post('Creat-Projec-Form/{id}/{car_brands_child_id?}', [ProjecManagement::class, 'insertCreatProject'])->name('creatProject.post')->where(['id' => '[0-9]+', 'car_brands_child_id' => '[0-9]+']);
});

// 3. -------------------------------------- XÓA DỰ ÁN  --------------------------------------------//   
route::Delete('/Delete-projec/{id}', [ProjecManagement::class, 'deleteProject'])->name('deleteProject');
Route::delete('/project-department/{id}', [ProjecManagement::class, 'destroy'])->name('destroy');
Route::delete('/project-work/{id}', [ProjecManagement::class, 'deleteWork'])->name('deleteWork');
Route::delete('/project-Lv4/{id}', [ProjecManagement::class, 'deleteLv4'])->name('deleteLv4');


// 4.-------------------------------------- Cập nhật dự án  --------------------------------------------//   
    Route::put('/lock/{id}', [ProjecManagement::class, 'lock'])->name('lock');
    Route::put('/unlock/{id}', [ProjecManagement::class, 'unlock'])->name('unlock');
    Route::post('/updateProjectStatus', [ProjecManagement::class, 'updateStatus'])->name('update.status');
    Route::post('import-excel', [ProjecManagement::class, 'importExcel'])->name('importExcel');
    Route::get('export-excel', [ProjecManagement::class, 'exportExcel'])->name('exportExcel');
    Route::post('import-Handmade', [ProjecManagement::class, 'importHandmade'])->name('importHandmade');
    Route::post('import-Handmade-Lv4', [ProjecManagement::class, 'importHandmadeLv4'])->name('importHandmadeLv4');
    Route::post('import-excel-lv4', [ProjecManagement::class, 'importExcelLv4'])->name('importExcelLv4');
    Route::get('download-temp-file/{fileName}', [ProjecManagement::class, 'downloadTempFile'])->name('downloadTempFile');
    Route::post('/project-department', [ProjecManagement::class, 'store'])->name('store');


// 5 .-------------------------------------- CẬP NHẬT TIẾN ĐỘ CÔNG VIỆC  --------------------------------------------//   
route::post('update-result-project-connect', [ProjecManagement::class, 'updateResult'])->name('updateResult');
route::post('update-result-project-con', [ProjecManagement::class, 'updateResultCon'])->name('updateResultCon');
route::post('update-result-project-lv4', [ProjecManagement::class, 'updateResultLv4'])->name('updateResultLv4');

// 6.----------------------------------------- GHI CHÚ ----------------------------------------------------------------//
route::post('/save-note', [ProjecManagement::class, 'saveNote'])->name('savenote');
route::post('/save-note-Lv4', [ProjecManagement::class, 'saveNoteLv4'])->name('saveNoteLv4');
        

 //-------------------- CHAT REALTIME -----------------------//

Route::get('/chat', [ChatController::class, 'chat'])->middleware('auth');
// Route::post('/chat_rooms', [ChatController::class, 'storeRoom'])->name('chat_rooms.store')->middleware('auth');
// Route::get('/chat_rooms/create', [ChatController::class, 'createRoom'])->middleware('auth');
// Route::get('/chat_rooms/{chat_room}/messages', [ChatController::class, 'indexMessages'])->middleware('auth');
// Route::post('/chat_rooms/{chat_room}/messages', [ChatController::class, 'storeMessage'])->middleware('auth');
// Route::get('/chat_rooms', [ChatController::class, 'indexRooms'])->middleware('auth');



