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
        <h4 class="mb-sm-0">Báo cáo tuần</h4>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form id="form_search"  method="post">
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
                                    <option value="0">Tất cả</option>
                                    @foreach ($departments as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div><!-- /btn-group -->

                        @endif
                            <div class="btn-group">
                                <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;" class="card-title">
                                    Nhóm:</h4>
                                <select style="width:200px ;" class="form-control form-select" id="validationCustom03" name="teamId">
                                    <option value="">Tất cả</option>
                                    <option value=" echo $group['id'];"></option>
                                </select>
                            </div><!-- /btn-group -->
                            <div class="btn-group">
                                <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;" class="card-title">
                                    Nhân sự:</h4>
                                <select style="width:200px ;" class="form-control form-select" id="validationCustom03" name="userName">
                                    <option value="">Tất cả</option>
                                </select>
                            </div><!-- /btn-group -->
                            <div class="btn-group">
                                <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;" class="card-title">
                                    Ngày:</h4>
                                <input type="date" class="form-control" name="Day" id="validationTooltip01" placeholder="hãy nhập năm" required="">
                            </div>

                            <div class="btn-group">
                            </div>

                            <div style="margin-left: 1%;" class="btn-group">
                                <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                            </div>
                        </div><!-- /btn-group -->
                    </div>
                </form>

                <div class="table-responsive class scrollable-table-wrapper mt-5">
                 
                    <span style="font-size: 19px;"><strong>KẾ HOẠCH TUẦN:</strong> {{ $weekNumber }}
                        &emsp;&emsp;</span> <span style="font-size: 19px;"><strong> Từ:</strong> <span style="color: green;">{{ $formattedDateStart }}</span> <strong> Đến:</strong> <span style="color: green;">{{ $formattedDateEnd }}</span></span>
                    <table class="table table-sm m-0">
                        <thead>
                            <tr>
                                <th style="text-align:center ;" class="table-header">STT</th>
                                <th style="text-align:center ;" class="table-header">Hạng mục công việc</th>
                                <th style="text-align:center ;" class="table-header">Mô tả công việc</th>
                                <th style="text-align:center ;" class="table-header">Trách nhiệm</th>
                                <th style="text-align:center ;" class="table-header">Hỗ trợ</th>
                                <th style="text-align:center ;" class="table-header">Bất cập</th>
                                <th style="text-align:center ;" class="table-header">Đề xuất</th>
                                <th style="text-align:center ;width: 7%" class="table-header">Kết quả</th>
                                <th style="text-align:center ;" class="table-header">File</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $stt = 1 @endphp
                                @foreach ( $workWeek as $value)
                                    @if ($value->status == 4)
                                        <tr>
                                            <td style="text-align: center;"> {{ $stt++ }}</td>
                                            <td style=""> {{ $value->categoryWeek }} </td>
                                            <td style=""> {!! nl2br($value->describeWeek) !!}</td>
                                            <td style="text-align: center;"> {{ $value->responsibility }}</td>
                                            <td style="text-align: left;"> {!! nl2br($value->support) !!}</td>
                                            <td > {!! nl2br($value->inadequacy) !!}</td>
                                            <td > {!! nl2br($value->propose) !!} </td>
                                            <td style="text-align: center; color: #000000;font-size: 20px;width: 0;background-color: #11d3ff"> {{ $value->Result }}%</td>
                                            <td style="text-align: center; width: 0;font-size:20px"> @if($value->fileupload)<a href="{{ route('reportWeekly.download',$value->fileupload) }}" >Tải file</a> @else Không có file @endif</td>
                                        </tr>
                                    @endif
                                @endforeach   
                        </tbody>
                    </table>
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
    </script>
    