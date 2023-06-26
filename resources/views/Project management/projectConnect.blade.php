@include('include.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>

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
                            <th style="text-align:center ;" class="table-header">Ngày bắt đầu</th>
                            <th style="text-align:center ;" class="table-header">Ngày kết thúc</th>
                            <th style="text-align:center ; width: 30%;" class="table-header">Ghi chú</th>
                            <th style="text-align:center ;" class="table-header">Kết quả</th>
                            <th style="text-align:center ;" class="table-header">Trạng thái</th>
                            <th style="text-align:center ; padding: 30px;" class="table-header">Thao tác</th>

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
                                <td style="text-align:center; width: 3%;">{{ $stt++ }}</td>
                                <td style="text-align:left; width: 20%;">  
                                    
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
                                <td style="text-align:left; width: 10%;">{{ $value->tenphongban }} </td>

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
                                                @endif`
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
                                    'success');

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
                                    'success');

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

</script>
