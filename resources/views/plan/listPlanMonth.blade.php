
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
        /* Vertically centers text */
    }
</style>
<div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">KẾ HOẠCH DÀI HẠN</h4>
    </div>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Danh sách công việc 
                <a href="{{route('creatWorkMonth')}}" class="btn btn-danger btn-rounded waves-effect waves-light"><i class="mdi mdi-plus me-1"></i> Tạo công việc tháng</a>
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
                            id="department-select" name="departmentsId">
                                <option value="">Tất cả</option>
                                @foreach ($departments as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div><!-- /btn-group -->
    
                    @endif
                        <div class="btn-group">
                            <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;" class="card-title">
                                Nhóm:</h4>
                            <select style="width:200px ;" class="form-control form-select" id="team-select"
                                name="teamId">
                                <option value="">Tất cả</option>
                                @foreach ($teams as $value)
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                               

                            </select>
                        </div>
                        <div class="btn-group">
                            <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;" class="card-title">
                                Nhân sự:</h4>
                            <select style="width:200px ;" class="form-control form-select" id="user-select"
                                name="userName">
                                <option value="">Tất cả</option>
                                @foreach ($users as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="btn-group">
                            <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;" class="card-title">
                                Ngày bắt đầu:</h4>
                            <input class="form-control" type="date" id="example-date-input"
                                id="validationCustom03" required="" name="startMonth">
                        </div>
                        <div class="btn-group">
                            <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;" class="card-title">
                                Ngày kết thúc:</h4>
                            <input class="form-control" type="date" id="example-date-input"
                                id="validationCustom03" required="" name="endMonth">
                        </div>
                        <div style="margin-left: 1%;" class="btn-group">
                            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                        </div>
                    </div>
                </div>
            </form>
            <table id="my-table" class="table table-bordered border-primary mb-0 mt-5">
                <thead>
                    <tr>
                        <th rowspan="2" style="text-align:center ; vertical-align: middle;" class="table-header col1">STT</th>
                        <th rowspan="2" style="text-align:center ; vertical-align: middle;" class="table-header col2">Hạng mục công việc</th>
                        <th rowspan="2" style="text-align:center ; vertical-align: middle;" class="table-header col3">Mô tả công việc</th>
                        <th rowspan="2" style="text-align:center ; vertical-align: middle;" class="table-header col4">Trách nhiệm</th>
                        <th rowspan="2" style="text-align:center ; vertical-align: middle;" class="table-header hidden-column col5">Hỗ trợ</th>
                        <th colspan="2" style="text-align:center ; vertical-align: middle;" class="table-header hidden-column col5">Thời gian</th>
                        <th rowspan="2" style="text-align:center ; vertical-align: middle;" class="table-header col1 hidden-column">Ghi chú</th>
                        <th rowspan="2" style="text-align:center ; vertical-align: middle;" class="table-header col1 hidden-column">Trạng thái</th>
                        <th rowspan="2" style="text-align:center ; vertical-align: middle;"  class="table-header hidden-column">Thao tác</th>
                    </tr>
                    <tr>
                        <th style="text-align:center ; vertical-align: middle;" class="table-header hidden-column col5">Bắt đầu</th>
                        <th style="text-align:center ; vertical-align: middle;" class="table-header hidden-column col5">Kết thúc</th>
                    </tr>
                </thead>
                <tbody>
                    @php  
                        $stt = 1;
                        $dataExists = false;
                    @endphp
                    @if (!$workmonths->isEmpty())
                        @foreach ($workmonths as $key => $workmonth)
                            <tr id="row-{{ $workmonth->id }}"> 
                                <td style="text-align:center; vertical-align: middle;">{{ $stt++ }}</td>
                                <td style="text-align:center; vertical-align: middle;">{{ $workmonth->categoryMonth }}</td>
                                <td style="text-align:center; vertical-align: middle;">{!! nl2br($workmonth->describeMonth) !!}</td>
                                <td style="text-align:center; vertical-align: middle;">{{ $workmonth->responsibility }}</td>
                                <td style="text-align:center; vertical-align: middle;">{!! nl2br($workmonth->support) !!}</td>
                                <td style="text-align:center; vertical-align: middle;">{{ \Carbon\Carbon::parse($workmonth->startMonth)->format('d/m/Y') }}</td>
                                <td style="text-align:center; vertical-align: middle;">{{ \Carbon\Carbon::parse($workmonth->endMonth)->format('d/m/Y') }}</td>
                                <td style="text-align:center; vertical-align: middle;">{{ $workmonth->note }}</td>
                                @if ($mydate < $workmonth->startMonth && $workmonth->status == 0)
                                                <td class="hidden-column col6">Chưa đến hạng </td>
                                            @elseif($mydate <= $workmonth->endMonth && $workmonth->status == 0)
                                                <td class="hidden-column col6"
                                                    style="text-align: center; background-color:yellow"> Đang thực
                                                    hiện </td>
                                            @elseif ($mydate > $workmonth->endMonth && $workmonth->status == 0)
                                                <td class="hidden-column col6"
                                                    style="color:#ffffff; text-align: center; background-color:red">
                                                    Trễ kế hoạch </td>
                                            @elseif ($workmonth->status == 1)
                                                <td class="hidden-column col6"
                                                    style="color:#ffffff; text-align: center; background-color:green">
                                                    Hoàn thành </td>
                                            @endif
                                <td style="text-align:center; vertical-align: middle;"> 
                                    @if ($workmonth->responsibility == $user['name'] && $workmonth->status == 0)
                                    <a href="{{ route('reportMonth.get', $workmonth->id) }}" class="btn btn-outline-primary waves-light btn-sm" title="Báo cáo"><i class="ri-book-mark-line"></i></a>
                                @endif
                                </td>
                               
                            </tr>
                            @php $dataExists = true @endphp
                        @endforeach
                        @if (!$dataExists)
                            <tr>
                                <td colspan="15" style="text-align: center;">Không có dữ liệu</td>
                            </tr>
                        @endif
                    @else
                        <tr>
                            <td style="text-align: center;" colspan="15"> Không có dữ liệu</td>
                        </tr>
                    @endif
                   
                </tbody>
            </table>
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
</script>