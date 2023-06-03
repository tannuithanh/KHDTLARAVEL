@include('include.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">BÁO CÁO NGÀY</h4>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form id="form_search" name="form_search"  method="post">
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
                    @if (Session::has('report'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <strong>Thông báo!</strong> Đã báo cáo thành công việc ngày, hãy tìm kiếm để xem chi
                        tiết.
                    </div>
                    @elseif (Session::has('deleteSuccess'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <strong>Thông báo!</strong> Bạn đã xóa thành công.
                    </div>
                    @elseif (Session::has('status'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <strong>Thông báo!</strong> Chỉnh sửa công việc thành công.
                    </div>
                    @endif
                    <table id="table-report" class="table table-sm m-0">
                        <thead>
                            <tr>
                                <th style="text-align:center ;" class="table-header">STT</th>
                                <th style="text-align:center ;" class="table-header">Hạng mục công việc</th>
                                <th style="text-align:center ;" class="table-header">Mô tả công việc</th>
                                <th style="text-align:center ;" class="table-header">Trách nhiệm</th>
                                <th style="text-align:center ;" class="table-header">Hỗ trợ</th>
                                <th style="text-align:center ;" class="table-header">Ngày Tháng Năm</th>
                                <th style="text-align:center ;" class="table-header">Mục tiêu</th>
                                <th style="text-align:center ;" class="table-header">Kết quả</th>
                                <th style="text-align:center ;" class="table-header">Bất cập</th>
                                <th style="text-align:center ;" class="table-header">Đề xuất</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $stt = 1 @endphp
                                @foreach ($workDaily as $value)
                                @if ($value->status == 9)
                                <tr>
                                    <td style="text-align:center ;" >{{$stt++}}</td>
                                    <td style="text-align:center ;" >{{$value->categoryDaily}}</td>
                                    <td style="text-align:left ;" >{!! nl2br($value->describeDaily) !!}</td>
                                    <td style="text-align:center ;" >{{$value->responsibility}}</td>
                                    <td style="text-align:center ;" >{!! nl2br($value->support) !!}</td>
                                    <td style="text-align:center ;" >{{ date('d/m/Y', strtotime($value->date)) }}</td>
                                    <td style="text-align:center ;" >{{$value->ResultByWookWeek}}%</td>
                                    @if ($value->Result=="Hoàn Thành")
                                    <td style="text-align:center ;color: white; background-color: green;border: 1px solid black!important" >{{$value->Result}}</td>
                                    @elseif ($value->Result=="Không hoàn Thành")
                                    <td style="text-align:center ;color: white; background-color: rgb(244, 1, 1);border: 1px solid black!important" >{{$value->Result}}</td>  
                                    @endif
                                    <td style="text-align:left ;" >{!! nl2br($value->inadequacy) !!}</td>
                                    <td style="text-align:left ;" >{!! nl2br($value->propose) !!}</td>
                                </tr>
                                @endif
                                @endforeach
                        </tbody>
                    </table>
                    @if (in_array($user['position_id'], [5, 6, 7, 8,9,10,11]))
                    <button id="send-email-btn" class="btn btn-info waves-effect waves-light">
                        <span>Send Email</span>
                        <i class="fab fa-telegram-plane ms-2"></i>
                    </button>
                    @endif
                </div>
                
            </div>
        </div>
    </div>
</div>
@include('include.footer')
<script>
// ------------------------------------------ JS TÌM KIẾM NHÓM --------------------------------------------------//     
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
// ------------------------------------------ GỞI MAIL --------------------------------------------------//    
$(document).on('click', '#send-email-btn', function() {
    // Hiển thị thông báo xác nhận trước khi gửi email
    Swal.fire({
        title: 'Bạn có muốn gởi mail không?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Gửi',
        cancelButtonText: 'Hủy bỏ'
    }).then((result) => {
        // Nếu người dùng xác nhận gửi email, thực hiện lệnh AJAX
        if (result.isConfirmed) {
            var token= $('meta[name="csrf-token"]').attr('content');
            var tableData = [];
            $('#table-report tr').each(function(row, tr) {
                tableData[row] = {
                    'stt': $(tr).find('td:eq(0)').text(),
                    'categoryDaily': $(tr).find('td:eq(1)').text(),
                    'describeDaily': $(tr).find('td:eq(2)').text(),
                    'responsibility': $(tr).find('td:eq(3)').text(),
                    'support': $(tr).find('td:eq(4)').text(),
                    'date': $(tr).find('td:eq(5)').text(),
                    'ResultByWookWeek': $(tr).find('td:eq(6)').text(),
                    'Result': $(tr).find('td:eq(7)').text(),
                    'inadequacy': $(tr).find('td:eq(8)').text(),
                    'propose': $(tr).find('td:eq(9)').text()
                }
            });
            
            $.ajax({
                url: "{!! route('sendmail') !!}",
                type: 'POST',
                data: {
                    _token: token,
                    tableData: tableData,
                },
                success: function(response) {
                    Swal.fire('Gởi mail thành công', '', 'success');
                },
                error: function(response) {
                    Swal.fire('Lỗi xảy ra', '', 'error');
                }
            });
        }
    });
});
</script>
