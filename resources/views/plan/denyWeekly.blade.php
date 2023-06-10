@include('include.header')
<title>Quản lý kế hoạch tuần</title>
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
                <h4 class="card-title">Danh sách từ chối</h4>
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
                    @if (Session::has('successful'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                            <strong>Thông báo!</strong> Đã thêm thành công việc tuần thành công, hãy tìm kiếm để xem chi
                            tiết.
                        </div>
                    @elseif (Session::has('deleteSuccess'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                            <strong>Thông báo!</strong> Bạn đã xóa thành công.
                        </div>
                    @elseif (Session::has('status'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                            <strong>Thông báo!</strong> Chỉnh sửa công việc thành công.
                        </div>
                    @endif
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
                                <th style="width: 10%" rowspan="2" style="text-align:center ; vertical-align: middle;"
                                    class="table-header hidden-column col5">Hỗ trợ</th>
                                <th colspan="7" style="text-align:center ; vertical-align: middle;"
                                    class="table-header">Kế Hoạch</th>
                                <th rowspan="2" style="text-align:center ; vertical-align: middle;"
                                    class="table-header col1 hidden-column">Ghi chú</th>
                                <th rowspan="2"style="text-align:center ; vertical-align: middle;"
                                    class="table-header hidden-column">Thao tác</th>

                            </tr>
                            <tr>

                                <th style="text-align:center ;" class="table-header">Thứ 2<p>({{ $dates[0] }})
                                    </p>
                                </th>
                                <th style="text-align:center ;" class="table-header">Thứ 3<p>({{ $dates[1] }})
                                    </p>
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

                            @php
                                $stt = 1;
                                $dataExists = false;
                            @endphp

                            @if (!$workWeek->isEmpty())
                                @foreach ($workWeek as $value)
                                    @if ($value->status == 3 || $value->status == -1)
                                        <tr id="row-{{ $value->id }}">
                                            <td class="col1" style="text-align: center;">{{ $stt++ }}</td>
                                            <td class="left-align"> {{ $value->categoryWeek }} </td>
                                            <td style="white-space: normal" class="left-align  col3">
                                                {!! nl2br($value->describeWeek) !!}</td>
                                            <td style="white-space: normal" class="left-align  col3">
                                                {!! nl2br($value->responsibility) !!}</td>
                                            <td style="white-space: normal" class="left-align  col3">
                                                {!! nl2br($value->support) !!}</td>
                                            @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $index => $day)
                                                @if ($dates[$index] >= $value->startdate && $dates[$index] <= $value->enddate)
                                                    <td style="text-align: center; background-color: #85b7de;"><b
                                                            style="font-size: 15px">{{ $value->$day }}</b></td>
                                                @else
                                                    <td style="text-align: center;"></td>
                                                @endif
                                            @endforeach
                                            <td> {{ $value->note }} </td>
                                            <td style="text-align: center">
                                                @if ($value->responsibility == $user['name'] && $value->status == 3)
                                                <a href="{{ route('editWorkWeek', $value->id) }}" class="btn btn-outline-secondary btn-sm edit" title="Sửa"><i class="fas fa-pencil-alt"></i></a>
                                                <button type="button" class="btn btn-outline-danger btn-sm delete ri-delete-bin-line" title="Xóa" data-dialog="dialog-{{ $value->id }}"></button>
                                                @elseif ($value->responsibility == $user['name'] && $value->status == -1)
                                                <a href="{{route('updateWorkWeek',$value->id)}}" class="btn btn-outline-primary waves-light btn-sm update" title="Cập nhật công việc"><i class=" fas fa-cloud-upload-alt"></i></a>                                                @endif
                                            </td>
                                        </tr>
                                        @php $dataExists = true @endphp
                                    @endif
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
</div>
@include('include.footer')
<script>
       $(document).ready(function(){
                    $('.delete').click(function(){
                        var id = $(this).data('dialog').replace('dialog-', '');
                        $.ajax({
                            url: "{!! route('deleteWorkWeek') !!}",
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