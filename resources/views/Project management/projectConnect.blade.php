@include('include.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .no-toggle {
        margin-left: 20px;
    }
   .toggle {
        cursor: pointer;
        margin-right: 10px; 
    }
    .parent-ul, .child-ul {
        display: none;
        padding-left: 20px;
    }
    .my-swal {
    max-height: 500px; 
    overflow-y: auto;
    }

    ul {
        list-style: none;
    }

    .parent-ul, .child-ul {
        padding-left: 20px;
    }

    .parent-li, .child-li {
        padding: 5px 0; 
    }

    .parent-li > div, .child-li > div {
        display: flex;
        align-items: center;
    }

    tbody, thead{
        border-color: black !important;
    }
    th {
     background-color:#16c745a2 !important ;
     text-align: center;
     vertical-align: middle;
     color: #000000c9;
     font-size: 20px;
    }
        td, th {
            border-color: black !important;
            vertical-align: middle;
            border: 1px solid black;
            font-size: 20px;
            font-family: 'Times New Roman', Times, serif;
            }
    .table-nowrap td, .table-nowrap th{
        white-space: inherit;

    }
    label {
        display: block;
        text-align: left;
        margin-bottom: 0.5rem;
    }
    .merged-cell {
        padding-left: 2.5rem !important;
        text-align: left;
        font-size: 20px;
    }
    .child-content {
        padding-left: -0.5rem;
    }
    .texta {
        color: #0043ff !important;
    }

    .texta:hover {
        color: #0fde51 !important;
    }

    .red-background {
        background-color: red;
        color: white;
    }

    .anc {
        color: violet
    }
    /* td{
        padding: 30px;
    } */
    td,
    th {
        
        font-size: 16px;
    }

    .timeline {
        position: relative;
        height: 21px;
        background-color: #0a0aea;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 20px;
    }

    .timeline__item {
        position: absolute;
        bottom: 0;
        width: 19px;
        height: 21px;
        background-color: #def205;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .timeline__item--late {
        background-color: #28f511;
    }

    .timeline__start,
    .timeline__end {
        display: none;
    }

    .timeline__star {
        color: #FFD700;
        font-size: 24px;
    }

    .timeline__start {
        left: 0%;
    }

    .timeline__end {
        right: 0%;
    }

    .timeline__star {
        right: 0%;
    }

    .timeline__content {
        position: absolute;
        top: -0.6em;
        white-space: nowrap;
        font-size: 12px;
        font-weight: bold;
        color: #000;
        transform: translateY(-100%);
    }

    .timeline__date {
        position: absolute;
        bottom: -1.2em;
        white-space: nowrap;
        font-size: 12px;
        font-weight: bold;
        color: #000;
        transform: translateY(100%);
    }

    .timeline__item--hidden {
        display: none;
    }

    .timeline__date--red {
        color: #ff0000;
    }

    .timeline__content--end {
        position: absolute;
        top: -1.2em;
        white-space: nowrap;
        font-size: 12px;
        font-weight: bold;
        color: #f80909;
        transform: translateY(-100%);
    }

    .timeline__date--end {
        position: absolute;
        bottom: -1.2em;
        white-space: nowrap;
        font-size: 12px;
        font-weight: bold;
        color: #ff0000;
        transform: translateY(100%);
        right: 0;
    }

    .timeline__content--first {
        left: -20px;
    }

    .timeline__content--end {
        right: -20px;
    }

    .timeline__item--future {
        background-color: #FFD700;
    }


    .timeline__star1 {
        color: #FF0000;
        font-size: 64px;
    }

    .timeline__star1 {
        right: 0%;
    }

    .timeline__star1 {
        font-size: 64px;
    }

    .timeline__item1 {
        position: absolute;
        bottom: 0;
        width: 14px;
        height: 25px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .timeline__content {
    position: absolute;
    bottom: 20px;
    }
    .timeline__content.hovered {
    top: -1.1em;
    }

    .timeline__content--end.hovered {
        top: -1.1em;
    }

    .modal-overlay {
    position: fixed;
    z-index: 1040;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    display: none;
    background: rgba(0, 0, 0, 0.5);
    }

    .slide-right {
        position: fixed;
        z-index: 1050;
        right: 0;
        top: 0;
        width: 0;
        height: 100%;
        overflow-x: hidden;
        transition: 0.5s;
        background: white;
    }

    .slide-right.show {
        width: 66.67%;
    }

    .modal-overlay.show {
        display: block;
    }
</style>
<div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">Quản lý dự án</h4>
    </div>
    <div class="col-lg-12">
      
        <div class="card">
            <div class="card-body mb-3 mt-2" style="border: 1px solid;border-radius: 10px;">
                <h4 class="card-title" style="font-size:20px; font-family: 'Times New Roman', Times, serif !important;">Thương hiệu xe: <span
                        style="color: red">{{ $car_brands->name }}</span></h4>
                <h4 class="card-title" style="font-size:20px; font-family: 'Times New Roman', Times, serif !important;">Tên dự án: <span
                        style="color: red">{{ $project->name_project }}</span></h4>
                <h4 class="card-title" style="font-size:20px; font-family: 'Times New Roman', Times, serif !important;">Thời gian: <span style="color: red">
                        {{ date('d/m/Y', strtotime($project->start_date)) }} -
                        {{ date('d/m/Y', strtotime($project->end_date)) }}</span></h4>
                        @if ($user['name']==$project->name_create)
                        <button type="button" class="btn btn-warning btn-sm add " title="Thêm" style="font-size: 20px; font-family: 'Times New Roman', Times, serif !important;" data-dialog="dialog-{{ $project->id }}" ><i class="mdi mdi-database-import"></i></button>    
                        @endif
            </div>
            @if (Session::has('error'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong>Thông báo!</strong> Hệ thống không thấy tên chuyên viên trong file.
                </div>
                @endif
            <div class="card-body">
                <div id="project-json" style="display:none;">{!! json_encode($projectJson) !!}</div>
                <div id="timeline" class="timeline" style="margin-top:10px"></div>
                                                     
               
                <table class="table table-bordered border-primary mb-2 mt-5">
                    <thead>
                        <tr>
                            <th style="text-align:center ;" class="table-header">STT</th>
                            <th style="text-align:center ;" class="table-header">Tên công việc</th>
                            <th style="text-align:center ;" class="table-header">Trách nhiệm</th>
                            <th style="text-align:center ; width: 6%;" class="table-header">Thời gian</th>
                            <th style="text-align:center ;" class="table-header">Ngày bắt đầu</th>
                            <th style="text-align:center ;" class="table-header">Ngày kết thúc</th>
                            <th style="text-align:center ;" class="table-header">Ghi chú</th>
                            <th style="text-align:center ; width: 6%;" class="table-header">Kết quả</th>
                            <th style="text-align:center ;" class="table-header">Trạng thái</th>
                            <th style="text-align:center ; padding: 70px;" class="table-header">Thao tác</th>

                        </tr>
                    </thead>
                    <tbody>
                        
                        @php
                            $stt = 1;
                            $current_project_name = null;
                        @endphp
                        @foreach ($project_department as $value)
                            @php
                                $start_date = new DateTime($value->startdate);
                                $end_date = new DateTime($value->enddate);
                                $interval = $start_date->diff($end_date);
                                $days_difference = $interval->days;
                                $hasWorkByProjectDepartment = $workByProjectDepartments->where('project_department_id', $value->id)->isNotEmpty();
                                $isProjectDepartmentDelayed = $value->isDelayed();
                               
                            @endphp
                            <tr data-id="{{ $value->id }}">
                                <td style="text-align:center;">{{ $stt++ }}</td>
                                <td style="text-align:left;">  
                                    
                                    <a class="expand-collapse btn btn-outline-success waves-effect waves-light" style="padding: 0.125rem 0.25rem;">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                    <a class="expand-collapse btn btn-outline-success waves-effect waves-light" style="display: none; padding: 0.125rem 0.25rem;">
                                        <i class="fas fa-minus"></i>
                                    </a>
                                    {{ $value->name }}
                                    @php
                                        $hasChildTaskWithUserResponsibility = $workByProjectDepartments->where('project_department_id', $value->id)->firstWhere('responsibility', $user['name']) !== null;
                                    @endphp
                                    @if($hasChildTaskWithUserResponsibility)
                                        <span style="color: red;">*</span>
                                    @endif
                                </td>
                                <td style="text-align:left; ">{{ $value->tenphongban }} </td>
                                
                                <td style="text-align:center; vertical-align: middle; width: 10%;">
                                    {{ \Carbon\Carbon::parse($value->startdate)->diffInDays(\Carbon\Carbon::parse($value->enddate)) + 1 }} ngày
                                </td>

                                <td style="text-align:center; vertical-align: middle; width: 10%;">
                                    {{ date('d/m/Y', strtotime($value->startdate)) }}
                                </td>
                                <td style="text-align:center; vertical-align: middle; width: 10%;">
                                    {{ date('d/m/Y', strtotime($value->enddate)) }}
                                </td>
                                <td data-id="{{ $value->id }}" class="note-cell">{!! nl2br($value->note) !!}</td>
                               
                                @if ($value->startdate <= $today && $today <= $value->enddate && $value->completion <= 100)
                                    <td class="completion" data-id="{{ $value->id }}"
                                        style="text-align:center ;background-color: yellow; color: black">
                                        {{ $value->completion }}%</td>
                                    <td class="status" data-id="{{ $value->id }}"
                                        style="text-align:center ; background-color: yellow; color: black">
                                        Đang thực hiện
                                    </td>
                                @elseif ($value->completion == 100)
                                    <td class="completion" data-id="{{ $value->id }}"
                                        style="text-align:center ;background-color: green; color: black">
                                        {{ $value->completion }}%</td>
                                    <td class="status" data-id="{{ $value->id }}"
                                        style="text-align:center ; background-color: green; color: black">
                                        Hoàn thành
                                    </td>
                                @elseif ($value->enddate < $today)
                                    <td class="completion" data-id="{{ $value->id }}"
                                        style="text-align:center; background-color: red; color: black">
                                        {{ $value->completion }}%</td>
                                    <td class="status" data-id="{{ $value->id }}" style="text-align:center ; background-color: red; color: black">
                                        Trễ Kế hoạch
                                    </td>
                                @elseif ($value->startdate > $today)
                                    <td class="completion" data-id="{{ $value->id }}"
                                        style="text-align:center; color: black">
                                        {{ $value->completion }}%</td>
                                    <td class="status" data-id="{{ $value->id }}" style="text-align:center ; color: black">
                                        Chưa đến hạng
                                    </td>
                                @endif
                                <td style="width: 10px;text-align: center;">
                                    @if ($project->lock == 0)
                                        
                                   
                                        @if ( $value->completion != 100 && !$hasWorkByProjectDepartment && $user['department_id'] == $value['department_id'] && in_array($user['position_id'], [5, 6, 7, 1, 2]))
                                            <a data-id="{{ $value->id }}" class="btn btn-outline-warning  btn-sm edit"
                                                title="cập nhật"><i class="ri-file-text-line"></i></a>
                                        @endif
                                        @if ($value->completion != 100 && $user['department_id'] == $value['department_id'] && in_array($user['position_id'], [5, 6, 1, 2]))
                                        <a data-id="{{ $value->id }}"  class="btn btn-outline-success addtask btn-sm"><i class="mdi mdi-application-import"></i></a>
                                        <a data-id="{{ $value->id }}" class="btn btn btn-outline-info btn-sm note2"
                                            title="update"><i class="mdi mdi-microsoft-onenote"></i></a>
    
                                        @endif
                                        @if ($user['name'] == $project->name_create)
                                        <button type="button" class="btn btn-outline-secondary btn-sm sua ri-edit-box-fill" title="Sửa" data-dialog="dialog-{{ $value->id }}"></button>
                                        <button type="button" class="btn btn-outline-danger btn-sm delete ri-delete-bin-line" title="Xóa" data-dialog="dialog-{{ $value->id }}"></button>
                                        @endif
                                    @endif
                                    <button type="button" class="btn btn-outline-info btn-sm link " title="Tác vụ" data-id="{{ $value->id }}" data-dialog="dialog-{{ $value->id }}">Liên kết</button>
                                </td>
                            </tr>
                    {{-- ------------------------------------------------------- Bảng con ------------------------------------------------------------------------------- --}}
                                
                            @if ($hasWorkByProjectDepartment)
                                @php
                                    $childStt = 1; 
                                @endphp
                                @foreach ($workByProjectDepartments->where('project_department_id', $value->id) as $work)
                                    @php 
                                          $workByProjectDepartment = \App\Models\Work_By_Project_Department::find($work->id); // Sửa ở đây
                                            $hasWorkLv4Projects = $workByProjectDepartment->work_lv4_projects->isNotEmpty();
                                            $delay = $work->isDelayed();
                                    @endphp
                                    <tr class="child-row" data-parent-id="{{ $value->id }}" >
                                        
                                        <td colspan="2" class="merged-cell">
                                            <span class="stt">{{ $stt-1 . '.' . $childStt++ }}</span>
                                            <span class="child-content">
                                                <a class="texta" href="{{route('ProjectCon',$work->id)}}">{{ $work->name_work }}</a>
                                                @php
                                                    $hasChildTaskWithUserResponsibility = $workByProjectDepartment->work_lv4_projects->firstWhere('responsibility', $user['name']) !== null;
                                                @endphp
                                                @if($hasChildTaskWithUserResponsibility)
                                                    <span style="color: red;">*</span>
                                                @endif
                                            </span>
                                        </td>                                     
                                        <td style="text-align: left">{{ $work->responsibility }} </td>
                                        <td style="text-align:center; vertical-align: middle; width: 10%;">
                                            {{ \Carbon\Carbon::parse($work->startdate)->diffInDays(\Carbon\Carbon::parse($work->enddate)) + 1 }} ngày
                                        </td>
                                        <td style="text-align: center">{{ date('d/m/Y', strtotime($work->startdate)) }}
                                        </td>
                                        <td style="text-align: center">{{ date('d/m/Y', strtotime($work->enddate)) }}
                                        </td>
                                        <td data-id1="{{ $work->id }}" class="note-cell1">{!! nl2br($work->note) !!}
                                        </td>
                                       
                                        @if ($work->startdate <= $today && $today <= $work->enddate && $work->completion <= 100)
                                            <td class="completion" data-id1="{{ $work->id }}"
                                                style="text-align:center ;background-color: yellow; color: black">
                                                {{ $work->completion }}%</td>
                                            <td class="status"
                                                style="text-align:center ; background-color: yellow; color: black">
                                                Đang thực hiện
                                            </td>
                                        @elseif ($work->completion == 100)
                                            <td class="completion" data-id="{{ $work->id }}"
                                                style="text-align:center ;background-color: green; color: black">
                                                {{ $work->completion }}%</td>
                                            <td class="status" data-id="{{ $work->id }}"
                                                style="text-align:center ; background-color: green; color: black">
                                                Hoàn thành
                                            </td>
                                        @elseif ($work->enddate < $today)
                                            <td class="completion" data-id1="{{ $work->id }}"
                                                style="text-align:center; background-color: red; color: black">
                                                {{ $work->completion }}%</td>
                                            <td class="status" data-id1="{{ $work->id }}"
                                                style="text-align:center ; background-color: red; color: black">
                                                Trễ Kế hoạch
                                            </td>
                                        @elseif ($work->startdate > $today)
                                            <td class="completion" data-id1="{{ $work->id }}"
                                                style="text-align:center; color: black">
                                                {{ $work->completion }}%</td>
                                            <td class="status" data-id1="{{ $work->id }}"
                                                style="text-align:center ; color: black">
                                                Chưa đến hạng
                                            </td>
                                        @endif
                                        <td style="text-align: center">
                                            @if ($project->lock == 0)

                                                @if ($user['department_id'] == $value->department_id && $work->completion != 100 && !$hasWorkLv4Projects && $user['name'] == $work['responsibility'])
                                                    <a data-id1="{{ $work->id }}" class="btn btn-outline-warning btn-sm edit1"
                                                        title="Cập nhật"><i class="ri-file-text-line"></i></a>
                                                    <a data-id1="{{ $work->id }}" class="btn btn btn-outline-info btn-sm note"
                                                        title="update"><i class="mdi mdi-microsoft-onenote"></i></a>
                                                @endif
                                                @if ($user['department_id'] == $value->department_id && in_array($user['position_id'], [5, 6]) )
                                                <button type="button" class="btn btn-outline-secondary btn-sm suaWork ri-edit-box-fill" title="Sửa" data-dialog="dialog-{{ $work->id }}" data-project-department-start="{{ $value->startdate }}" data-project-department-end="{{ $value->enddate }}"></button>


                                                <button type="button" class="btn btn-outline-danger btn-sm deleteWork ri-delete-bin-line" title="Xóa" data-dialog="dialog-{{ $work->id }}" data-work-id="{{ $work->id }}"></button>

        
                                                @endif                             
                                            @else
                                            @if ($user['department_id'] == $value->department_id && $work->completion != 100 && !$hasWorkLv4Projects && $user['name'] == $work['responsibility'])
                                                    <a data-id1="{{ $work->id }}" class="btn btn-outline-warning btn-sm edit1"
                                                        title="Cập nhật"><i class="ri-file-text-line"></i></a>
                                                    <a data-id1="{{ $work->id }}" class="btn btn btn-outline-info btn-sm note"
                                                        title="update"><i class="mdi mdi-microsoft-onenote"></i></a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{---------TAC VU---------}}
    <div class="modal-overlay">
        <div id="myModal" class="slide-right">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Liên kết</h5>
                    <button type="button" class="btn btn-outline-success btn-sm save" title="Lưu liên kết" style="margin-left: 80% !important;" >Lưu liên kết</button>
                    <button type="button" class="btn btn-outline-dark close btn-sm" title="Trở về">Trở về</button>
                </div>

                <div class="modal-body">
                <h5 class="modal-title" id="myModalLabel" style="font-family:bold"></h5>
                <button id="btn-add-link" class="btn btn-primary" type="submit">Thêm liên kết</button>
                    <table class="table table-editable table-nowrap align-middle table-edits mt-2 mb-2">
                        <thead>
                            <tr>
                                <th scope="col"># </th>
                                <th scope="col">Tên công việc</th>
                                <th scope="col">ID</th>
                                <th scope="col">Level</th>
                                <th scope="col">Kiểu phụ thuộc</th>
                                <th scope="col">Số ngày</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                        
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>


@include('include.footer')
<script src="{{asset('assets/js/jquery-3.7.0.min.js')}}"></script>
<script>
//----------------------------------- CÂY THƯỚC THỂ HIỂN ----------------------///
    const projectJson = @json($projectJson);
    console.log(projectJson);

    $(document).ready(function() {
        function truncateText(text, maxLength) {
            if (text.length > maxLength) {
                return text.substring(0, maxLength) + '...';
            } else {
                return text;
            }
        }
        function getColorBasedOnNumberOfEdits(numberOfEdits) {
            if (numberOfEdits === 0) {
                return ''; // Không thay đổi màu
            } else if (numberOfEdits === 1) {
                return '#cc04f0'; // Màu vàng
            } else if (numberOfEdits === 2) {
                return 'orange'; // Màu cam
            } else {
                return 'red'; // Màu đỏ
            }
        }

        function createTimelineItem(itemData) {
            const item = $("<div></div>")
                .addClass("timeline__item")
                .css("left", itemData.percentage + "%");
                

            const truncatedContent = truncateText(itemData.content, 4);

            const content = $("<div></div>")
                .addClass("timeline__content")
                .css("color", getColorBasedOnNumberOfEdits(itemData.numberOfEdits)) // Thêm dòng này để áp dụng màu sắc
                .html('<span data-full-content="' + itemData.content + '">' + truncatedContent + '</span>');
            item.append(content);

            if (itemData.showDate) {
                const date = $("<div></div>")
                    .addClass("timeline__date")
                    .text(itemData.date);
                item.append(date);
            }

            if (itemData.late) {
                item.addClass("timeline__item--late");
            }

            item.hover(
                function() {
                    const span = $(this).find("span");
                    const fullContent = span.data("full-content");
                    span.text(fullContent);
                    span.parent().addClass("hovered");
                },
                function() {
                    const span = $(this).find("span");
                    const truncatedContent = truncateText(span.data("full-content"), 10);
                    span.text(truncatedContent);
                    span.parent().removeClass("hovered");
                }
            );

            return item;
        }


        function splitContent(content, maxLength) {
            if (content.length > maxLength) {
                return content.substring(0, maxLength) + '\n' + content.substring(maxLength);
            } else {
                return content;
            }
        }

        function sortDepartmentsByEndDate(projectData) {
            return projectData.project_departments.sort((a, b) => {
                const aEndDate = new Date(a.enddate);
                const bEndDate = new Date(b.enddate);
                return aEndDate - bEndDate;
            });
        }

        function renderTimeline(projectData) {
            const timeline = $("#timeline");
            const numberOfMilestones = projectData.project_departments.length;
            const sortedDepartments = sortDepartmentsByEndDate(projectData);
            const endDate = new Date(projectData.end_date);
            const endLabel = $("<div></div>")
                .addClass("timeline__date timeline__date--red timeline__date--end")
                .text(endDate.toLocaleDateString());
            timeline.append(endLabel);
            
            const star = $("<div></div>")
                .addClass("timeline__item1 timeline__star1")
                .css("right", "0%")
                .text("★");
            timeline.append(star);

            sortedDepartments.forEach((department, index) => {
                const departmentEndDate = new Date(department.enddate);
                const today = new Date();
                const late = departmentEndDate < today;
                const percentage = (index / (numberOfMilestones - 1)) * 100;
                const isLastMilestone = index === numberOfMilestones - 1;
                const showDate = !isLastMilestone;

                const content = splitContent(department.name, 20);

                const itemData = {
                    percentage: percentage,
                    late: late,
                    content: content,
                    date: departmentEndDate.toLocaleDateString(),
                    showDate: showDate,
                    numberOfEdits: department.number_of_edits, // Thêm dòng này để lấy giá trị của numberOfEdits
                };
            if (!isLastMilestone) {
                const item = createTimelineItem(itemData);

                if (index === 0) {
                    item.find(".timeline__content").addClass("timeline__content--first");
                }

                timeline.append(item);
            }
        });

        const lastDepartment = projectData.project_departments[numberOfMilestones - 1];
        const truncatedLastDepartmentName = truncateText(splitContent(lastDepartment.name, 20), 10);
        const lastContent = $("<div></div>")
            .addClass("timeline__content timeline__content--end")
            .html('<span data-full-content="' + splitContent(lastDepartment.name, 20) + '">' + truncatedLastDepartmentName + '</span>');

        star.hover(
            function() {
                const span = lastContent.find("span");
                const fullContent = span.data("full-content");
                span.text(fullContent);
                lastContent.addClass("hovered");
            },
            function() {
                const span = lastContent.find("span");
                const truncatedContent = truncateText(span.data("full-content"), 10);
                span.text(truncatedContent);
                lastContent.removeClass("hovered");
            }
        );

        star.append(lastContent);
    }

    renderTimeline(projectJson);
    });
//--------------------------- CẬP NHẬT KẾT QUẢ -------------------------------------//
    document.querySelectorAll('.edit').forEach(function(editButton) {
        editButton.addEventListener('click', function() {
            const id = this.getAttribute('data-id');

            Swal.fire({
                title: 'Cập nhật tiến độ',
                input: 'number',
                inputAttributes: {
                    min: 1,
                    max: 100,
                    step: 1
                },
                showCancelButton: true,
                confirmButtonText: 'Cập nhật',
                cancelButtonText: 'Hủy',
                inputValidator: value => {
                    if (!value) {
                        return 'Vui lòng nhập một số!';
                    }
                }
            }).then(result => {
                if (result.isConfirmed) {
                    // Gửi giá trị nhập đến server sử dụng AJAX
                    $.ajax({
                        url: "{!! route('updateResult') !!}", // Thay đổi thành URL của bạn để xử lý dữ liệu
                        method: 'POST',
                        data: {
                            id: id,
                            completion: result.value,
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {

                            // Xử lý kết quả trả về từ server
                            if (response.status === 'success') {
                                // Tìm đến phần tử HTML chứa thông tin Kết quả dựa trên ID
                                const completionElement = $('.completion[data-id="' + id + '"]');
                                const statusElement = $('.status[data-id="' + id +'"]'); // Thêm dòng này
                                const editElement = $('.edit[data-id="' + id +'"]');

                                // Cập nhật giá trị mới cho phần tử HTML này
                                completionElement.text(response.new_completion +'%');

                                // Lấy ngày hiện tại
                                const today = new Date();

                                // Lấy thông tin ngày bắt đầu và kết thúc từ server (Bạn cần trả về giá trị này từ server)
                                const start_date = new Date(response.start_date);
                                const end_date = new Date(response.end_date);

                                // Thay đổi màu nền dựa trên giá trị completion và ngày hiện tại
                                if (response.new_completion == 100) {
                                    completionElement.css('background-color',
                                        'green');
                                    statusElement.text('Hoàn thành');
                                    statusElement.css('background-color', 'green');
                                    editElement.hide();
                                } else if (start_date <= today && today <=
                                    end_date) {
                                    completionElement.css('background-color',
                                        'yellow');
                                    statusElement.text('Đang thực hiện');
                                    statusElement.css('background-color', 'yellow');
                                } else if (end_date < today) {
                                    completionElement.css('background-color',
                                        'red');
                                    statusElement.text('Trễ kế hoạch');
                                    statusElement.css('background-color', 'red');
                                } else if (start_date > today) {
                                    completionElement.css('background-color', '');
                                    statusElement.text('Chưa đến hạng');
                                    statusElement.css('background-color', '');
                                }

                                Swal.fire('Thành công', response.message,
                                    'success');
                            } else {
                                Swal.fire('Lỗi', 'Không thể cập nhật tiến độ',
                                    'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            // Xử lý lỗi từ server
                            console.error(xhr, status, error);
                            Swal.fire('Lỗi', 'Không thể cập nhật tiến độ', 'error');
                        }
                    });
                }
            });
        });
    });
//--------------------------- NESTED TABLE -------------------------------------//
    $(document).ready(function () {
        // Ẩn tất cả các hàng con khi tải trang
        $('tr.child-row').hide();

        $('.expand-collapse').on('click', function () {
            const row = $(this).closest('tr[data-id]');
            const parentId = row.data('id');
            const plusButton = row.find('.fa-plus').parent();
            const minusButton = row.find('.fa-minus').parent();
            $(`tr.child-row[data-parent-id="${parentId}"]`).toggle();
            plusButton.toggle();
            minusButton.toggle();
        });
    });
//-------------------------------- CẬP NHẬT KẾT QUẢ ----------------------------------//
    document.querySelectorAll('.edit1').forEach(function(editButton) {
        editButton.addEventListener('click', function() {
            const id = this.getAttribute('data-id1');

            Swal.fire({
                title: 'Cập nhật tiến độ',
                input: 'number',
                inputAttributes: {
                    min: 1,
                    max: 100,
                    step: 1
                },
                showCancelButton: true,
                confirmButtonText: 'Cập nhật',
                cancelButtonText: 'Hủy',
                inputValidator: value => {
                    if (!value) {
                        return 'Vui lòng nhập một số!';
                    }
                }
            }).then(result => {
                if (result.isConfirmed) {
                    // Gửi giá trị nhập đến server sử dụng AJAX
                    $.ajax({
                        url: "{!! route('updateResultCon') !!}", // Thay đổi thành URL của bạn để xử lý dữ liệu
                        method: 'POST',
                        data: {
                            id: id,
                            completion: result.value,
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {

                            // Xử lý kết quả trả về từ server
                            if (response.status === 'success') {
                                // Tìm đến phần tử HTML chứa thông tin Kết quả dựa trên ID
                                const completionElement = $(
                                    '.completion[data-id1="' + id + '"]');
                                const statusElement = $('.status[data-id1="' + id +
                                    '"]'); // Thêm dòng này
                                const editElement = $('.edit1[data-id1="' + id +
                                    '"]');
                                // Cập nhật giá trị mới cho phần tử HTML này
                                completionElement.text(response.new_completion +
                                    '%');

                                // Lấy ngày hiện tại
                                const today = new Date();

                                // Lấy thông tin ngày bắt đầu và kết thúc từ server (Bạn cần trả về giá trị này từ server)
                                const start_date = new Date(response.start_date);
                                const end_date = new Date(response.end_date);

                                // Thay đổi màu nền dựa trên giá trị completion và ngày hiện tại
                                if (response.new_completion == 100) {
                                    completionElement.css('background-color',
                                        'green');
                                    statusElement.text('Hoàn thành');
                                    statusElement.css('background-color', 'green');
                                    editElement.hide()
                                } else if (start_date <= today && today <=
                                    end_date) {
                                    completionElement.css('background-color',
                                        'yellow');
                                    statusElement.text('Đang thực hiện');
                                    statusElement.css('background-color', 'yellow');
                                } else if (end_date < today) {
                                    completionElement.css('background-color',
                                        'red');
                                    statusElement.text('Trễ kế hoạch');
                                    statusElement.css('background-color', 'red');
                                } else if (start_date > today) {
                                    completionElement.css('background-color', '');
                                    statusElement.text('Chưa đến hạng');
                                    statusElement.css('background-color', '');
                                }

                                Swal.fire('Thành công', response.message,
                                    'success');
                            } else {
                                Swal.fire('Lỗi', 'Không thể cập nhật tiến độ',
                                    'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            // Xử lý lỗi từ server
                            console.error(xhr, status, error);
                            Swal.fire('Lỗi', 'Không thể cập nhật tiến độ', 'error');
                        }
                    });
                }
            });
        });
    });
//-------------------------------- GHI CHÚ ----------------------------------//
    function addBulletPointListener(inputElement) {
        inputElement.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                const cursorPosition = inputElement.selectionStart;
                const value = inputElement.value;
                inputElement.value = value.slice(0, cursorPosition) + "\n- " + value.slice(cursorPosition);
                inputElement.selectionStart = cursorPosition + 3;
                inputElement.selectionEnd = cursorPosition + 3;
            }
        });
    }

    $(document).ready(function() {
        $('.note').on('click', function() {
            const dataId = $(this).data('id1');

            Swal.fire({
                title: 'Nhập ghi chú của bạn',
                input: 'textarea',
                inputLabel: 'Ghi chú',
                inputPlaceholder: '- Nhập ghi chú của bạn ở đây...',
                inputAttributes: {
                    'aria-label': 'Nhập ghi chú của bạn ở đây'
                },
                inputAutoTrim: false,
                onOpen: (swal) => {
                    const inputElement = swal.getInput();
                    if (inputElement) {
                        addBulletPointListener(inputElement);
                    }
                },
                showCancelButton: true,
                confirmButtonText: 'Lưu',
                cancelButtonText: 'Hủy',
                preConfirm: (noteText) => {
                    return new Promise((resolve, reject) => {
                        $.ajax({
                            url: "{!! route('savenote') !!}",
                            method: 'POST',
                            data: {
                                note: noteText,
                                data_id: dataId,
                                _token: "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                Swal.fire('Thành công',
                                    'Ghi chú đã được lưu thành công',
                                    'success').then(function () {
                                    location.reload();
                                });

                                // Tìm ô Ghi chú tương ứng và cập nhật giá trị
                                var formattedNoteText = noteText
                                    .replace(/\n/g, '<br>');

                                // Tìm ô Ghi chú tương ứng và cập nhật giá trị
                                $('.note-cell1[data-id1="' + dataId +
                                    '"]').html(formattedNoteText);

                                resolve();
                            },
                            error: function(xhr, textStatus, errorThrown) {
                                Swal.fire('Lỗi',
                                    'Có lỗi xảy ra khi lưu ghi chú',
                                    'error');
                                reject();
                            }
                        });
                    });
                }
            });
        });
    });

//------------------------------------------ UPLOAD FILE HOẶC NHẬP THỦ CÔNG CHO HẠNG MỤC CÔNG VIỆC CON ---------------------------------------//
    $(document).ready(function () {
        $('.addtask').click(function (event) {
            var projectId = $(this).data('id');
            var userAll = {!! json_encode($userAll) !!};
            var departmentNames = {!! json_encode($departmentNames) !!};
            var userAllByDepartment = {!! json_encode($userAllByDepartment) !!};
            event.preventDefault();
        
            Swal.fire({
                title: 'Chọn phương thức thêm',
                input: 'radio',
                inputOptions: {
                    'file': 'Thêm bằng file',
                    'manual': 'Thêm thủ công'
                },
                inputValidator: function (value) {
                    if (!value) {
                        return 'Bạn cần chọn một phương thức!';
                    }
                }
            }).then(function (result) {
            if (result.isConfirmed) {
                if (result.value === 'file') {
                    showExcelImportForm(projectId);
                } else if (result.value === 'manual') {
                    showManualInputForm(projectId, userAll, departmentNames, userAllByDepartment);
                }
            }
            });
        });

            function showExcelImportForm(projectId) {
                Swal.fire({
                    title: 'Nhập dữ liệu từ Excel',
                    html: `
                    <form id="abcs" action="{{ route('importExcel') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input value="${projectId}" name="id" hidden />
                    <input type="file" name="file" accept=".xlsx, .xls" class="custom-file-input" />
                </form>
                    `,
                    showCancelButton: true,
                    cancelButtonText: 'Hủy',
                    confirmButtonText: 'Nhập dữ liệu',
                    preConfirm: function () {
                        $('#abcs').submit();
                            }
                        });
                    }

                    function showManualInputForm(projectId, userAll, departmentNames, userAllByDepartment) {
            Swal.fire({
                title: 'Nhập liệu',
                html: `
        <form id="manual-input-form">
            <input type="text" value="${projectId}" class="form-control" id="project_department_id" name="task_name" hidden>
            <div class="form-group">
                <label for="task_name">Tên công việc:</label>
                <input type="text" class="form-control" id="task_name" name="task_name" required>
            </div>
            <div class="form-group">
                <label for="responsibility">Trách nhiệm:</label>
                <select class="form-control" id="responsibility" name="responsibility" required>
                </select>
            </div>
            <div class="form-group">
                <label for="start_date">Ngày bắt đầu:</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date">Ngày kết thúc:</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>
        </form>
        `,
        didOpen: () => {
            $.each(userAllByDepartment, function(departmentId, usersInDepartment) {
                        var departmentName = departmentNames[departmentId];
                        var optgroup = $('<optgroup label="' + departmentName + '">');
                        
                        usersInDepartment.forEach(function(user) {
                            var option = new Option(user.name, user.name, false, false);
                            optgroup.append(option);
                        });

                        $('#responsibility').append(optgroup).trigger('change');
                    });
            $('#responsibility').select2({
                selectOnClose: true,
                minimumInputLength: 1  // start searching when at least one character is entered
            });
        },
        confirmButtonText: 'Thêm công việc',
                preConfirm: function () {
                    var taskName = $('#task_name').val();
                    var responsibility = $('#responsibility').val();
                    var startDate = $('#start_date').val();
                    var endDate = $('#end_date').val();
                    var project_department_id = $('#project_department_id').val();

                    // Validate the inputs
                    if (!taskName || !responsibility || !startDate || !endDate) {
                        Swal.showValidationMessage('Vui lòng điền đầy đủ thông tin.');
                        return false;
                    }

                    // Send the data to the server
                    // You need to change the URL and handle the server-side processing
                    $.ajax({
                        url: "{!!route('importHandmade')!!}",
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            task_name: taskName,
                            responsibility: responsibility,
                            start_date: startDate,
                            end_date: endDate,
                            project_department_id:project_department_id,
                        },
                        success: function (response) {
                                Swal.fire({
                                    title: 'Thành công!',
                                    text: 'Công việc đã được thêm.',
                                    icon: 'success'
                                }).then(function () {
                                    location.reload();
                                });
                            },
                        error: function (response) {
                            // Handle errors
                            Swal.fire('Lỗi!', 'Có lỗi xảy ra. Vui lòng thử lại.', 'error');
                        }
                    });
                }
            });
        }
    });
//------------------------------------------ SỬA ------------------------------------//

    document.addEventListener('DOMContentLoaded', () => {
    const editButtons = document.querySelectorAll('.sua');
    const departmentNames = {!! json_encode($departmentNames) !!};
    const userAllByDepartment = {!! json_encode($userAllByDepartment) !!};
    editButtons.forEach((button) => {
        button.addEventListener('click', async () => {
        const id = button.dataset.dialog.split('-')[1];
        

        // Lấy thông tin của ProjectDepartment theo id
        const showUrl = "{{ route('show', ['id' => ':id']) }}".replace(':id', id);
        const response = await fetch(showUrl);
        const projectDepartment = await response.json();
        let departmentOptions = '';
            $.each(departmentNames, function(departmentId, departmentName) {
                const option = new Option(departmentName, departmentId, false, false);
                departmentOptions += $(option).prop('outerHTML');
            });



        // Hiển thị hộp thoại SweetAlert2 với thông tin đã lấy được
        const { value: formValues } = await Swal.fire({
            title: 'Chỉnh sửa thông tin',
            html:
            '<label for="name">Tên:</label>' +
            `<input id="name" class="form-control" value="${projectDepartment.name}">` +
            '<label for="startdate">Ngày bắt đầu:</label>' +
            `<input id="startdate" class="form-control" type="date" value="${projectDepartment.startdate}">` +
            '<label for="enddate">Ngày kết thúc:</label>' +
            `<input id="enddate" class="form-control" type="date" value="${projectDepartment.enddate}">` +
            '<label for="responsibility">Trách nhiệm:</label>' +
                `<select class="form-control" id="responsibility" name="responsibility">${departmentOptions}</select>`,
            focusConfirm: false,
            confirmButtonText: 'Chỉnh sửa',
            preConfirm: () => {
            return {
                name: document.getElementById('name').value,
            startdate: document.getElementById('startdate').value,
            enddate: document.getElementById('enddate').value,
            department_id: document.getElementById('responsibility').value
            };
            },
        });

            if (formValues) {
                const startDate = new Date(formValues.startdate);
                const endDate = new Date(formValues.enddate);

                // Kiểm tra ngày kết thúc có nhỏ hơn ngày bắt đầu không
                if (endDate < startDate) {
                    Swal.fire('Lỗi!', 'Ngày kết thúc không được nhỏ hơn ngày bắt đầu!', 'error');
                } else {
                    // Cập nhật thông tin đã chỉnh sửa và gửi lại cho server
                    const updateUrl = "{{ route('update', ['id' => ':id']) }}".replace(':id', id);
                    await fetch(updateUrl, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(formValues),
                    });

                    Swal.fire('Cập nhật thành công!', '', 'success').then(function () {
                                    location.reload();
                                });
                }
                }
        });
    });
    });

//-------------------------------------- XÓA DỰ ÁN CON LV2 --------------------------------------//
        document.addEventListener('DOMContentLoaded', () => {
        const deleteButtons = document.querySelectorAll('.delete');
        deleteButtons.forEach((button) => {
            button.addEventListener('click', async () => {
            const id = button.dataset.dialog.split('-')[1];

            const result = await Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa?',
                text: "Bạn không thể hoàn tác hành động này!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            });

            if (result.isConfirmed) {
                const deleteUrl = "{{ route('destroy', ['id' => ':id']) }}".replace(':id', id);
                await fetch(deleteUrl, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                });

                Swal.fire('Đã xóa!', 'Dữ liệu đã được xóa thành công.', 'success').then(function () {
                                    location.reload();
                                });
            }
            });
        });
        });
//------------------- THÊM DỰ ÁN LV2 -------------------------------------//
    document.addEventListener('DOMContentLoaded', () => {
    const addButton = document.querySelector('.add');
    const projectStartDate = "{{ $project->start_date }}";
    const projectEndDate = "{{ $project->end_date }}";  
    const projectId = "{{ $project->id }}";
    addButton.addEventListener('click', async () => {
        const departmentOptions = @json($departments).map(department => `<option value="${department.id}">${department.name}</option>`).join('');

        const { value: formValues } = await Swal.fire({
        title: 'Thêm công việc mới',
        html:
        '<label for="name">Tên:</label>' +
        '<input id="name" class="form-control">' +
        '<label for="startdate">Ngày bắt đầu:</label>' +
        `<input id="startdate" class="form-control" type="date" min="${projectStartDate}" max="${projectEndDate}">` +
        '<label for="enddate">Ngày kết thúc:</label>' +
        `<input id="enddate" class="form-control" type="date" min="${projectStartDate}" max="${projectEndDate}">` +
        '<label for="responsibility">Trách nhiệm:</label>' +
        `<select class="form-control" id="responsibility" name="responsibility">${departmentOptions}</select>`,
        focusConfirm: false,
        confirmButtonText: 'Thêm',
        preConfirm: () => {
            const startdate = document.getElementById('startdate').value;
            const enddate = document.getElementById('enddate').value;

            if (startdate > enddate) {
                Swal.showValidationMessage('Ngày kết thúc không được bé hơn ngày bắt đầu');
                return;
            }

            return {
                name: document.getElementById('name').value,
                startdate: startdate,
                enddate: enddate,
                department_id: document.getElementById('responsibility').value,
                project_id: projectId
            };
            },
        });

        if (formValues) {
        const storeUrl = "{{ route('store') }}";
        const response = await fetch(storeUrl, {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(formValues),
        });

        const result = await response.json();
        Swal.fire('Thêm thành công!', '', 'success').then(function () {
                                    location.reload();
                                });
        // Tùy chọn: đặt thêm mã để cập nhật giao diện sau khi thêm mới thành công
        }
    });
    });
//---------------------- SỬA DỰ ÁN LV3 --------------------------//
    document.addEventListener('DOMContentLoaded', () => {
        const editWorkButtons = document.querySelectorAll('.suaWork');
    const departmentNames = {!! json_encode($departmentNames) !!};
    const userAllByDepartment = {!! json_encode($userAllByDepartment) !!};
    
    editWorkButtons.forEach((button) => {
        button.addEventListener('click', async () => {
        const id = button.dataset.dialog.split('-')[1];

        // Lấy thông tin của Work_By_Project_Department theo id
        const showWorkUrl = "{{ route('showWork', ['id' => ':id']) }}".replace(':id', id);
        const response = await fetch(showWorkUrl);
        const work = await response.json();
        const projectDepartmentStart = button.dataset.projectDepartmentStart;
        const projectDepartmentEnd = button.dataset.projectDepartmentEnd;
        let userOptions = '';
            $.each(userAllByDepartment, function(departmentId, usersInDepartment) {
                const departmentName = departmentNames[departmentId];
                const optgroup = $('<optgroup label="' + departmentName + '">');

                usersInDepartment.forEach(function(user) {
                    const option = new Option(user.name, user.name, false, false);
                    optgroup.append(option);
                });

                userOptions += optgroup.prop('outerHTML');
            });
        // Hiển thị hộp thoại SweetAlert2 với thông tin đã lấy được
        const { value: formValues } = await Swal.fire({
            title: 'Chỉnh sửa thông tin công việc',
            html:
            '<label for="name_work">Tên công việc:</label>' +
            `<input id="name_work" class="form-control" value="${work.name_work}">` +
            '<label for="startdate">Ngày bắt đầu:</label>' +
            `<input id="startdate" class="form-control" type="date" min="${projectDepartmentStart}" max="${projectDepartmentEnd}" value="${work.startdate}">` +
            '<label for="enddate">Ngày kết thúc:</label>' +
            `<input id="enddate" class="form-control" type="date" min="${projectDepartmentStart}" max="${projectDepartmentEnd}" value="${work.enddate}">` +
            '<label for="responsibility">Trách nhiệm:</label>' +
                `<select class="form-control" id="responsibility" name="responsibility">${userOptions}</select>`,
            focusConfirm: false,
            confirmButtonText: 'Chỉnh sửa',
            didOpen: () => {
                    $('#responsibility').select2({
                        selectOnClose: true,
                        minimumInputLength: 1  // start searching when at least one character is entered
                    });
                },
            preConfirm: () => {
            return {
                name_work: document.getElementById('name_work').value,
                responsibility: document.getElementById('responsibility').value,
                startdate: document.getElementById('startdate').value,
                enddate: document.getElementById('enddate').value,
            };
            },
        });

        if (formValues) {
            // Cập nhật thông tin đã chỉnh sửa và gửi lại cho server
            const updateWorkUrl = "{{ route('updateWork', ['id' => ':id']) }}".replace(':id', id);
            await fetch(updateWorkUrl, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(formValues),
            });

            Swal.fire('Cập nhật thành công!', '', 'success').then(function () {
                                    location.reload();
                                });
        }
        });
    });
    });
