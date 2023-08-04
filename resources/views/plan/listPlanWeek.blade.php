@include('include.header')
<title>Quản lý kế hoạch tuần</title>

<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .modal-full {
        min-width: 80%;
    }

    td, th {
        min-width: 150px;
    }
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
        body * {
            visibility: hidden;
        }
        #preview-modal .modal-body, #preview-modal .modal-body *, #preview-modal .modal-header-info, #preview-modal .modal-header-info * {
            visibility: visible;
        }
        #preview-modal .modal-header,
        #preview-modal .modal-footer,
        #preview-modal .close {
            display: none;
        }
        #preview-modal .modal-header-info img {
            width: 40px;
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

                            @php $stt = 1; 
                            $dataExists = false;
                            @endphp
                            @if (!$workWeek->isEmpty())
                                @foreach ($workWeek as $value)

                                    @if ($value->startdate >= $start && $value->startdate < $end)
                                        @if ($value->status == 0)
                                        <tr>
                                            <td class="col1" style="text-align: center;"> {{ $stt++ }}</td>
                                            <td class="left-align col2"> {{ $value->categoryWeek }} </td>
                                            <td style="white-space: normal" class="left-align  col3">
                                                {!! nl2br($value->describeWeek) !!}</td>
                                            <td class="col4" style="text-align: center;">
                                                {{ $value->responsibility }}</td>
                                            <td class="col5 hidden-column" style="text-align: left;">
                                                {!! nl2br($value->support) !!}</td>
                                                @php
                                                $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                                            @endphp
                                            
                                            @foreach ($days as $index => $day)
                                                @if ($dates[$index] >= $value->startdate && $dates[$index] <= $value->enddate)
                                                    <td style="text-align: center; background-color: #85b7de;">
                                                        <b style="font-size: 15px">{{ $value->$day }}</b>
                                                    </td>
                                                @else
                                                    <td style="text-align: center;"></td>
                                                @endif
                                            @endforeach
                                            
                                           
                                            @if ($mydate < $value->startdate && $value->status == 0)
                                                <td class="hidden-column col6">Chưa đến hạng </td>
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
                                    @php
                                        $isInDateRange = $mydate >= $value->startdate && $mydate <= $value->enddate;
                                        $isOverDue = $mydate > $value->enddate;
                                        $isResponsible = $value->responsibility == $user->name;
                                        $isManager = in_array($user['position_id'], [3, 4, 5, 6]);
                                    @endphp

                                    <td class="hidden-column" style="text-align:center">
                                        @if ($isInDateRange && $value->status == 0 && $isResponsible)
                                            <a href="{{ route('formReportWeekly', $value->id) }}" class="btn btn-outline-primary waves-light btn-sm " title="Báo cáo"><i class="ri-book-mark-line"></i></a>
                                        @elseif($isOverDue && $value->status == 0)
                                            @if ($value->idreason == 0 && $isResponsible)
                                                <button type="button" class="btn btn-outline-secondary waves-effect waves-light lyDoBtn" data-item-id="{{ $value->id }}">Lý do</button>
                                            @elseif($value->idreason == 1 && $isManager)
                                                <button type="button" class="btn btn-outline-secondary waves-effect waves-light reason" data-reason-id="{{ $value->id }}" data-reason-type="{{ $value->idreason }}" data-reason-text="{{ $value->reason }}">Lý do</button>
                                            @elseif(($value->idreason == 2 && $isResponsible) || $isManager)
                                                <button type="button" class="btn btn-outline-success btn-sm reasontext" data-reason-id="{{ $value->id }}" data-reason-text="{{ $value->reason }}">Lý do</button>
                                                @if ($isResponsible)
                                                    <a href="{{ route('formReportWeekly', $value->id) }}" class="btn btn-outline-primary waves-light btn-sm " title="Báo cáo"><i class="ri-book-mark-line"></i></a>
                                                @endif
                                            @endif
                                        @endif
                                    </td>

                                    </tr>
                                    @php $dataExists = true; @endphp
                                    @endif
                                    @endif
                                @endforeach
                                @if (!$dataExists)
                                <tr>
                                    <td style="text-align: center;" colspan="15"> Không có dữ liệu</td>
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
                <button style="margin-top:3px" id="preview-btn" type="button"
                    class="btn btn-outline-info waves-effect mdi mdi-printer"> In công việc</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmModalLabel">Xác nhận</h5>
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Bạn có muốn bổ sung "Kiểm tra" trong bản in không?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="no-btn" data-dismiss="modal">Không</button>
          <button type="button" class="btn btn-primary" id="yes-btn">Có</button>
        </div>
      </div>
    </div>
  </div>
  
