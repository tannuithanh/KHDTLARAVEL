@include('include.header')
<title>Quản lý kế hoạch tuần</title>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.4/sweetalert2.min.css"
        integrity="sha512-gIGX9wkL4l4+e4im+rM8WZ7VccvY2uUR7V+xdh8Waj7T0y0UsD94jKpCZU6oz+U6/CJn6e7UQLpWO1xGOn11/Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<meta name="csrf-token" content="{{ csrf_token() }}">
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

    :root {
        --col3: 300px;
        --col2: 300px;
    }

    @media print {

        @page {
            margin: 10mm;
            size: A4;

        }

        td,
        th {
            font-family: 'Times New Roman', Times, serif;
        }

        table.print-table th {
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            -webkit-filter: brightness(0) invert(1);
            filter: brightness(0) invert(1);
            background-color: gray;
            color: white;
        }

        td {
            width: 100% !important;
            white-space: pre-wrap;
        }

        th {
            width: auto !important;
        }

        table.print-table {
            width: 100%;
            max-width: 700px;
        }

        .hidden-column {
            display: none !important;
        }

        .left-align {
            text-align: left;
        }

        .print-table {
            border: 1px solid #000 !important;
        }

        .print-table th {
            font-weight: bold !important;
        }

        .col1,
        .col2,
        .col3,
        .col4,
        .col5,
        .col6,
        .col7,
        .col20 {
            font-size: 19px;
            font-family: 'Times New Roman', Times, serif;
        }

        .col3 {
            max-width: var(--col3);
            min-width: var(--col3);
            white-space: normal;
        }

        .col2 {
            white-space: normal !important;
            max-width: var(--col2);
            min-width: var(--col2);
        }
    }

    .col3 {
        max-width: var(--col3);
        min-width: var(--col3);
        white-space: wrap !important;
        font-size: 19px;
        font-family: 'Times New Roman', Times, serif;
    }

    .col1,
    .col3,
    .col4,
    .col5,
    .col6,
    .col7 {
        font-size: 19px;
        font-family: 'Times New Roman', Times, serif;
    }

    .col2 {
        white-space: normal !important;
        max-width: var(--col2);
        min-width: var(--col2);
        font-size: 19px;
        font-family: 'Times New Roman', Times, serif;
    }
