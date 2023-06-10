@php $title = "Quản lý kế hoạch ngày"; @endphp
@include('include.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
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
    th {
     
    text-align: center;
    vertical-align: middle;
}
td {
    vertical-align: middle;
}
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
                <form id="form_search" method="post" name="form_search">
                    @csrf
                    <div class="card-body" style="border: 1px solid; border-radius: 30px; ">
                        <div class="d-flex gap-2 flex-wrap">
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
                    <table id="" class="table table-bordered border-primary mb-0">
                        <thead>
                            <tr>
                                <th style="width: 2%;text-align:center ;" class="table-header">STT</th>
                                <th style="width: 12%;" style="text-align:center ;" class="table-header">Hạng mục công
                                    việc</th>
                                <th style="width: 12%; text-align:center ;" class="table-header">Nội dung công việc</th>
                                <th style="width: 7%;text-align:center ;" class="table-header">Giờ thực hiện</th>
                                <th style="text-align:center ;" class="table-header">Ngày\tháng\năm</th>
                                <th style="text-align:center ;" class="table-header">Trách nhiệm</th>
                                <th style="text-align:center ;" class="table-header">Hỗ trợ</th>
                                <th style="width: 2%;text-align:center ;" class="table-header">Mục tiêu</th>
                                <th style="text-align:center ;" class="table-header">Ghi chú</th>
                                <th style="text-align:center ;" class="table-header">Trạng thái</th>
                                <th style="text-align:center ;" class="table-header">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $stt = 1 @endphp
                            @if (!$workDaily->isEmpty())
                                @foreach ($workDaily as $key => $value)
                                @if ($value->status == 0 )
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
                                            @if ($value->status == 0)
                                                <td style="text-align: center;background-color: orange; color: black">Đang thực hiện</td>  
                                            @endif
                                            
                                            <td style="text-align: center;">
                                                @if ($value->responsibility == $user['name'] && $value->status == 0)
                                                    <a href="{{ route('reportDaily.get', $value->id) }}" class="btn btn-outline-primary waves-light btn-sm" title="Báo cáo"><i class="ri-book-mark-line"></i></a>
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

