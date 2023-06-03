@include('include.header')
<title>Quản lý Dự Án</title>
<header>
   
</header>
<style>
    td, th{
        font-size: 22px;
    }
    .colortext {
    color: #3031ed;
        text-decoration: none;
    }
    .colortext1 {
    color: #000000;
        text-decoration: none;
    }
</style>
<div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0" style="font-size:20px">Quản lý dự án</h4>
    </div>
    
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title" style="font-size:30px;font-family: 'Times New Roman', Times, serif !important;font-weight: bold">KẾ HOẠCH PHÁT TRIỂN SẢN PHẨM NĂM 2023 R&D Ô TÔ</h4>
                <h4 class="card-title" style="font-size:30px;font-family: 'Times New Roman', Times, serif !important;font-weight: bold ">TỔNG SỐ DỰ ÁN ĐANG PHÁT TRIỂN: <span style="color: red">{{$totalProjects}}</span></h4>
                <a href="{{route('exportExcel')}}" class="btn btn-outline-success waves-effect waves-light" style="font-size:20px; position: absolute; right:20px ; top:10px"><i class="mdi mdi-microsoft-excel"></i></a>
                <div class="table-responsive class scrollable-table-wrapper mt-3">
                    <table class="table table-sm m-0">
                        <thead>
                            <tr>
                                <th style="text-align:center ;" class="table-header">STT</th>
                                <th style="" class="table-header">Thương hiệu</th>
                                <th style="text-align:center ;" class="table-header">Số lượng</th>
                                <th style="text-align:center ;width: 20%" class="table-header">Đang thực hiện</th>
                                <th style="text-align:center ;width: 20%" class="table-header">Hoàn thành</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $stt = 1;
                            @endphp
                            @foreach ($CarBrands as $value )
                                <tr>
                                    <td style="text-align:center ;" >{{$stt++}}</td>
                                    @if($value->name == 'Xe Tải' || $value->name == 'Xe Bus' || $value->name == 'Xe năng lượng xanh' )
                                    <td style="text-align:left ;" ><a class="colortext">{{$value->name}}</a></td>
                                    @else
                                    <td  style="text-align:left ;" ><a class="colortext" href="{{route('listProjectManagerment',$value->id)}}">{{$value->name}}</a></td>
                                    @endif
                                    <td style="text-align:center ;" >@if ($value->project_count==0) -   @else
                                        {{$value->project_count}}
                                    @endif</td>
                                    <td style="text-align:center ;background-color: yellow; color: black" >@if ($value->ongoing_project==0) -   @else
                                        {{$value->ongoing_project}}
                                    @endif</td>
                                    <td style="text-align:center ; color: black" >@if ($value->completed_project==0)
                                        -
                                    @else
                                        {{$value->completed_project}}
                                    @endif</td>
                                </tr>
                                @php
                                    $childStt = 1; 
                                @endphp
                                @foreach ($CarBrandsChild as $child)
                                    @if ($child->car_brands_id == $value->id)
                                        <tr>
                                            <td style="text-align: center">{{ $stt-1 . '.' . $childStt++ }}</td>
                                            <td>    
                                              <a class="colortext1" href="{{ route('listProjectManagementChild', ['car_brands_id' => $value->id, 'car_brands_child_id' => $child->id]) }}">{{ $child->name }}</a>
                                            </td>
                                            <td style="text-align:center ;" >@if ($child->project_count==0) -   @else
                                                {{$child->project_count}}
                                            @endif</td>
                                            <td style="text-align:center ;background-color: yellow; color: black" >@if ($child->ongoing_project==0) -   @else
                                                {{$child->ongoing_project}}
                                            @endif</td>
                                            <td style="text-align:center ; color: black" >@if ($child->completed_project==0)
                                                -
                                            @else
                                                {{$child->completed_project}}
                                            @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach                              
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
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            var downloadUrl = "{{ session('download_url') }}";
            window.location.href = downloadUrl;
            setTimeout(function () {
                window.location.href = "{{ route('listCarBrands') }}";
            }, 1000);
        @endif
    });
</script>