//---------------------------------- XÓA DỰ ÁN LV3 ---------------------------------------------//
    document.addEventListener('DOMContentLoaded', () => {
    const deleteWorkButtons = document.querySelectorAll('.deleteWork');
    deleteWorkButtons.forEach((button) => {
        button.addEventListener('click', async () => {
        const workId = button.dataset.workId;

        const result = await Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa công việc này?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy',
        });

        if (result.isConfirmed) {
            // Gửi yêu cầu xóa công việc tới server
            const deleteUrl = "{{ route('deleteWork', ['id' => ':id']) }}".replace(':id', workId);
            await fetch(deleteUrl, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            });

            Swal.fire('Đã xóa!', 'Công việc đã được xóa thành công.', 'success').then(function () {
                                    location.reload();
                                });
        }
        });
    });
    });
//--------------------------------------- GHI CHÚ PROJECT -------------------------------------//
    $(document).ready(function() {
        $('.note2').on('click', function() {
            const dataId = $(this).data('id');

            Swal.fire({
                title: 'Nhập ghi chú của bạn',
                    input: 'textarea',
                    inputLabel: 'Ghi chú',
                    inputPlaceholder: '- Nhập ghi chú của bạn ở đây...',
                    inputAttributes: {
                        'aria-label': 'Nhập ghi chú của bạn ở đây'
                    },
                    inputAutoTrim: false,
                    onOpen: (swal) => {
                        const inputElement = swal.getInput();
                        if (inputElement) {
                            addBulletPointListener(inputElement);
                        }
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Lưu',
                    cancelButtonText: 'Hủy',
                    preConfirm: (noteText) => {
                    return new Promise((resolve, reject) => {
                        $.ajax({
                            url: "{!! route('saveNoteProject') !!}",
                            method: 'POST',
                            data: {
                                note: noteText,
                                data_id: dataId,
                                _token: "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                Swal.fire('Thành công',
                                    'Ghi chú đã được lưu thành công',
                                    'success').then(function () {
                                        location.reload();
                                    });

                                // Tìm ô Ghi chú tương ứng và cập nhật giá trị
                                var formattedNoteText = noteText
                                    .replace(/\n/g, '<br>');

                                // Tìm ô Ghi chú tương ứng và cập nhật giá trị
                                $('.note-cell2[data-id="' + dataId +
                                    '"]').html(formattedNoteText);

                                resolve();
                            },
                            error: function(xhr, textStatus, errorThrown) {
                                Swal.fire('Lỗi',
                                    'Có lỗi xảy ra khi lưu ghi chú',
                                    'error');
                                reject();
                            }
                        });
                    });
                }
            });
        });
    });
