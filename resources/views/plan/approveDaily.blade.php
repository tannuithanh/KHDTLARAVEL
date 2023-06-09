@include('include.header')

<style>
    th {
        background-color: #16c745a2 !important;
        text-align: center;
        vertical-align: middle;
        color: #000000c9;
        font-size: 20px;
    }

    td,
    th {
        border-color: black !important;
        border: 1px solid black;
        font-size: 20px;
        font-family: 'Times New Roman', Times, serif;
        vertical-align: middle;
    }
</style>
<div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">Kế hoạch ngày</h4>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    Danh sách công việc <a href="{{ route('creatWorkDaily.get') }}"
                        class="btn btn-danger btn-rounded waves-effect waves-light"><i class="mdi mdi-plus me-1"></i>Tạo
                        công việc ngày</a>
                    @if (in_array($user['position_id'], [5, 6]))
                        <a style="margin-left: 6px;" href="{{ route('assignCreatWorkDaily.get') }}"
                            class="btn btn-warning btn-rounded waves-effect waves-light"><i
                                class="mdi mdi-plus me-1"></i> Giao việc</a>
                    @endif
                </h4>
                <form id="form_search" method="post" name="form_search">
                    @csrf
                    <div class="card-body" style="border: 1px solid; border-radius: 30px; ">
                        <div class="d-flex gap-2 flex-wrap">
                            @if (in_array($user['position_id'], [1, 2, 3, 4]))
                                <div class="btn-group">
                                    <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;"
                                        class="card-title">
                                        Phòng:</h4>
                                    <select style="width:200px ;" class="form-control form-select"
                                        id="validationCustom03" name="departmentsId">
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
                                <select style="width:200px ;" class="form-control form-select" id="validationCustom03"
                                    name="teamId">
                                    <option value="">Tất cả</option>
                                    @foreach ($teams as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="btn-group">
                                <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;" class="card-title">
                                    Nhân sự:</h4>
                                <select style="width:200px ;" class="form-control form-select" id="validationCustom03"
                                    name="userName">
                                    <option value="">Tất cả</option>
                                    @foreach ($userById as $value)
                                        <option value="{{ $value->name }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="btn-group">
                                <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;" class="card-title">
                                    Ngày:</h4>
                                <input class="form-control" type="date" id="example-date-input"
                                    id="validationCustom03" required="" name="Day">
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
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                            <strong>Thông báo!</strong> Cập nhật thành công.
                        </div>
                    @endif
                    <table id="" class="table table-bordered border-primary mb-0">
                        <thead>
                            <tr>
                                <th style="text-align:center ;" class="table-header">STT</th>
                                <th style="width: 20%;" style="text-align:center ;" class="table-header">Hạng mục công
                                    việc</th>
                                <th style="text-align:center ;" class="table-header">Nội dung công việc</th>
                                <th style="text-align:center ;" class="table-header">Giờ thực hiện</th>
                                <th style="text-align:center ;" class="table-header">Ngày\tháng\năm</th>
                                <th style="text-align:center ;" class="table-header">Trách nhiệm</th>
                                <th style="text-align:center ;" class="table-header">Hỗ trợ</th>
                                <th style="text-align:center ;" class="table-header">Mục tiêu</th>
                                <th style="text-align:center ;" class="table-header">Ghi chú</th>
                                <th style="text-align:center ;" class="table-header">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $stt = 1 @endphp
                            @if (!$workDaily->isEmpty())
                                @foreach ($workDaily as $key => $value)
                                @if (($value->status == 1 && $user['position_id'] == 7) || ($value->status == 1 && $value->responsibility == $user['name']))
                                        <tr id="row-{{ $value->id }}">
                                            <td style="text-align: center;">{{ $stt++ }}</td>
                                            <td class="left-align">{{ $value->categoryDaily }}</td>
                                            <td class="left-align" style="text-align: left;">{!! nl2br($value->describeDaily) !!}
                                            </td>
                                            @if (is_numeric($value->time))
                                                <td style="text-align: center;">{{ $value->time }} giờ</td>
                                            @else
                                                <td style="text-align: center; color:red;">{{ $value->time }}</td>
                                            @endif
                                            <td style="text-align: center;">
                                                {{ date('d/m/Y', strtotime($value->date)) }}</td>
                                            <td style="text-align: center;">{{ $value->responsibility }}</td>
                                            <td style="text-align: center;">{!! nl2br($value->support) !!}</td>
                                            <td style="text-align: center;">{{ $value->ResultByWookWeek }}%</td>
                                            <td style="text-align: center;">{{ $value->note }}</td>
                                            <td style="text-align: center;">
                                                @if ($user['position_id'] == 7 )
                                                    <button type="button"
                                                    class="btn duyettruongnhom btn-sm btn-outline-warning waves-effect waves-light ri-checkbox-line"
                                                    title="Chấp thuận trưởng nhóm"
                                                    data-dialog="dialog-{{ $value->id }}"></button>
                                                    <button type="button"
                                                    class="btn tuchoitruongnhom btn-sm btn-outline-danger waves-effect waves-light  ri-checkbox-indeterminate-line"
                                                    title="Từ chối trưởng nhóm"
                                                    data-dialog="dialog-{{ $value->id }}"></button>
                                                @endif
                                            </td>
                                        </tr>
                                        @elseif(($value->status == 2 && ($user['position_id'] == 5 || $user['position_id'] == 6)) || ($value->status == 2 && $value->responsibility == $user['name']) )
                                        <tr id="row-{{ $value->id }}" >
                                            <td style="text-align: center;">{{ $stt++ }}</td>
                                            <td class="left-align">{{ $value->categoryDaily }}</td>
                                            <td class="left-align" style="text-align: left;">{!! nl2br($value->describeDaily) !!}
                                            </td>
                                            @if (is_numeric($value->time))
                                                <td style="text-align: center;">{{ $value->time }} giờ</td>
                                            @else
                                                <td style="text-align: center; color:red;">{{ $value->time }}</td>
                                            @endif
                                            <td style="text-align: center;">
                                                {{ date('d/m/Y', strtotime($value->date)) }}</td>
                                            <td style="text-align: center;">{{ $value->responsibility }}</td>
                                            <td style="text-align: center;">{!! nl2br($value->support) !!}</td>
                                            <td style="text-align: center;">{{ $value->ResultByWookWeek }}%</td>
                                            <td style="text-align: center;">{{ $value->note }}</td>
                                            <td style="text-align: center;">
                                                @if ($user['position_id'] == 5 || $user['position_id'] == 6)
                                                    <button type="button"
                                                    class="btn truongphongduyet btn-sm btn-outline-primary waves-effect waves-light ri-checkbox-line"
                                                    title="Chấp thuận trưởng phòng"
                                                    data-dialog="dialog-{{ $value->id }}"></button>
                                                    <button type="button"
                                                    class="btn truongphongtuchoi btn-sm btn-outline-danger waves-effect waves-light  ri-checkbox-indeterminate-line"
                                                    title="Từ chối Trưởng phòng"
                                                    data-dialog="dialog-{{ $value->id }}"></button>                              
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" style="text-align: center;">Không có dữ liệu</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('include.footer')
<script>
        // ------------------------------------------ JS TÌM KIẾM PHÒNG BAN --------------------------------------------------//    
        $(document).ready(function() {
        $('[name="departmentsId"]').on('change', function() {
            var departmentId = $('[name="departmentsId"]').val();
            if (departmentId) {
                $.ajax({
                    url: "{!! route('listWorkWeekdepartments') !!}",
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

                        } else {
                            options = '<option value="0">Tất cả</option>';
                        }
                        $('select[name="teamId"]').html(options1).attr('selected',
                            'selected');;

                        var options = '<option value="">Tất cả</option>';
                        if (response.users && response.users.length > 0) {
                            $.each(response.users, function(index, user) {
                                options += '<option value="' + user.name + '">' +
                                    user
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
                url: "{!! route('listWorkWeekUsers') !!}",
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
//------------ DUYỆT TP/PP -----------//
        $(document).ready(function(){
            $('.truongphongduyet').click(function(){
                var id = $(this).data('dialog').replace('dialog-', '');
                $.ajax({
                    url: "{!! route('aprroveTP') !!}",
                    method: 'POST',            // Phương thức gửi dữ liệu
                    data: {
                            id: id,
                            _token: '{!! csrf_token() !!}' // Đổi 'token' thành '_token'
                        },
                    success: function(data) {  // Hàm xử lý khi nhận được phản hồi thành công từ server
                        $('#row-' + id).fadeOut();
                    },
                    error: function(data) {    // Hàm xử lý khi nhận được phản hồi lỗi từ server
                    
                    }
                });
            });
        });
//------------ TỪ CHỐI TP/PP -----------//
        $(document).ready(function(){
            $('.truongphongtuchoi').click(function(){
                var id = $(this).data('dialog').replace('dialog-', '');
                $.ajax({
                    url: "{!! route('denyTP') !!}",
                    method: 'POST',            // Phương thức gửi dữ liệu
                    data: {
                            id: id,
                            _token: '{!! csrf_token() !!}' // Đổi 'token' thành '_token'
                        },
                    success: function(data) {  // Hàm xử lý khi nhận được phản hồi thành công từ server
                        $('#row-' + id).fadeOut();
                    },
                    error: function(data) {    // Hàm xử lý khi nhận được phản hồi lỗi từ server
                    
                    }
                });
            });
        });

//----------- DUYỆT TN---------//
    $(document).ready(function(){
                $('.duyettruongnhom').click(function(){
                    var id = $(this).data('dialog').replace('dialog-', '');
                    $.ajax({
                        url: "{!! route('aprroveTN') !!}",
                        method: 'POST',            // Phương thức gửi dữ liệu
                        data: {
                                id: id,
                                _token: '{!! csrf_token() !!}' // Đổi 'token' thành '_token'
                            },
                        success: function(data) {  // Hàm xử lý khi nhận được phản hồi thành công từ server
                            $('#row-' + id).fadeOut();
                        },
                        error: function(data) {    // Hàm xử lý khi nhận được phản hồi lỗi từ server
                        
                        }
                    });
                });
            });
//----------- TỪ CHỐI TN---------//
    $(document).ready(function(){
                    $('.tuchoitruongnhom').click(function(){
                        var id = $(this).data('dialog').replace('dialog-', '');
                        $.ajax({
                            url: "{!! route('denyTN') !!}",
                            method: 'POST',            // Phương thức gửi dữ liệu
                            data: {
                                    id: id,
                                    _token: '{!! csrf_token() !!}' // Đổi 'token' thành '_token'
                                },
                            success: function(data) {  // Hàm xử lý khi nhận được phản hồi thành công từ server
                                $('#row-' + id).fadeOut();
                            },
                            error: function(data) {    // Hàm xử lý khi nhận được phản hồi lỗi từ server
                            
                            }
                        });
                    });
                });
</script>