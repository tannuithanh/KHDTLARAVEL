<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Trang Chủ | THACO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" /> -->
    <meta content="Themesdesign" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/your-logo (3).png') }}">
    <!-- jvectormap -->
    <link href="{{ asset('assets/libs/jqvmap/jqvmap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <style>
        body {
            font-family: 'Times New Roman', Times, serif !important;
        }
        .modal-extra-large {
            max-width: 86%;
        }
        #piechart {
            font-family: 'Times New Roman', serif;
        }
    </style>



</head>

<body data-sidebar="dark">
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <div class="navbar-brand-box text-center">
                        <a href="{{ route('DashBoard') }}" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ asset('assets/images/logo-sm1.png') }}" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('assets/images/logo-dark1.png') }}" alt="logo-dark" height="35">
                            </span>
                        </a>
                        <a href="{{ route('DashBoard') }}" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset('assets/images/logo-sm1.png') }}" alt="logo-sm-light"
                                    height="25">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('assets/images/logo-dark1.png') }}" alt="logo-light" height="63">
                            </span>
                        </a>
                    </div>
                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button>
                </div>

                {{-- ----------------------------------------------------------------------------------------------------------------- --}}
                <div class="dropdown d-inline-block d-lg-none ms-2">
                    <button type="button" class="btn header-item noti-icon waves-effect"
                        id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="ri-search-line"></i>
                    </button>
                    
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-search-dropdown">
                        <form class="p-3">
                            <div class="mb-3 m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ...">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i
                                                class="ri-search-line"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="dropdown d-inline-block user-dropdown">
                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line"></i>
                        </button>
                    </div>
                {{-- CHUÔNG THÔNG BÁO --}}
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="true">
                                <i class="ri-notification-3-line"></i>
                                <span class="noti-dot"></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 72px);" data-popper-placement="bottom-end">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0"> Notifications </h6>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#!" class="small"> View All</a>
                                        </div>
                                    </div>
                                </div>
                                <div data-simplebar="init" style="max-height: 230px;"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: -17px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">
                                    <a href="" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-xs">
                                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                        <i class="ri-shopping-cart-line"></i>
                                                    </span>
                                                </div>
                                            </div>                                
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Your order is placed</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">If several languages coalesce the grammar</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                 
                                </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 393px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: block; height: 134px;"></div></div></div>
                                <div class="p-2 border-top">
                                    <div class="d-grid">
                                        <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                            <i class="mdi mdi-arrow-right-circle me-1"></i> View More..
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {{-- kết thúc chuông thông báo --}}
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user"
                                src="{{ asset('assets/images/users/avatar-2.jpg') }}" alt="Header Avatar">
                            <span style="margin-top:2%" class="d-none d-xl-inline-block ms-1">
                                {{ $user->name }} <br></span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>

                        </button>


                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('profile') }}"><i class=" ri-user-line"
                                    style="margin-right:4%;"></i>Thông tin cá nhân</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('departments.view') }}"><i
                                    class="ri-layout-masonry-line" style="margin-right:4%;"></i>Thông tin phòng
                                ban</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('listUser.view') }}"><i
                                    class="ri-file-list-line" style="margin-right:4%;"></i>Quản lý nhân sự</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('listTeam.view') }}"><i class="ri-team-line"
                                    style="margin-right:4%;"></i>Quản lý nhóm</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="{{ route('Logout') }}"><i
                                    class="ri-shut-down-line align-middle me-1 text-danger"></i>Đăng xuất</a>
                        </div>
                    </div>
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                            <i class="mdi mdi-cog"></i>
                        </button>
                    </div>
                </div>
        </header>
        <div class="vertical-menu">
            <div data-simplebar class="h-100">
                <div id="sidebar-menu">
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title">Mục lục</li>

                        <li>
                            <a href="{{ route('DashBoard') }}" class="waves-effect">
                                <i class="mdi mdi-home-variant-outline"></i>
                                <span>Trang chủ</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('listCarBrands') }} " class="waves-effect">
                                <i class="fas fa-project-diagram"></i>
                                <span>Dự án xe</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('listProfessional') }}" class="waves-effect">
                                <i class="fas fa-project-diagram"></i>
                                <span>Dự án khối nghiệp vụ</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-book-read-fill"></i>
                                <span>Kế hoạch ngày</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @if ($user->msnv != '0904029')
                                    <li><a href="{{ route('viewDenyDaily') }}">Từ chối & Cập nhật</a></li>
                                    <li>
                                        <a href="{{ route('viewApproveDaily') }}" class="waves-effect">
                                            <span>Duyệt & Kiểm tra</span>
                                        </a>
                                    </li>
                                @endif
                                <li><a href="{{ route('listWorkDaily') }}">Đang thực hiện</a></li>
                                <li><a href="{{ route('listReportDaily') }}">Báo cáo</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-book-read-fill"></i>
                                <span>Kế hoạch tuần</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @if ($user->msnv != '0904029')
                                    <li><a href="{{ route('viewDenyWeek') }}">Từ chối & Cập nhật</a></li>
                                    <li><a href="{{ route('viewApproveWeek') }}">Duyệt & Kiểm tra</a></li>
                                @endif
                                <li><a href="{{ route('listWorkWeek') }}">Đang thực hiện</a></li>
                                <li><a href="{{ route('listReportWeekly') }}">Báo cáo</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-book-read-fill"></i>
                                <span>Kế hoạch dài hạn</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @if ($user->msnv != '0904029')
                                <li><a href="{{ route('viewDenyMonth') }}">Từ chối & Cập nhật</a></li>
                                <li><a href="{{ route('viewApproveMonth') }}">Duyệt & Kiểm tra</a></li>
                                
                                @endif
                                <li><a href="{{ route('listStartMonth') }}">Đang thực hiện</a></li>
                                <li><a href="{{ route('listReportMonth') }}">Báo cáo</a></li>
                                <li><a href="{{ route('ChartMonth') }}">Biểu đồ</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title">Công Cụ Trực Quan</li>
                        <li>
                            <a href="{{ route('TaoLichLamViec') }}" class="waves-effect">
                                <i class="ri ri-line-chart-line"></i>
                                <span>Tạo Lịch Làm việc</span>
                            </a>
                        </li>
                    </ul>    
                </div>
            </div>
        </div>
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Trang chủ</h4>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card body">
                                    
                                    <div id="piechart" style="width:auto; height:auto"></div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card body">
                                    <div id="piechartWeek" style="width:auto; height:auto"></div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card body">
                                    <div id="monthPiechart" style="width:auto; height:auto"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card body" style="left=0px">
                                    <div id="chart_div" style="width:auto; height:auto"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card body">
                                    <div id="projecPro" style="width:auto; height:auto"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--THONG BAO---}}
                    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-extra-large" role="document">
                            <div class="modal-content" style="background-color: #f2f2f2;">
                                <div class="modal-header" style="background-color: #e6e6e6;">
                                    <img src="{{ asset('assets/images/KIA.png') }}" alt="Logo" style="height: 30px; margin-right: 10px;">
                                    <span style="    font-size: 20px; margin-left: -7%; font-weight: bold; ">THÔNG BÁO</span>
                                    <input type="checkbox" id="modal-checkbox" name="modal-checkbox" style="width: 84px;height: 20px;display: flex;margin-right: -39%;">
                                    <label for="modal-checkbox">Không hiển thị lại</label>
                                </div>
                                
                                <div class="modal-body" id="notifacation" style="color: #4b0082;">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered border-primary mb-0">
                
                                                        <thead>
                                                            <tr>
                                                                <th style="width:0px">STT</th>
                                                                <th>Tên công việc</th>
                                                                <th>Tình trạng</th>
                                                
                                                            </tr>
                                {{--------------------------------KẾ HOẠCH NGÀY----------------------------------------------------------}}
                                                            <tr><th colspan="3" style="background-color: silver;">I. Kế hoạch ngày</th></tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $sttDaily = 1 @endphp
                                                            @foreach($overdueDailyTasks as $value)
                                                                <tr>
                                                                    <td style="text-align: center;"> {{$sttDaily++}} </td>
                                                                    <td>{{ $value->categoryDaily }}</td>
                                                                    <td style="color:red">Kế hoạch bị trễ</td>
                                                                </tr>
                                                            @endforeach
                                                        
                                                            @foreach($currentDailyTasks as $value)
                                                                <tr>
                                                                    <td style="text-align: center;"> {{$sttDaily++}} </td>
                                                                    <td>{{ $value->categoryDaily }}</td>
                                                                    <td style="color:orange">Đang thực hiện</td>
                                                                </tr>
                                                            @endforeach
                                                        
                                                            @foreach($doneDailyTasks as $value)
                                                                <tr>
                                                                    <td style="text-align: center;"> {{$sttDaily++}} </td>
                                                                    <td>{{ $value->categoryDaily }}</td>
                                                                    <td style="color:green">Đã hoàn thành</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                {{--------------------------------KẾ HOẠCH TUẦN----------------------------------------------------------}}                        
                                                        <thead>                                                    
                                                            <tr><th colspan="3" style="background-color: silver;">II. Kế hoạch tuần</th></tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $sttWeek = 1 @endphp
                                                            @foreach($overdueWeekTasks as $value)
                                                                <tr>
                                                                    <td style="text-align: center;"> {{$sttWeek++}} </td>
                                                                    <td>{{ $value->categoryWeek }}</td>
                                                                    <td style="color:red">Đang bị trễ</td>
                                                                </tr>
                                                            @endforeach
                                                        
                                                            @foreach($pendingWeekTasks as $value)
                                                                <tr>
                                                                    <td style="text-align: center;"> {{$sttWeek++}} </td>
                                                                    <td>{{ $value->categoryWeek }}</td>
                                                                    <td style="color:orange">Đang thực hiện</td>
                                                                </tr>
                                                            @endforeach
                                                        
                                                            @foreach($doneWeekTasks as $value)
                                                                <tr>
                                                                    <td style="text-align: center;"> {{$sttWeek++}} </td>
                                                                    <td>{{ $value->categoryWeek }}</td>
                                                                    <td style="color:green">Đã hoàn thành</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                {{--------------------------------KẾ HOẠCH DÀI HẠN----------------------------------------------------------}}     
                                                        <thead>                                                    
                                                            <tr><th colspan="3" style="background-color: silver;">III. Kế hoạch dài hạn</th></tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $sttWeek = 1 @endphp
                                                            @foreach($overdueWeekTasks as $value)
                                                                <tr>
                                                                    <td style="text-align: center;"> {{$sttWeek++}} </td>
                                                                    <td>{{ $value->categoryWeek }}</td>
                                                                    <td style="color:red">Đang bị trễ</td>
                                                                </tr>
                                                            @endforeach
                                                        
                                                            @foreach($pendingWeekTasks as $value)
                                                                <tr>
                                                                    <td style="text-align: center;"> {{$sttWeek++}} </td>
                                                                    <td>{{ $value->categoryWeek }}</td>
                                                                    <td style="color:orange">Đang thực hiện</td>
                                                                </tr>
                                                            @endforeach
                                                        
                                                            @foreach($doneWeekTasks as $value)
                                                                <tr>
                                                                    <td style="text-align: center;"> {{$sttWeek++}} </td>
                                                                    <td>{{ $value->categoryWeek }}</td>
                                                                    <td style="color:green">Đã hoàn thành</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                 </table>
                                            </div>
                                        </div>
                                    
                                    </div>
                                </div>
                                <div class="modal-footer" style="background-color: #e6e6e6;">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <script>document.write(new Date().getFullYear())</script>  <i class="ri-truck-fill"></i> TRUNG TÂM R&D ÔTÔ
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="text-sm-end d-none d-sm-block">
                                                            <i class="ri-phone-fill"></i> Hotline: 0886418363
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                    @include('include.footer')
</body>


