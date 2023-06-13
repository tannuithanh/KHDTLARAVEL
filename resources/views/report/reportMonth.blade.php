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
        <h4 class="mb-sm-0">KẾ HOẠCH THÁNG</h4>
    </div>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Danh sách công việc</h4>
        
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
                        </div><!-- /btn-group -->
    
                    @endif
                        <div class="btn-group">
                            <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;" class="card-title">
                                Nhóm:</h4>
                            <select style="width:200px ;" class="form-control form-select" id="validationCustom03"
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
                            <select style="width:200px ;" class="form-control form-select" id="validationCustom03"
                                name="userName">
                                <option value="">Tất cả</option>
                                @foreach ($users as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
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
            <table id="my-table" class="table table-bordered border-primary mb-3 mt-5">
                <thead>
                    <tr>
                        <th rowspan="2" style="text-align:center ; vertical-align: middle;" class="table-header col1">STT</th>
                        <th rowspan="2" style="text-align:center ; vertical-align: middle;" class="table-header col2">Hạng mục công việc</th>
                        <th rowspan="2" style="text-align:center ; vertical-align: middle;" class="table-header col3">Mô tả công việc</th>
                        <th rowspan="2" style="text-align:center ; vertical-align: middle;" class="table-header col4">Trách nhiệm</th>
                        <th rowspan="2" style="text-align:center ; vertical-align: middle;" class="table-header hidden-column col5">Hỗ trợ</th>
                        <th colspan="2" style="text-align:center ; vertical-align: middle;" class="table-header hidden-column col5">Thời gian</th>
                        <th rowspan="2" style="text-align:center ; vertical-align: middle;" class="table-header col1 hidden-column">Ghi chú</th>

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