</style>
<div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">Kế hoạch tuần</h4>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Danh sách công việc </h4>
                <form id="form_search" action="{{ route('listWorkWeek') }}" method="post">
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
                                <select style="width:200px ;" class="form-control form-select teams"
                                    id="validationCustom03" name="teamId">
                                    <option value="0">Tất cả</option>
                                    @foreach ($teams as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach

                                </select>
                            </div><!-- /btn-group -->
                            <div class="btn-group">
                                <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;" class="card-title">
                                    Nhân sự:</h4>
                                <select style="width:200px ;" class="form-control form-select users"
                                    id="validationCustom03" name="userName">
                                    <option value="">Tất cả</option>
                                    @foreach ($userById as $value)
                                        <option value="{{ $value->name }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div><!-- /btn-group -->
                            <div class="btn-group">
                                <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;" class="card-title">
                                    Ngày:</h4>
                                <input type="date" class="form-control" name="Day" id="validationTooltip01"
                                    placeholder="hãy nhập năm" required="">
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
                    <span style="font-size: 19px;"><strong>KẾ HOẠCH TUẦN:</strong> <span
                            style="color: green;">{{ $weekNumber }} </span>&emsp;&emsp;</span><span
                        style="font-size: 19px;"><strong>THÁNG:</strong> <span
                            style="color: green;">{{ $month }}</span> <strong>&emsp; TỪ:</strong> <span
                            style="color: green;">{{ $formattedDateStart }}</span> <strong> Đến:</strong> <span
                            style="color: green;">{{ $formattedDateEnd }}</span></span>
                    <table id="my-table" class="table table-bordered border-primary mb-0">
                        <thead>
                            <tr>
                                <th rowspan="2" style="text-align:center ; vertical-align: middle;"
                                    class="table-header col1">STT</th>
                                <th rowspan="2" style="text-align:center ; vertical-align: middle;"
                                    class="table-header col2">Hạng mục công việc</th>
                                <th rowspan="2" style="text-align:center ; vertical-align: middle;"
                                    class="table-header col3">Mô tả công việc</th>
                                <th rowspan="2" style="text-align:center ; vertical-align: middle;"
                                    class="table-header col4">Trách nhiệm</th>
                                <th rowspan="2" style="text-align:center ; vertical-align: middle;"
                                    class="table-header hidden-column col5">Hỗ trợ</th>
                                <th colspan="7" style="text-align:center ; vertical-align: middle;"
                                    class="table-header">Kế Hoạch</th>
                                <th rowspan="2" style="text-align:center ; vertical-align: middle;"
                                    class="table-header col6 hidden-column">Trạng thái</th>
                                <th rowspan="2" style="text-align:center ; vertical-align: middle;"
                                    class="table-header col1 hidden-column">Ghi chú</th>
                                <th rowspan="2"style="text-align:center ; vertical-align: middle;"
                                    class="table-header hidden-column">Thao tác</th>

                            </tr>
                            <tr>

                                <th style="text-align:center ;" class="table-header">Thứ 2<p>({{ $dates[0] }})</p>
                                </th>
                                <th style="text-align:center ;" class="table-header">Thứ 3<p>({{ $dates[1] }})</p>
                                </th>
                                <th style="text-align:center ;" class="table-header">Thứ 4<p>({{ $dates[2] }})
                                    </p>
                                </th>
                                <th style="text-align:center ;" class="table-header">Thứ 5<p>({{ $dates[3] }})
                                    </p>
                                </th>
                                <th style="text-align:center ;" class="table-header">Thứ 6<p>({{ $dates[4] }})
                                    </p>
                                </th>
                                <th style="text-align:center ;" class="table-header">Thứ 7<p>({{ $dates[5] }})
                                    </p>
                                </th>
                                <th style="text-align:center ;" class="table-header">Chủ nhật<p>({{ $dates[6] }})
                                    </p>
                                </th>

                            </tr>
                        </thead>
                        <tbody>

                            @php $stt = 1 @endphp
                            @if (!$workWeek->isEmpty())

                                @foreach ($workWeek as $value)
                                    @if ($value->startdate >= $start && $value->startdate < $end)
                                        <tr>
                                            <td class="col1" style="text-align: center;"> {{ $stt++ }}</td>
                                            <td class="left-align col2"> {{ $value->categoryWeek }} </td>
                                            <td style="white-space: normal" class="left-align  col3">
                                                {!! nl2br($value->describeWeek) !!}</td>
                                            <td class="col4" style="text-align: center;">
                                                {{ $value->responsibility }}</td>
                                            <td class="col5 hidden-column" style="text-align: left;">
                                                {!! nl2br($value->support) !!}</td>
                                            {{-- <td style="text-align: center;"> {{ $dates[0] }}</td> --}}
                                            @if ($dates[0] >= $value->startdate && $dates[0] <= $value->enddate)
                                                <td style="text-align: center; background-color: #85b7de;"><b
                                                        style="font-size: 15px">{{ $value->monday }}</b></td>
                                            @else
                                                <td style="text-align: center;"></td>
                                            @endif
                                            @if ($dates[1] >= $value->startdate && $dates[1] <= $value->enddate)
                                                <td style="text-align: center; background-color: #85b7de;"><b
                                                        style="font-size: 15px">{{ $value->tuesday }}</b></td>
                                            @else
                                                <td style="text-align: center;"></td>
                                            @endif
                                            @if ($dates[2] >= $value->startdate && $dates[2] <= $value->enddate)
                                                <td style="text-align: center; background-color: #85b7de;"><b
                                                        style="font-size: 15px">{{ $value->wednesday }}</b></td>
                                            @else
                                                <td style="text-align: center;"></td>
                                            @endif
                                            @if ($dates[3] >= $value->startdate && $dates[3] <= $value->enddate)
                                                <td style="text-align: center; background-color: #85b7de;"><b
                                                        style="font-size: 15px">{{ $value->thursday }}</b></td>
                                            @else
                                                <td style="text-align: center;"></td>
                                            @endif
                                            @if ($dates[4] >= $value->startdate && $dates[4] <= $value->enddate)
                                                <td style="text-align: center; background-color: #85b7de;"><b
                                                        style="font-size: 15px">{{ $value->friday }}</b></td>
                                            @else
                                                <td style="text-align: center;"></td>
                                            @endif
                                            @if ($dates[5] >= $value->startdate && $dates[5] <= $value->enddate)
                                                <td style="text-align: center; background-color: #85b7de;"><b
                                                        style="font-size: 15px">{{ $value->saturday }}</b></td>
                                            @else
                                                <td style="text-align: center;"></td>
                                            @endif
                                            @if ($dates[6] >= $value->startdate && $dates[6] <= $value->enddate)
                                                <td style="text-align: center; background-color: #85b7de;"><b
                                                        style="font-size: 15px">{{ $value->sunday }}</b></td>
                                            @else
                                                <td style="text-align: center;"></td>
                                            @endif
                                            @if ($value->status == -1)
                                                <td class=" hidden-column"
                                                    style="color:white;text-align: center;background-color:rgb(81, 82, 82); ">
                                                    Chưa cập nhật</td>
                                            @elseif ($mydate < $value->startdate && $value->status == 0)
                                                <td class="hidden-column col6"
                                                    style="color:#ffffff;text-align: center; background-color:rgb(133, 58, 219)">
                                                    Chưa đến hạng </td>
                                            @elseif($mydate <= $value->enddate && $value->status == 0)
                                                <td class="hidden-column col6"
                                                    style="text-align: center; background-color:yellow"> Đang thực
                                                    hiện </td>
                                            @elseif ($mydate > $value->enddate && $value->status == 0)
                                                <td class="hidden-column col6"
                                                    style="color:#ffffff; text-align: center; background-color:red">
                                                    Trễ kế hoạch </td>
                                            @elseif ($value->status == 1)
                                                <td class="hidden-column col6"
                                                    style="color:#ffffff; text-align: center; background-color:green">
                                                    Hoàn thành </td>
                                            @endif
                                            <td style="text-align: left; "class="hidden-column xuongdong col7">
                                                {{ $value->note }}</td>
                                    @endif
                                    <td class="hidden-column" style="text-align:center">
                                        @if ($value->status != -1)
                                            @if ($mydate <= $value->enddate && $mydate >= $value->startdate && $value->status == 0)
                                                @if ($value->responsibility == $user->name)
                                                    <a href="{{ route('formReportWeekly', $value->id) }}"
                                                        class="btn btn-outline-primary waves-light btn-sm "
                                                        title="Báo cáo"><i class="ri-book-mark-line"></i></a>
                                                @endif
                                            @elseif($mydate > $value->enddate && $value->status == 0)
                                                @if ($value->idreason == 0 && $value->responsibility == $user->name)
                                                    <button type="button"
                                                        class="btn btn-outline-secondary waves-effect waves-light lyDoBtn"
                                                        data-item-id="{{ $value->id }}">Lý do</button>
                                                @elseif(
                                                    $value->idreason == 1 &&
                                                        ($user['position_id'] == 3 ||
                                                            $user['position_id'] == 4 ||
                                                            $user['position_id'] == 5 ||
                                                            $user['position_id'] == 6))
                                                    <button type="button"
                                                        class="btn btn-outline-secondary waves-effect waves-light reason"
                                                        data-reason-id="{{ $value->id }}"
                                                        data-reason-type="{{ $value->idreason }}"
                                                        data-reason-text="{{ $value->reason }}">Lý do</button>
                                                @elseif(
                                                    ($value->idreason == 2 && $value->responsibility == $user->name) ||
                                                        ($user['position_id'] == 3 ||
                                                            $user['position_id'] == 4 ||
                                                            $user['position_id'] == 5 ||
                                                            $user['position_id'] == 6))
                                                    <button type="button"
                                                        class="btn btn-outline-success btn-sm reasontext"
                                                        data-reason-id="{{ $value->id }}"
                                                        data-reason-text="{{ $value->reason }}">Lý do</button>
                                                    @if ($value->responsibility == $user->name)
                                                        <a href="{{ route('formReportWeekly', $value->id) }}"
                                                            class="btn btn-outline-primary waves-light btn-sm "
                                                            title="Báo cáo"><i class="ri-book-mark-line"></i></a>
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="text-align: center;" colspan="15"> Không có dữ liệu</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <button style="margin-top:3px" id="preview-btn" type="button"
                    class="btn btn-outline-info waves-effect mdi mdi-printer"> In công việc</button>
            </div>
        </div>
    </div>
</div>
@include('include.footer')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript">
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
    // ------------------------------------------ JS NHẬP LÝ DO --------------------------------------------------//     
    $(document).ready(function() {
        $(".lyDoBtn").click(function() {
            const itemId = $(this).data("item-id");
            const $btn = $(this);
            Swal.fire({
                title: 'Nhập lý do',
                html: '<textarea id="lydo" class="swal2-textarea" placeholder="Nhập lý do"></textarea>',
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy bỏ',
                allowOutsideClick: false,
                preConfirm: () => {
                    const lydo = Swal.getPopup().querySelector('#lydo').value
                    if (!lydo) {
                        Swal.showValidationMessage(`Vui lòng nhập lý do`)
                    }
                    return {
                        itemId: itemId,
                        lydo: lydo
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const itemId = result.value.itemId;
                    const lydo = result.value.lydo;
                    $.ajax({
                        url: "{!! route('updateReason') !!}",
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            itemId: itemId,
                            lydo: lydo
                        },
                        success: function(response) {
                            $('.lyDoBtn[data-item-id="' + itemId + '"]').css(
                                'display', 'none');
                        },
                        error: function(error) {
                            // Handle error response
                        }
                    });
                }
            });
        });
    });
    // ------------------------------------------ JS KIỂM TRA LÝ DO --------------------------------------------------//         
    $(document).on('click', '.reason', function() {
        const $btn = $(this);
        const itemId = $(this).data("reason-id");
        const reason = $(this).data("reason-text");
        const positionId = "{{ $user['position_id'] }}";
        let showDenyButton = false;
        let denyButtonText = '';
        let confirmButtonClass = '';
        let confirmButtonText = '';
        let confirmAction = '';

        if (positionId == 4 || positionId == 5 || positionId == 3 || positionId == 6) {
            showDenyButton = true;
            denyButtonText = 'Từ chối';
            confirmButtonClass = 'btn-success';
            confirmButtonText = 'Đồng ý';
            confirmAction = 'update';
            customClass = '';
        } else {
            confirmButtonClass = 'btn-secondary';
            confirmButtonText = 'Trở về';
            customClass = {
                confirmButton: 'custom-confirm-button-class'
            }
        }

        Swal.fire({
            title: 'Lý do',
            text: reason,
            showDenyButton: showDenyButton,
            showCancelButton: false,
            confirmButtonText: confirmButtonText,
            confirmButtonClass: confirmButtonClass,
            denyButtonText: denyButtonText,
            customClass: customClass,
        }).then((result) => {
            if (result.isConfirmed) {
                if (confirmAction === 'update') {
                    $.ajax({
                        url: "{!! route('acceptReason') !!}",
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            reason_id: itemId
                        },
                        success: function(response) {
                            $('.reason[data-reason-id="' + itemId + '"]').css('display',
                                'none');
                            // $(`<a href="{{ route('formReportWeekly', '') }}/${itemId}" class="btn btn-outline-primary waves-light btn-sm" title="Báo cáo"><i class="ri-book-mark-line"></i></a>`).insertAfter($btn);                    
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            // handle error
                        }
                    });
                } else {
                    // handle other action
                }
            } else if (result.isDenied) {
                $.ajax({
                    url: "{!! route('denyReason') !!}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        reason_id: itemId
                    },
                    success: function(response) {
                        $('.reason[data-reason-id="' + itemId + '"]').css('display',
                        'none');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // handle error
                    }
                });
            }
        });
    });
    // ------------------------------------------ JS HIỂN THỊ LÝ DO --------------------------------------------------//      
    $(document).on('click', '.reasontext', function() {
        const reason = $(this).data("reason-text");

        Swal.fire({
            title: 'Lý do',
            text: reason,
            confirmButtonText: 'Đóng',
            confirmButtonClass: 'btn-secondary',
            customClass: {
                confirmButton: 'custom-confirm-button-class'
            }
        });
    });
    // ------------------------------------------ JS IN TABLE --------------------------------------------------//      
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    const formattedDateStart = "{{ $formattedDateStart }}"; // đưa biến formattedDateStart từ PHP vào JavaScript
    const department = "{{ $user->department_id }}"; // đưa biến department từ PHP vào JavaScript
    const team = "{{ $user->team_name }}"; // đưa biến team từ PHP vào JavaScript
    const formattedDateEnd = "{{ $formattedDateEnd }}";
    const departmentName = "{{ $user->department_name }}";
    const weeknumber = "{{ $weekNumber }}"; // đưa biến weeknumber từ PHP vào JavaScript
    var logoImage = "{{ asset('assets/images/KIA.png') }}";
    // $(document).ready(function() {

    // });
    $('#preview-btn').click(function() {
        const tableHtml = $('#my-table').prop('outerHTML');
        const $table = $(tableHtml);

        $table.find('.hidden-column').each(function() {
            $(this).attr('style', 'display:none !important');
        });

        $table.find('.left-align').each(function() {
            $(this).css('text-align', 'left');
        });

        $table.find('th').css({
            'background-color': 'black',
            'color': 'white',
            'font-weight': '900',
            'font-size': '16px',
        });
        $table.find('.col3').css({
            'white-space': 'wrap',
            'max-width': '180px',
            'min-width': '180px',
        });
        $table.find('.col2').css({
            'white-space': 'normal',
            'max-width': '180px',
            'min-width': '180px',
        });
        $table.find('td').css({
            'color': 'black',
        });
        $table.css('font-size', '12px');

        let headerHtml =
            `<div style="font-size: 20px; margin-top:40px;  text-align: center;"><b>KẾ HOẠCH CÔNG VIỆC TUẦN:</b> ${weeknumber}</div>`;
        headerHtml +=
            `<div style="font-size: 20px;   text-align: center;"><b>TỪ NGÀY:</b> ${formattedDateStart} - <b>ĐẾN NGÀY:</b> ${formattedDateEnd} </div>`;
        headerHtml +=
            `<div style="font-size: 20px;   text-align: center;"><b>PHÒNG:</b> ${departmentName}</div>`;
        headerHtml += `<div style="font-size: 20px;   text-align: center;"><b>Nhóm:</b> ${team}</div>`;
        headerHtml +=
            `<img src="${logoImage}" alt="KIA" style="width: 221px;height: 48px;position: absolute;top:0;left: 40px; margin-top:40px;  " id="logo-img">`;
        let tannuithanh = `<div style="display:flex; align-items:center;margin-top: 40px;margin-left: 50px;">`
        let temp =
            'font-size: 12px; font-family: "Times New Roman", Times, serif; white-space: nowrap; width: max-content;'
        tannuithanh += `<h1 style="text-align: right;${temp}">Phê duyệt</h1>`;
        tannuithanh += `<h1 style="text-align: center;margin-left:400px;${temp}">Trưởng phòng</h1>`;
        tannuithanh += `<h1 style="text-align: right;;margin-left:400px;${temp}">Người lập</h1>`;
        tannuithanh += '</div>';
        $table.css({
            'margin-left': 'auto',
            'margin-right': 'auto',
            'display': 'table'
        });

        const printContents = headerHtml + $table[0].outerHTML + tannuithanh;

        Swal.fire({
            html: printContents,
            width: "auto",
            padding: "1rem",
            backdrop: true,
            showCloseButton: false,
            showCancelButton: true,
            confirmButtonText: "In",
            cancelButtonText: "Hủy bỏ",
            didClose: () => {
                $table.find('.hidden-column').removeAttr('style');
                $table.find('.left-align').css('text-align', 'center');
            },
            willOpen: () => {
                let _$ = $('.swal2-container')[0]
                _$.style.display = 'flex'
                console.log(_$.style.display, "wwwww")
            },
            willClose: (e) => {
                let _$ = $('.swal2-container')[0]
                _$.style.display = 'none'
                console.dir(_$)
            }

        }).then(function(result) {
            if (result.isConfirmed) {
                const originalContents = document.body.innerHTML;

                const printCSS =
                    '<style type="text/css"> table.print-table th, table.print-table td {border: 1px solid black; font-weight: bold; }</style>';

                document.body.innerHTML =
                    '<html><head><title></title><style>@media print { @page {size: a4 landscape; margin: 0;}table.print-table {width: 80%;max-width: 800%;}}</style></head><body>' +
                    printContents + '</body></html>';

                window.print();

                document.body.innerHTML = originalContents;
            }
        });

        $('.swal2-actions').append($('.swal2-cancel').detach());
        $('.swal2-content table').addClass('print-table');
    });
</script>