</html>
<script type="text/javascript" src="{{ asset('assets/js/gstatic.com_charts_loader.js') }}"></script>


<script>
//--------- Lưu giá trị checkbox vào storage -------//
    $(document).ready(function() {
        var checkbox = document.getElementById('modal-checkbox');
        
        // Kiểm tra nếu giá trị 'hideModal' có trong localStorage hay không
        if(localStorage.getItem('hideModal') == 'true') {
            // Nếu có, đặt trạng thái checkbox thành checked
            checkbox.checked = true;
        } else {
            // Nếu không, hiển thị modal
            $('#exampleModalScrollable').modal('show');
        }

        // Khi trạng thái checkbox thay đổi, lưu nó vào localStorage hoặc xóa nó
        checkbox.addEventListener('change', function() {
            if(this.checked) {
                localStorage.setItem('hideModal', 'true');
            } else {
                localStorage.removeItem('hideModal');
            }
        });
    });


//---------- BIỂU ĐỒ CÔNG VIỆC NGÀY --------//
    var options = {
        chart: {
            type: 'pie',
            height: 350, // Điều chỉnh chiều cao của biểu đồ
            width: '66%', // Điều chỉnh chiều rộng của biểu đồ
        },
        title: {
            text: 'Tổng số công việc ngày',
            align: 'center',
            style: {
                    fontSize:  '14px',
                    fontWeight:  'bold',
                    fontFamily:  'Timenewroman',
                    color:  '#263238'
                    },
        },
        series: [{{ $taskCounts['unreported'] }}, {{ $taskCounts['ongoing'] }}, {{ $taskCounts['completed'] }}, {{$taskCounts['none']}}],
        labels: ['Trễ', 'Đang thực hiện', 'Hoàn thành', 'Trống'],
        colors: ['#FF0000', '#FF7F00', '#008000', '#000000'], // Mảng màu, mỗi màu tương ứng với mỗi phần tử trong mảng series
        legend: {
            position: 'bottom',
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    }

    var chart = new ApexCharts(document.querySelector("#piechart"), options);
    chart.render();

</script>
<script type="text/javascript">
//---------- BIỂU ĐỒ CÔNG VIỆC TUẦN --------//
    var options = {
        chart: {
            type: 'pie',
            height: 350, // Điều chỉnh chiều cao của biểu đồ
            width: '66%', // Điều chỉnh chiều rộng của biểu đồ
        },
        title: {
            text: 'Tổng số công việc tuần: {{ array_sum($weekTaskCounts) }}',
            align: 'center',
            style: {
                    fontSize:  '14px',
                    fontWeight:  'bold',
                    fontFamily:  'Timenewroman',
                    color:  '#263238'
                    },
        },
        series: [{{$weekTaskCounts['unreported']}}, {{$weekTaskCounts['ongoing']}}, {{$weekTaskCounts['completed']}}, {{$weekTaskCounts['none']}}],
        labels: ['Trễ', 'Đang thực hiện', 'Hoàn thành', 'Trống'],
        colors: ['#FF0000', '#FF7F00', '#008000', '#000000'], // Mảng màu, mỗi màu tương ứng với mỗi phần tử trong mảng series
        legend: {
            position: 'bottom',
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    }

    var chart = new ApexCharts(document.querySelector("#piechartWeek"), options);
    chart.render();

</script>
<script type="text/javascript">
//---------- BIỂU ĐỒ CÔNG VIỆC DÀI HẠN --------//
    var options = {
        chart: {
            type: 'pie',
            height: 350, // Điều chỉnh chiều cao của biểu đồ
            width: '66%', // Điều chỉnh chiều rộng của biểu đồ
        },
        title: {
            text: 'Tổng số công việc dài hạn: {{ array_sum($monthTaskCounts) }}',
            align: 'center',
            style: {
                        fontSize:  '14px',
                        fontWeight:  'bold',
                        fontFamily:  'Timenewroman',
                        color:  '#263238'
                    },
        },
        series: [{{$monthTaskCounts['unreported']}}, {{$monthTaskCounts['ongoing']}}, {{$monthTaskCounts['completed']}}, {{$monthTaskCounts['none']}}],
        labels: ['Trễ', 'Đang thực hiện', 'Hoàn thành', 'Trống'],
        colors: ['#FF0000', '#FF7F00', '#008000', '#000000'], // Mảng màu, mỗi màu tương ứng với mỗi phần tử trong mảng series
        legend: {
            position: 'bottom',
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    }

    var chart = new ApexCharts(document.querySelector("#monthPiechart"), options);
    chart.render();

</script>

<script>
//---------- BIỂU ĐỒ DỰ ÁN XE TẠI TRUNG TÂM --------//    
    var carBrands = <?php echo json_encode($chartData); ?>;

    var categories = carBrands.map(function(carBrand) {
        return carBrand[0]; // Chú ý rằng carBrand[0] phụ thuộc vào cấu trúc của dữ liệu của bạn
    });

    var data = carBrands.map(function(carBrand) {
        return carBrand[1]; // Tương tự như trên, carBrand[1] phụ thuộc vào cấu trúc dữ liệu
    });

    var options = {
        chart: {
            type: 'bar',
            height: 350, // Điều chỉnh chiều cao của biểu đồ
            width: '100%', // Điều chỉnh chiều rộng của biểu đồ
        },
        plotOptions: {
            bar: {
                horizontal: false,
            }
        },
        dataLabels: {
            enabled: false
        },
        title: {
            text: 'Biểu đồ các dự án xe tại trung tâm R&D Ô tô',
            align: 'center',
            style: {
                    fontSize:  '14px',
                    fontWeight:  'bold',
                    fontFamily:  'Timenewroman',
                    color:  '#263238'
                    },
        },
        series: [{
            name: 'Dự án',
            data: data
        }],
        xaxis: {
            categories: categories,
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart_div"), options);
    chart.render();

//---------- BIỂU ĐỒ DỰ ÁN NGHIỆP VỤ --------//
        var projects = <?php echo json_encode($projects); ?>;

        var categories = projects.map(function(project) {
            return project.name; // project.name phụ thuộc vào cấu trúc của dữ liệu của bạn
        });

        var data = projects.map(function(project) {
            return project.completion; // Tương tự như trên, project.completion phụ thuộc vào cấu trúc dữ liệu
        });

        var options = {
            chart: {
                type: 'bar',
                height: 350, // Điều chỉnh chiều cao của biểu đồ
                width: '100%', // Điều chỉnh chiều rộng của biểu đồ
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            title: {
                text: 'Biểu đồ các dự án nghiệp vụ',
                align: 'center',
                style: {
                    fontSize:  '14px',
                    fontWeight:  'bold',
                    fontFamily:  'Timenewroman',
                    color:  '#263238'
                    },
            },
            series: [{
                name: 'Phần trăm (%)',
                data: data
            }],
            xaxis: {
                categories: categories,
                title: {
                    text: 'Mức độ hoàn thành',
                },
                min: 0,
                max: 100
            }
        };

        var chart = new ApexCharts(document.querySelector("#projecPro"), options);
        chart.render();

</script>

