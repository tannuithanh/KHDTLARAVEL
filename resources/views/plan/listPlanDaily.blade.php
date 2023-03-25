@include('include.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
     td, th {
        font-size: 20px;
        font-family: 'Times New Roman', Times, serif;
        }
        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        a.update {
        animation: blink 1s infinite;
        }
</style>
<div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">Kế hoạch ngày</h4>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Danh sách công việc <a href="{{ route('creatWorkDaily.get') }}" class="btn btn-danger btn-rounded waves-effect waves-light"><i class="mdi mdi-plus me-1"></i>Tạo công việc ngày</a><a style="margin-left: 6px;" href="{{ route('assignCreatWorkDaily.get') }}" class="btn btn-warning btn-rounded waves-effect waves-light"><i class="mdi mdi-plus me-1"></i> Giao việc</a></h4>
                <form id="form_search" method="post" name="form_search">
                    @csrf
                    <div class="card-body" style="border: 1px solid; border-radius: 30px; ">
                        <div class="d-flex gap-2 flex-wrap">
                            @if (in_array($user['position_id'], [1, 2, 3, 4]))
                                <div class="btn-group">
                                    <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;" class="card-title">
                                        Phòng:</h4>
                                    <select style="width:200px ;" class="form-control form-select" id="validationCustom03" name="departmentsId">
                                        <option value="">Tất cả</option>
                                        @foreach ($departments as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif    
                            <div class="btn-group">
                                <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;" class="card-title">
                                    Nhóm:</h4>
                                <select style="width:200px ;" class="form-control form-select" id="validationCustom03" name="teamId">
                                    <option value="">Tất cả</option>
                                    @foreach ($teams as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="btn-group">
                                <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;" class="card-title">
                                    Nhân sự:</h4>
                                <select style="width:200px ;" class="form-control form-select" id="validationCustom03" name="userName">
                                    <option value="">Tất cả</option>
                                    @foreach ($userById as $value)
                                    <option value="{{ $value->name }}">{{ $value->name }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="btn-group">
                            <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;" class="card-title">Ngày:</h4>
                            <input class="form-control" type="date" id="example-date-input" id="validationCustom03"
                                required="" name="Day">
                            </div>
                            <div style="margin-left: 1%;" class="btn-group">
                            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                            </div>
                        </div>
            </div>
            </form>
            <div class="table-responsive class scrollable-table-wrapper mt-5">
                @if (Session::has('successful'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong>Thông báo!</strong> Đã thêm công việc ngày thành công, hãy tìm kiếm để xem chi tiết.
                </div>
                @elseif (Session::has('status'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Thông báo!</strong> Cập nhật thành công.
                </div>
                @endif
                <table id="" class="table table-editable table-nowrap align-middle table-edits ">
                    <thead>
                        <tr>
                            <th style="text-align:center ;" class="table-header">STT</th>
                            <th style="text-align:center ;" class="table-header">Hạng mục công việc</th>
                            <th style="text-align:center ;" class="table-header">Nội dung công việc</th>
                            <th style="text-align:center ;" class="table-header">Giờ thực hiện</th>
                            <th style="text-align:center ;" class="table-header">Ngày\tháng\năm</th>
                            <th style="text-align:center ;" class="table-header">Trách nhiệm</th>
                            <th style="text-align:center ;" class="table-header">Hỗ trợ</th>
                            <th style="text-align:center ;" class="table-header">Mục tiêu</th>
                            <th style="text-align:center ;" class="table-header">Trạng thái</th>
                            <th style="text-align:center ;" class="table-header">Ghi chú</th>
                            <th style="text-align:center ;" class="table-header">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $stt = 1 @endphp
                        @if (!$workDaily->isEmpty())
                            @foreach ($workDaily as $value)
                                <tr>
                                    @if (Session::has('hack') && session('hack') == $value->id)
                                        <td style="text-align: center;background-color: #00802c3b"> {{ $stt++ }}</td>
                                        <td class="left-align" style="background-color: #00802c3b"> {{ $value->categoryDaily }} </td>
                                        <td class="left-align" style="text-align: left;background-color: #00802c3b"> {!! nl2br($value->describeDaily) !!}</td>
                                        @if(is_numeric($value->time))
                                            <td style="text-align: center; background-color: #00802c3b"> {{ $value->time }} giờ </td>
                                        @else
                                            <td style="text-align: center;background-color: #00802c3b;color:red;border: 1px solid black!important"> {{ $value->time }} </td>
                                        @endif
                                        <td style="text-align: center;background-color: #00802c3b" > {{ date('d/m/Y', strtotime($value->date)) }}</td>
                                        <td style="text-align: center;background-color: #00802c3b"> {{ $value->responsibility }}</td>
                                        <td style="text-align: center;background-color: #00802c3b"> {!! nl2br($value->support) !!}</td>
                                        <td style="text-align: center;background-color: #00802c3b" > {{ $value->ResultByWookWeek }}%</td>
                                        @if ($value->status == 0 && $today==$value->date) 
                                        <td style="color:rgb(8, 6, 6);text-align: center;background-color:rgb(255 206 0); border: 1px solid black!important">Đang thực Hiện</td>
                                        @elseif ($value->status == -1 && $today==$value->date)
                                        <td style="color:white;text-align: center;background-color:rgb(81, 82, 82); border: 1px solid black!important">Chưa cập nhật</td>
                                        @elseif ($value->status == 9 && $today==$value->date)
                                        <td style="color:rgb(3, 3, 3);text-align: center;background-color:rgba(129, 243, 97, 0.627); border: 1px solid black!important">Đã báo cáo</td>
                                        @elseif ($value->status == 0 && $today!=$value->date) 
                                        <td style="color:rgb(8, 6, 6);text-align: center;background-color:rgb(255 206 0); border: 1px solid black!important">Đang thực Hiện</td>
                                        @elseif ($value->status == -1 && $today!=$value->date)
                                        <td style="color:white;text-align: center;background-color:rgb(81, 82, 82); border: 1px solid black!important">Chưa cập nhật</td>
                                        @elseif ($value->status == 9 && $today!=$value->date)
                                        <td style="color:rgb(3, 3, 3);text-align: center;background-color:rgba(129, 243, 97, 0.627); border: 1px solid black!important">Đã báo cáo</td>
                                        @endif
                                        <td style="text-align: center;background-color: #00802c3b" > {{ $value->note }}</td>
                                        
                                        <td style="text-align: center;"> 
                                            <form id="delete-form-{{ $value->id }}"
                                                action="{{ route('deleteWorkDaily', $value->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                        @if ($value->status == -1)
                                            <a href="{{ route('updateWorkDaily.get', $value->id) }}" class="btn btn-outline-primary waves-light btn-sm update" title="Cập nhật công việc"><i class=" fas fa-cloud-upload-alt"></i></a>   
                                        @else
                                            @if($user['name']==$value->responsibility && $today==$value->date && $value->workweek_id == Null && $value->status != 9)
                                                <a href="{{ route('editWorkDaily.get', $value->id) }}"class="btn btn-outline-secondary btn-sm edit" title="Sửa"><i class="fas fa-pencil-alt"></i></a>
                                                <button type="button" class="btn btn-outline-danger btn-sm delete ri-delete-bin-line" title="Xóa" data-dialog="dialog-{{ $value->id }}"></button>
                                                <a href="{{ route('reportDaily.get', $value->id) }}" class="btn btn-outline-primary waves-light btn-sm" title="Báo cáo"><i class="ri-book-mark-line"></i></a>
                                            @elseif($user['name']==$value->responsibility && $today!=$value->date && $value->workweek_id == Null && $value->status != 9)
                                                <a href="{{ route('editWorkDaily.get', $value->id) }}"class="btn btn-outline-secondary btn-sm edit" title="Sửa"><i class="fas fa-pencil-alt"></i></a>
                                                <button type="button" class="btn btn-outline-danger btn-sm delete ri-delete-bin-line" title="Xóa" data-dialog="dialog-{{ $value->id }}"></button>
                                                <a href="{{ route('reportDaily.get', $value->id) }}" class="btn btn-outline-primary waves-light btn-sm" title="Báo cáo"><i class="ri-book-mark-line"></i></a>
                                            @endif
                                            @if ($user['name']==$value->responsibility && $today==$value->date && $value->workweek_id != Null && $value->status != 9)
                                            <a href="{{ route('reportDaily.get', $value->id) }}" class="btn btn-outline-primary waves-light btn-sm" title="Báo cáo"><i class="ri-book-mark-line"></i></a>
                                            @elseif ($user['name']==$value->responsibility && $today!=$value->date && $value->workweek_id != Null && $value->status != 9)
                                            <a href="{{ route('reportDaily.get', $value->id) }}" class="btn btn-outline-primary waves-light btn-sm" title="Báo cáo"><i class="ri-book-mark-line"></i></a>
                                            @endif
                                        @endif
                                        </form>
                                        </td>
                                    @else
                                        <td style="text-align: center;"> {{ $stt++ }}</td>
                                        <td class="left-align"> {{ $value->categoryDaily }} </td>
                                        <td class="left-align" style="text-align: left;"> {!! nl2br($value->describeDaily) !!}</td>
                                        @if(is_numeric($value->time))
                                            <td style="text-align: center;"> {{ $value->time }} giờ </td>
                                        @else
                                            <td style="text-align: center;color:red;border: 1px solid black!important"> {{ $value->time }} </td>
                                        @endif
                                        <td style="text-align: center;" > {{ date('d/m/Y', strtotime($value->date)) }}</td>
                                        <td style="text-align: center;"> {{ $value->responsibility }}</td>
                                        <td style="text-align: center;"> {!! nl2br($value->support) !!}</td>
                                        <td style="text-align: center;"> {{ $value->ResultByWookWeek }}%</td>
                                        @if ($value->status == 0 && $today==$value->date) 
                                        <td style="color:rgb(8, 6, 6);text-align: center;background-color:rgb(255 206 0); border: 1px solid black!important">Đang thực Hiện</td>
                                        @elseif ($value->status == -1 && $today==$value->date)
                                        <td style="color:white;text-align: center;background-color:rgb(81, 82, 82); border: 1px solid black!important">Chưa cập nhật</td>
                                        @elseif ($value->status == 9 && $today==$value->date)
                                        <td style="color:rgb(3, 3, 3);text-align: center;background-color:rgba(129, 243, 97, 0.627); border: 1px solid black!important">Đã báo cáo</td>
                                        @elseif ($value->status == 0 && $today!=$value->date) 
                                        <td style="color:rgb(8, 6, 6);text-align: center;background-color:rgb(255 206 0); border: 1px solid black!important">Đang thực Hiện</td>
                                        @elseif ($value->status == -1 && $today!=$value->date)
                                        <td style="color:white;text-align: center;background-color:rgb(81, 82, 82); border: 1px solid black!important">Chưa cập nhật</td>
                                        @elseif ($value->status == 9 && $today!=$value->date)
                                        <td style="color:rgb(3, 3, 3);text-align: center;background-color:rgba(129, 243, 97, 0.627); border: 1px solid black!important">Đã báo cáo</td>
                                        @endif
                                        <td style="text-align: center;"> {{ $value->note }}</td>
                                        <td style="text-align: center;"> 
                                            <form id="delete-form-{{ $value->id }}"
                                                    action="{{ route('deleteWorkDaily', $value->id) }}"
                                                    method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                            @if ($value->status == -1)
                                                <a href="{{ route('updateWorkDaily.get', $value->id) }}" class="btn btn-outline-primary waves-light btn-sm update" title="Cập nhật công việc"><i class=" fas fa-cloud-upload-alt"></i></a>   
                                            @else
                                                @if($user['name']==$value->responsibility && $today==$value->date && $value->workweek_id == Null && $value->status != 9)
                                                    <a href="{{ route('editWorkDaily.get', $value->id) }}"class="btn btn-outline-secondary btn-sm edit" title="Sửa"><i class="fas fa-pencil-alt"></i></a>
                                                    <button type="button" class="btn btn-outline-danger btn-sm delete ri-delete-bin-line" title="Xóa" data-dialog="dialog-{{ $value->id }}"></button>
                                                    <a href="{{ route('reportDaily.get', $value->id) }}" class="btn btn-outline-primary waves-light btn-sm" title="Báo cáo"><i class="ri-book-mark-line"></i></a>
                                                @elseif($user['name']==$value->responsibility && $today!=$value->date && $value->workweek_id == Null && $value->status != 9)
                                                    <a href="{{ route('editWorkDaily.get', $value->id) }}"class="btn btn-outline-secondary btn-sm edit" title="Sửa"><i class="fas fa-pencil-alt"></i></a>
                                                    <button type="button" class="btn btn-outline-danger btn-sm delete ri-delete-bin-line" title="Xóa" data-dialog="dialog-{{ $value->id }}"></button>
                                                    <a href="{{ route('reportDaily.get', $value->id) }}" class="btn btn-outline-primary waves-light btn-sm" title="Báo cáo"><i class="ri-book-mark-line"></i></a>
                                                @endif
                                                @if ($user['name']==$value->responsibility && $today==$value->date && $value->workweek_id != Null && $value->status != 9)
                                                <a href="{{ route('reportDaily.get', $value->id) }}" class="btn btn-outline-primary waves-light btn-sm" title="Báo cáo"><i class="ri-book-mark-line"></i></a>
                                                @elseif ($user['name']==$value->responsibility && $today!=$value->date && $value->workweek_id != Null && $value->status != 9)
                                                <a href="{{ route('reportDaily.get', $value->id) }}" class="btn btn-outline-primary waves-light btn-sm" title="Báo cáo"><i class="ri-book-mark-line"></i></a>
                                                @endif
                                            @endif
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td style="text-align: center;" colspan="10"> Không có dữ liệu</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

            </div>
@include('include.footer')
<script>
 // ------------------------------------------ JS TÌM KIẾM PHÒNG BAN --------------------------------------------------//    
    $(document).ready(function() {
        $('[name="departmentsId"]').on('change', function() {
            var departmentId = $('[name="departmentsId"]').val();
            if (departmentId) {
                $.ajax({
                    url: "{!! route('listWorkDailydepartments') !!}",
                    type: 'GET',
                    data: {
                        departments_id: departmentId,
                        token: '{!! csrf_token() !!}'
                    },
                    success: function(response) {
                        console.log(response);

                        var options1 = '<option value="0">Tất cả</option>';
                        if (response.teamId && response.teamId.length > 0) {
                            $.each(response.teamId, function(index, team) {
                                options1 += '<option value="' + team.id + '">' +
                                    team.name + '</option>';
                                    
                            });
                            
                        }else {
                            options = '<option value="0">Tất cả</option>';
                        } 
                         $('select[name="teamId"]').html(options1).attr('selected','selected');;

                        var options = '<option value="">Tất cả</option>';
                        if (response.users && response.users.length > 0) {
                            $.each(response.users, function(index, user) {
                                options += '<option value="' + user.name + '">' + user
                                    .name + '</option>';
                            });
                        } else {
                            options = '<option value="0">Tất cả</option>';
                        }
                        $('select[name="userName"]').html(options);
                    }
                });
            } else {
                $('select[name="userName"]').html('<option value="">Tất cả</option>');
            }
        });
    });

// ------------------------------------------ JS TÌM KIẾM NHÂN SỰ --------------------------------------------------//    
        $('[name="teamId"]').on('change', function() {
            var teamId = $('[name="teamId"]').val();
            if (teamId) {
                $.ajax({
                    url: "{!! route('listWorkDailyUsers') !!}",
                    type: 'GET',
                    data: {
                        team_id: teamId,
                        token: '{!! csrf_token() !!}'
                    },
                    success: function(response) {
                        console.log(response);

                        var options = '<option value="">Tất cả</option>';
                        if (response && response.length > 0) {
                            $.each(response, function(index, user) {
                                options += '<option value="' + user.name + '">' + user
                                    .name + '</option>';
                            });
                        } else {
                            options = '<option value="">Tất cả</option>';
                        }
                        $('select[name="userName"]').html(options);
                    }
                });
            } else {
                $('select[name="userName"]').html('<option value="">Tất cả</option>');
            }
        });
// ------------------------------------------ XÓA CÔNG VIỆC NGÀY --------------------------------------------------// 
    document.querySelectorAll('.delete').forEach(deleteButton => {
        deleteButton.addEventListener('click', () => {
            Swal.fire({
                title: 'Bạn có muốn xóa công việc này?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy bỏ'
            }).then((result) => {
                console.log(result)
                if (result.isConfirmed) {
                    deleteButton.closest('.delete-form').submit();
                }
            });
        });
    });
</script>