//---------------- TÁC VỤ LV1------------------//
    $(document).ready(function() {
        $('.link').click(function() {
            $('#myModal').addClass('show');
            $('.modal-overlay').addClass('show');
        });

        $('.close').click(function() {
            $('#myModal').removeClass('show');
            $('.modal-overlay').removeClass('show');
        });
    });
    $(document).ready(function() {
        $('.link').click(function() {
            $('#myModal').addClass('show');
            $('.modal-overlay').addClass('show');
        });

        $('.close').click(function() {
            $('#myModal').removeClass('show');
            $('.modal-overlay').removeClass('show');
        });
    });
    $('.link').on('click', function() {
        var id = $(this).data('id');
        $.ajax({
            url: "{!! route('TacVuLv1', 'ID_TEMP') !!}".replace('ID_TEMP', id),
            method: 'GET',
            success: function(response) {
                console.log(response);
                $('#myModal .modal-body h5').text('Tên công việc: ' + response.task.name);
                $('#btn-add-link').attr('data-id', response.task.id);
                $('#btn-add-link').attr('data-table', 'project_department');
                $('.modal-body table tbody').empty(); 
                $.each(response.dependentTasks, function(i, taskLink) {
                var relatedTaskTableDisplay = taskLink.related_task_table;

                if (relatedTaskTableDisplay === 'work_by_project_department') {
                    relatedTaskTableDisplay = '3';
                }else if(relatedTaskTableDisplay == 'project_department'){
                    relatedTaskTableDisplay = '2';
                }else{
                    relatedTaskTableDisplay = '4';
                }

                var row = `<tr data-id="${taskLink.id}">
                    <td>${i + 1}</td>
                    <td>${taskLink.related_task_name}</td> 
                    <td style="text-align: center;">${taskLink.related_task_id}</td>
                    <td style="text-align: center;">${relatedTaskTableDisplay}</td>
                    <td class="dependencyType">${taskLink.relationship_type}</td>
                    <td style="text-align: center;" class="numberOfDays">${taskLink.day != null ? taskLink.day : ''}</td>
                    <td><button class="btn btn-danger btn-remove">Xóa</button> 
                        <button type="button" class="btn btn-outline-secondary edittasklv1" title="Sửa" >Sửa</button>
                    </td>
                </tr>`;
                    
                    $('.modal-body table tbody').append(row);
                });
            }
        });
    });
    //---- SUA TAC VU -----//
    $(document).on('click', '.edittasklv1', function() {
        var $row = $(this).closest('tr');
        var taskId = $row.data('id');
        
        var dependencyType = $row.find('.dependencyType').val();
        var numberOfDays = $row.find('.numberOfDays').val();
    
        Swal.fire({
            title: 'Edit Task',
            html: `
                <select id="swalDependencyType" class="swal2-input">
                    <option value="">Select Dependency Type</option>
                    <option value="FS (Finish-to-Start)">Finish-to-Start</option>
                    <option value="SS (Start-to-Start)">Start-to-Start</option>
                    <option value="SF (Start-to-Finish)">Start-to-Finish</option>
                    <option value="FF (Finish-to-Finish)">Finish-to-Finish</option>
                </select>
                <input id="swalNumberOfDays" class="swal2-input" type="number" min="0" placeholder="Number of days">
            `,
            preConfirm: function() {
                return [
                    document.getElementById('swalDependencyType').value,
                    document.getElementById('swalNumberOfDays').value
                ]
            }
        }).then(function(result) {
            if(result.isConfirmed) {
                var updatedDependencyType = result.value[0];
                var updatedNumberOfDays = result.value[1];
    
                $.ajax({
                    url: "{!! route('updateTacVu') !!}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id:taskId,
                        dependencyType: updatedDependencyType,
                        numberOfDays: updatedNumberOfDays
                    },
                    success: function(response) {
                        console.log(response);
                        $row.find('.dependencyType').text(updatedDependencyType);
                        $row.find('.numberOfDays').text(updatedNumberOfDays);
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: 'Sửa thành công tác vụ',
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR, textStatus, errorThrown);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while updating the task',
                        });
                    },
                    complete: function(jqXHR, textStatus) {
                        console.log('AJAX call completed with status: ' + textStatus);
                    }
                });
            }
        });
    });
    

    $(document).on('click', '.btn-remove', function() {
    var $row = $(this).closest('tr');
    var taskId = $row.data('id');
        $.ajax({
            url: "{!! route('deleteTacVu') !!}",
            method: 'POST',
            data: {
                id: taskId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log(response);
                // Kiểm tra nếu việc xóa đã thành công
                if (response.success) {
                    // Biến mất dòng đó nếu việc xóa thành công
                    $row.fadeOut(500, function(){ $(this).remove(); });
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

//----------LAY DANH SACH TẤT CẢ CÔNG VIỆC-----------//
        $('#btn-add-link').click(function() {
            var id = $(this).data('id');
            $.ajax({
                url: "{!! route('getAllWorks', 'ID_TEMP') !!}".replace('ID_TEMP', id),
                method: 'GET',
                success: function(data) {
                    console.log('Data received:', data);
                    var html = '<ul>';
                    if (Array.isArray(data.project_departments)) {
                        console.log('Project Departments:', data.project_departments);
                        data.project_departments.forEach(function(projectDepartment) {
                            html += '<li class="parent-li"><div>';
                            if (Array.isArray(projectDepartment.works) && projectDepartment.works.length > 0) {
                                html += '<span class="toggle">+</span>';
                            }else {
                                html += '<div class="no-toggle"></div>';
                            }
                            html += '<input type="checkbox" id="work-' + projectDepartment.id + '" value="' + projectDepartment.id + '" data-table="project_department">';
                            html += '<label for="work-' + projectDepartment.id + '">' + projectDepartment.name + '</label></div>';
                            html += '<ul class="parent-ul">';
                            if (Array.isArray(projectDepartment.works)) {
                                console.log('Works:', projectDepartment.works);
                                projectDepartment.works.forEach(function(workLv2) {
                                    html += '<li class="parent-li"><div>';
                                    if (Array.isArray(workLv2.work_lv4_projects) && workLv2.work_lv4_projects.length > 0) {
                                        html += '<span class="toggle">+</span>';
                                    }else {
                                        html += '<div class="no-toggle"></div>';
                                    }
                                    html += '<input type="checkbox" id="work-' + workLv2.id + '" value="' + workLv2.id + '" data-table="work_by_project_department">';
                                    html += '<label for="work-' + workLv2.id + '">' + workLv2.name_work + '</label></div>';
                                    html += '<ul class="child-ul">';
                                    if (Array.isArray(workLv2.work_lv4_projects)) {
                                        console.log('Work Level 4 Projects:', workLv2.work_lv4_projects);
                                        workLv2.work_lv4_projects.forEach(function(workLv3) {
                                            html += '<li class="child-li"><div>';
                                            html += '<input type="checkbox" id="work-' + workLv3.id + '" value="' + workLv3.id + '" data-table="work_lv4_project">';
                                            html += '<label for="work-' + workLv3.id + '">' + workLv3.name_work + '</label></div></li>';
                                        });
                                    }
                                    html += '</ul></li>';
                                });
                            }
                            html += '</ul></li>';
                        });
                    }
        
                    html += '</ul>';
                    console.log('Final HTML:', html)
                    var checkedItems = [];
                    Swal.fire({
                        title: 'Các công việc',
                        html: html,
                        confirmButtonText: 'Thêm',
                        showCloseButton: true,
                        customClass: {
                            popup: 'my-swal'
                        },
                        didOpen: () => { 
                            $('.parent-li > div, .child-li > div').on('click', function(e) {
                                e.stopPropagation();
                                var $toggle = $(this).find('.toggle');
                                if ($toggle.text() === '+') {
                                    $toggle.text('-');
                                } else {
                                    $toggle.text('+');
                                }
                                $(this).next('ul').slideToggle();
                            });
                            //-----------------THEM VAO BẢNG KHI CHECKBOX ----------------//
                            
                                $('input[type="checkbox"]').on('click', function() {
                                    var nameWork = $(this).siblings('label').text();
                                    var id = $(this).val();
                                    var table = $(this).attr('data-table');
                                
                                    if (table === 'project_department') {
                                        table = '2';
                                    } else if (table === 'work_by_project_department') {
                                        table = '3';
                                    } else if (table === 'work_lv4_project') {
                                        table = '4';
                                    }
                                
                                    if ($(this).is(':checked')) {
                                        // Checkbox has been checked
                                        checkedItems.push({nameWork, id, table});
                                    } else {
                                        // Checkbox has been unchecked
                                        checkedItems = checkedItems.filter(item => item.id != id || item.table != table);
                                    }
                                });
                                
                                },
                                preConfirm: () => {
                                    var rowNumber = 1;
                                    $('.modal-body table tbody').empty();
                                    checkedItems.forEach(({nameWork, id, table}) => {
                                        var newRowHtml = `
                                            <tr>
                                                <td>${rowNumber++}</td>
                                                <td>${nameWork}</td>
                                                <td>${id}</td>
                                                <td>${table}</td>
                                                <td>
                                                    <select class="dependencyType">
                                                        <option value=""></option>
                                                        <option value="FS (Finish-to-Start)">Finish-to-Start</option>
                                                        <option value="SS (Start-to-Start)">Start-to-Start</option>
                                                        <option value="SF (Start-to-Finish)">Start-to-Finish</option>
                                                        <option value="FF (Finish-to-Finish)">Finish-to-Finish</option>
                                                    </select>
                                                </td>
                                                <td><input type="number" min="0" class="numberOfDays" /></td>
                                                <td></td>
                                            </tr>
                                        `;
                                        $('.modal-body table tbody').append(newRowHtml);
                                    });

                                    }
                        
                    });
                    
                }
            });
        });
            //------- LƯU LẠI NHỮNG GÌ ĐÃ THÊM VÀO TABLE --------//
                function convertTableValue(tableValue) {
                    switch(tableValue) {
                        case '2': return 'project_department';
                        case '3': return 'work_by_project_department';
                        case '4': return 'work_lv4_project';
                        default: return tableValue;
                    }
                }
                $('.save').on('click', function() {
                    var taskLinks = [];
                    var currentTaskId = $('#btn-add-link').attr('data-id');
                    var currentTaskTable = convertTableValue($('#btn-add-link').attr('data-table'));
                
                    $('.modal-body table tbody tr').each(function() {
                        var id = $(this).find('td:nth-child(3)').text();
                        var table = convertTableValue($(this).find('td:nth-child(4)').text());
                        var relationshipType = $(this).find('.dependencyType').val();
                        var day = $(this).find('.numberOfDays').val();
                        
                        if (!relationshipType) {
                            alert('Kiểu phụ thuộc không được để trống!');
                            return false;
                        }
                        if (id && table) {
                            taskLinks.push({
                                dependent_task_id: currentTaskId,
                                dependent_task_table: currentTaskTable,
                                related_task_id: id,
                                related_task_table: table,
                                relationship_type: relationshipType,
                                day: day
                            });
                        }
                    });                
                    $.ajax({
                        url: "{!! route('saveTacVu') !!}", 
                        method: 'POST',
                        data: {
                            taskLinks: taskLinks,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // Handle success
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(function () {
                                location.reload();
                            });
                            // Refresh or update your table here
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            // Handle error
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: jqXHR.responseJSON.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    });
                });
    
</script>