<div id="preview-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-full">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="preview-modal-label">Xem trước</h5>
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-header-info" style="display: flex; align-items: center;">
            @php
                $imagePath = public_path('assets/images/KIA.png');
                $imageData = base64_encode(file_get_contents($imagePath));
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $imagePath);
                finfo_close($finfo);
                $dataURL = "data:$mimeType;base64,$imageData";
            @endphp
            <img src="{{ $dataURL }}" alt="Logo" style="width: 220px; margin-right: 10px;">
            <div class="header-text" style="text-align: center; width: calc(100% - 180px);margin-right: 150px;">
                <h4 style="font-family: 'Cambria';" class="modal-title">KẾ HOẠCH CÔNG VIỆC TUẦN {{ $weekNumber }} THÁNG {{ $month }}</h4>
                <h3 style="font-family: 'Cambria';">Phòng: {{$user->department_name}}</h3>
            </div>
        </div>
        
        <div class="modal-body" style="overflow:auto;">
            
          <!-- nội dung xem trước sẽ được thêm vào đây -->
          
        </div>
        <div style="margin-top: 50px;" id="signatures">
            <div style="display: flex; justify-content: space-around;">
                <div>
                    <h5>Người lập</h5>
                </div>
                <div>
                    <h5 id="kiemtrakehoach">Kiểm tra</h5>
                </div>
                <div>
                    <h5>Phê duyệt</h5>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
          <button type="button" class="btn btn-primary printerTable">In</button>
        </div>
      </div>
    </div>
  </div>
  
@include('include.footer')
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

</script>
<script>
    // ------------------------------------------ JS IN TABLE --------------------------------------------------//      
    $(document).ready(function() {
        $('.btn.btn-secondary').click(function() {
            $('.modal').modal('hide');
        });
        $("#preview-btn").click(function() {
            // hiển thị modal hỏi trước khi hiển thị modal "Xem trước"
            $("#confirmModal").modal("show");
        });

        // Khi người dùng chọn "Có"
        $("#yes-btn").click(function() {
            preparePreviewModal(true);
        });

        // Khi người dùng chọn "Không"
        $("#no-btn").click(function() {
            preparePreviewModal(false);
        });

        // Chuẩn bị và hiển thị modal "Xem trước"
        function preparePreviewModal(isChecked) {
            console.log(isChecked)
            var content = $("#my-table").clone();
            content.find('th:contains("Hỗ trợ"), th:contains("Trạng thái"), th:contains("Ghi chú"), th:contains("Thao tác")').remove();
            content.find('td:nth-child(5), td:nth-child(13), td:nth-child(14), td:nth-child(15)').remove();

            // Ẩn hoặc hiện chữ "Kiểm tra" dựa vào sự lựa chọn của người dùng
            if (isChecked == false) {
                $(document).ready(function(){
                    $("#kiemtrakehoach").hide();
                })
                $("#confirmModal").modal("hide");
            }else{
                $(document).ready(function(){
                    $("#kiemtrakehoach").show();
                })
                $("#confirmModal").modal("hide");
            }

            // hiển thị nội dung vào một modal
            $("#preview-modal .modal-body").html(content);
            $("#preview-modal").modal("show");
        }

        $('.printerTable').click(function() {
            var headerContent = document.getElementById('preview-modal').getElementsByClassName('modal-header-info')[0].outerHTML;
            var bodyContent = document.getElementById('preview-modal').getElementsByClassName('modal-body')[0].outerHTML;
            var signatureContent = document.getElementById('signatures').outerHTML;
            var printContents = headerContent + bodyContent + signatureContent;            
            var printWindow = window.open('', '', 'width=800,height=600');
            printWindow.document.write('<html><head><title>In</title>');
            printWindow.document.write('<style type="text/css">');
            printWindow.document.write('@media print{');
            printWindow.document.write('table {border-collapse: collapse;}');
            printWindow.document.write('img {max-width: none !important; height: auto;}');
            printWindow.document.write('td, th {border: 1px solid black; padding: 5px; vertical-align: middle; text-align: center;}');
            printWindow.document.write('}');
            printWindow.document.write('</style>');
            printWindow.document.write('</head><body >');
            printWindow.document.write(printContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        });
    });


</script>