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
            font-size: 15px;
            font-family: 'Times New Roman', Times, serif;
            }
     label {
        display: block;
        text-align: left;
        margin-bottom: 0.5rem;
    }
    .custom-pagination {
        display: inline-block;
    }

    .custom-file-input {
        display: inline-block;
        padding: 6px 12px;
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 14px;
        margin-right: 10px;
        cursor: pointer;
    }

    .custom-file-input:hover {
        background-color: #e9ecef;
    }

    .custom-submit-btn {
        display: inline-block;
        padding: 6px 12px;
        background-color: #007bff;
        border: 1px solid #007bff;
        border-radius: 4px;
        font-size: 14px;
        color: #fff;
        cursor: pointer;
        text-decoration: none;
    }

    .custom-submit-btn:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }

    .table-nowrap td,
    .table-nowrap th {
        white-space: normal;
    }
</style>
<div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0" style="font-size:20px">Quản lý dự án</h4>
        <h4 class="mb-sm-0" style="font-size:20px"><a href="{{ route('projectConnect', $projectlv2->project_id) }}"
                type="button" class="btn btn-info"><i class="mdi mdi-keyboard-return"></i></a></h4>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body mb-3 mt-2" style="border: 1px solid;border-radius: 10px;">
                <h4 class="card-title" style="font-size:20px; font-family: 'Times New Roman', Times, serif !important;">Thương hiệu xe: <span
                        style="color: red;">{{ $car_brands->name }}</span></h4>
                <h4 class="card-title" style="font-size:20px; font-family: 'Times New Roman', Times, serif !important;">Tên dự án: <span
                        style="color: red">{{ $projectlv1->name_project }}</span></h4>
                <h4 class="card-title" style="font-size:20px; font-family: 'Times New Roman', Times, serif !important;">Hạng mục công việc: <span
                        style="color: red">{{ $projectlv2->name }}</span></h4>
                <h4 class="card-title" style="font-size:20px; font-family: 'Times New Roman', Times, serif !important;">Công việc chi tiết: <span
                        style="color: red">{{ $projectLv3->name_work }}</span></h4>
                <h4 class="card-title" style="font-size:20px; font-family: 'Times New Roman', Times, serif !important;">Thời gian: <span style="color: red">
                        {{ date('d/m/Y', strtotime($projectLv3->startdate)) }} -
                        {{ date('d/m/Y', strtotime($projectLv3->enddate)) }}</span></h4>
            </div>
            <div class="card-body">
                <div style="display: flex; align-items: center; gap: 10px; border:1px dashed  black; border-radius:10px" >
                    @if ($user['name'] == $projectLv3->responsibility)
                    <form class="mb-3 mt-3" action="{{ route('importExcelLv4') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input value="{{ $id }}" name="id" hidden />
                        <input style="margin-left: 10px" type="file" name="file" accept=".xlsx, .xls" class="custom-file-input" />
                        <button type="submit" class="custom-submit-btn">Nhập dữ liệu từ Excel</button>
                    </form>
              
                    <button type="button" data-id="{{$projectLv3->id}}" class="btn btn-outline-primary waves-effect waves-light">Thêm công việc</button>
                    @endif
                </div>                
                <table class="table table-bordered border-primary mb-3 mt-2">
                    @if (Session::has('successful'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                            <strong>Thông báo!</strong> Đã thêm thành công việc tuần thành công, hãy tìm kiếm để xem chi
                            tiết.
                        @elseif (Session::has('deleteSuccess'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                                <strong>Thông báo!</strong> Bạn đã xóa thành công.
                            </div>
                    @endif
            </div>
            <thead>
                <tr>
                    <th style="text-align:center ;" class="table-header">STT</th>
                    <th style="text-align:center ;" class="table-header">Tên công việc chi tiết</th>
                    <th style="text-align:center ;" class="table-header">Trách nhiệm</th>
                    <th style="text-align:center ;" class="table-header">Ngày bắt đầu</th>
                    <th style="text-align:center ;" class="table-header">Ngày kết thúc</th>
                    <th style="text-align:center ; width: 20%;" class="table-header">Ghi chú</th>
                    <th style="text-align:center ;" class="table-header">Kết quả</th>
                    <th style="text-align:center ;" class="table-header">Trạng thái</th>
                    <th style="text-align:center ;  width: 8%;" class="table-header">Thao tác</th>
                </tr>
            </thead>
            <tbody id="work-table-body">
                @php
                    $indexStart = ($projectLv4->currentPage() - 1) * $projectLv4->perPage();
                @endphp
                @foreach ($projectLv4 as $key => $work)
                    <tr>
                        <td style="text-align:center;">{{ $indexStart + $key + 1 }}</td>
                        <td style="text-align:left;">{{ $work->name_work }}</td>
                        <td style="text-align:left;">{{ $work->responsibility }}</td>
                        <td style="text-align:center; vertical-align: middle; width: 10%;">
                            {{ date('d/m/Y', strtotime($work->startdate)) }}
                        </td>
                        <td style="text-align:center; vertical-align: middle; width: 10%;">
                            {{ date('d/m/Y', strtotime($work->enddate)) }}
                        </td>
                        <td data-id1="{{ $work->id }}" class="note-cell1">{!! nl2br($work->note) !!}</td>
                     
                        @if ($work->startdate <= $today && $today <= $work->enddate && $work->completion <= 100)
                            <td class="completion" data-id="{{ $work->id }}"
                                style="text-align:center ;background-color: yellow; color: black">
                                {{ $work->completion }}%</td>
                            <td class="status" data-id="{{ $work->id }}"
                                style="text-align:center ; background-color: yellow; color: black">
                                Đang thực hiện
                            </td>
                        @elseif ($work->completion == 100)
                            <td class="completion" data-id="{{ $work->id }}"
                                style="text-align:center ;background-color: green; color: black">
                                {{ $work->completion }}%</td>
                            <td class="status"data-id="{{ $work->id }}"
                                style="text-align:center ; background-color: green; color: black">
                                Hoàn thành
                            </td>
                        @elseif ($work->enddate < $today)
                            <td class="completion" data-id="{{ $work->id }}"
                                style="text-align:center; background-color: red; color: black">
                                {{ $work->completion }}%</td>
                            <td class="status" data-id="{{ $work->id }}" style="text-align:center ; background-color: red; color: black">
                                Trễ Kế hoạch
                            </td>
                        @elseif ($work->startdate > $today)
                            <td class="completion" data-id="{{ $work->id }}"
                                style="text-align:center; color: black">
                                {{ $work->completion }}%</td>
                            <td class="status" data-id="{{ $work->id }}" style="text-align:center ; color: black">
                                Chưa đến hạng
                            </td>
                        @endif
                        <td style="text-align:center;">
                            @if ($projectlv1->lock==0)
                                @if ($user['name'] == $work->responsibility && $work->completion != 100)
                                    <a data-id="{{ $work->id }}" class="btn btn-outline-warning btn-sm edit" title="Cập nhật"><i class="ri-file-text-line"></i></a>
                                    <a data-id1="{{ $work->id }}" class="btn btn btn-outline-info btn-sm note" title="update"><i class="mdi mdi-microsoft-onenote"></i></a>
                                @endif
                                @if ($user['name'] == $projectLv3->responsibility && $work->completion != 100)
                                <button type="button" class="btn btn-outline-secondary btn-sm sua ri-edit-box-fill" title="Sửa" data-dialog="dialog-{{ $work->id }}" data-project-department-start="{{ $projectLv3->startdate }}" data-project-department-end="{{ $projectLv3->enddate }}"></button>
                                <button type="button" class="btn btn-outline-danger btn-sm delete ri-delete-bin-line" title="Xóa" data-dialog="dialog-{{ $work->id }}"></button>

                                @endif
                            @else
                                @if ($user['name'] == $work->responsibility && $work->completion != 100)
                                    <a data-id="{{ $work->id }}" class="btn btn-outline-warning btn-sm edit" title="Cập nhật"><i class="ri-file-text-line"></i></a>
                                    <a data-id1="{{ $work->id }}" class="btn btn btn-outline-info btn-sm note" title="update"><i class="mdi mdi-microsoft-onenote"></i></a>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        
            </table>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item {{ $projectLv4->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $projectLv4->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $projectLv4->lastPage(); $i++)
                        <li class="page-item {{ $projectLv4->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $projectLv4->url($i) }}">{{ $i }} <span class="sr-only">{{ $projectLv4->currentPage() == $i ? '(current)' : '' }}</span></a>
                        </li>
                    @endfor
                    <li class="page-item {{ $projectLv4->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $projectLv4->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

@include('include.footer')
<script>
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
                       url: "{!! route('updateResultLv4') !!}", // Thay đổi thành URL của bạn để xử lý dữ liệu
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
                                   '.completion[data-id="' + id + '"]');
                               const statusElement = $('.status[data-id="' + id +
                                   '"]'); // Thêm dòng này
                               const editElement = $('.edit[data-id="' + id +
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
                           url: "{!! route('saveNoteLv4') !!}",
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


   $(document).ready(function() {
   $('.btn.btn-outline-primary').click(function() {
       var work_by_project_department_id = $(this).data('id');
       var userAll = {!! json_encode($userAll) !!};
       var projectStartDate = {!! json_encode($projectLv3->startdate) !!};
       var projectEndDate = {!! json_encode($projectLv3->enddate) !!};
       var departmentNames = {!! json_encode($departmentNames) !!};
       var userAllByDepartment = {!! json_encode($userAllByDepartment) !!};
       Swal.fire({
           title: 'Thêm công việc',
           html: `
           <form id="manual-input-form">
               <input type="text" value="${work_by_project_department_id}" class="form-control" id="project_department_id" name="task_name" hidden>
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
           confirmButtonText: 'Thêm',
           focusConfirm: false,
           preConfirm: () => {
               var task_name = $('#task_name').val();
               var responsibility = $('#responsibility').val();
               var start_date = $('#start_date').val();
               var end_date = $('#end_date').val();
               

               $.ajax({
                   url: "{!!route('importHandmadeLv4')!!}",
                   type: 'POST',
                   data: {
                       task_name: task_name,
                       responsibility: responsibility,
                       project_department_id: work_by_project_department_id, // dòng mới thêm vào
                       start_date: start_date,
                       end_date: end_date,
                       _token: '{{ csrf_token() }}'
                   },
                   success: function(response) {
                       Swal.fire('Success', 'Công việc đã được thêm thành công', 'success');
                       location.reload();
                   },
                   error: function(xhr) {
                       Swal.fire('Error', 'Có lỗi xảy ra khi thêm công việc', 'error');
                   }
               });
           },
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
               $('#start_date').attr('min', projectStartDate);
               $('#start_date').attr('max', projectEndDate);
               $('#end_date').attr('min', projectStartDate);
           $('#end_date').attr('max', projectEndDate);
       }
   });
   });
});

   document.addEventListener('DOMContentLoaded', () => {
   const editWorkButtons = document.querySelectorAll('.sua');
   const userAll = @json($userAll);
   const userOptions = userAll.map(user => `<option value="${user.name}">${user.name}</option>`).join('');
   
   editWorkButtons.forEach((button) => {
       button.addEventListener('click', async () => {
       const id = button.dataset.dialog.split('-')[1];

       // Lấy thông tin của Work_By_Project_Department theo id
       const showWorkUrl = "{{ route('showLv4', ['id' => ':id']) }}".replace(':id', id);
       const response = await fetch(showWorkUrl);
       const work = await response.json();
       const projectDepartmentStart = button.dataset.projectDepartmentStart;
       const projectDepartmentEnd = button.dataset.projectDepartmentEnd;

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
           const updateWorkUrl = "{{ route('updateLv4', ['id' => ':id']) }}".replace(':id', id);
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
               const deleteUrl = "{{ route('deleteLv4', ['id' => ':id']) }}".replace(':id', id);
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
</script>

