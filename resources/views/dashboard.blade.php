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

                                <li><a href="{{ route('viewDenyDaily') }}">Từ chối & Cập nhật</a></li>
                                <li>
                                    <a href="{{ route('viewApproveDaily') }}" class="waves-effect">
                                        <span>Duyệt & Kiểm tra</span>
                                    </a>
                                </li>
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
                                <li><a href="{{ route('viewDenyWeek') }}">Từ chối & Cập nhật</a></li>
                                <li><a href="{{ route('viewApproveWeek') }}">Duyệt & Kiểm tra</a></li>
                                <li><a href="{{ route('listWorkWeek') }}">Đang thực hiện</a></li>
                                <li><a href="{{ route('listReportWeekly') }}">Báo cáo</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-book-read-fill"></i>
                                <span>Kế hoạch tháng</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('viewDenyMonth') }}">Từ chối & Cập nhật</a></li>
                                <li><a href="{{ route('viewApproveMonth') }}">Duyệt & Kiểm tra</a></li>
                                <li><a href="{{ route('listStartMonth') }}">Đang thực hiện</a></li>
                                <li><a href="{{ route('listReportMonth') }}">Báo cáo</a></li>
                                <li><a href="{{ route('ChartMonth') }}">Biểu đồ</a></li>
                            </ul>
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
                                    <span style="    font-size: 20px; margin-left: 29%; font-weight: bold; ">THÔNG BÁO</span>
                                    <button type="button" class="btn-close" ></button>
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
                                                            <tr><th colspan="3" style="background-color: silver;">I. Kế hoạch ngày</th></tr>
                                                        </thead>
                                                        <tbody> 
                                                            @foreach($overdueDailyTasks as $value)
                                                            <tr>
                                                                <td style="text-align: center;"> 1 </td>
                                                                <td>{{ $value->categoryDaily }}</td>
                                                                <td style="color:red">Kế hoạch bị trễ</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <thead>                                                    
                                                            <tr><th colspan="3" style="background-color: silver;">II. Kế hoạch tuần</th></tr>
                                                        </thead>
                                                        <tbody> 
                                                            {{-- <tr>
                                                                <td colspan="3">Không có dữ liệu</td>
                                                            </tr> --}}
                                                        </tbody>
                                                        <thead>                                                    
                                                            <tr><th colspan="3" style="background-color: silver;">III. Kế hoạch dài hạn</th></tr>
                                                        </thead>
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
    google.charts.load('current', {
        packages: ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task');
        data.addColumn('number', 'Hours per Day');
        data.addRows([
            ['Trễ ', {{ $taskCounts['unreported'] }}],
            ['Đang thực hiện', {{ $taskCounts['ongoing'] }}],
            ['Hoàn thành', {{ $taskCounts['completed'] }}],
            ['Trống', {{$taskCounts['none']}}],
        ]);

        var options = {
            title: 'Tổng số công việc ngày: {{ array_sum($taskCounts) }}',
            pieHole: 0.3,
            slices: {
                0: {
                    color: 'red'
                },
                1: {
                    color: 'orange'
                },
                2: {
                    color: 'green'
                },
                3: {
                    color: 'black'
                }
            },
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Trễ', {{$weekTaskCounts['unreported']}}],
            ['Đang thực hiện', {{$weekTaskCounts['ongoing']}}],
            ['Hoàn thành', {{$weekTaskCounts['completed']}}],
            ['Trống', {{$taskCounts['none']}}],
        ]);

        var options = {
            title: 'Tổng số công việc tuần: {{ array_sum($weekTaskCounts) }}',
            pieHole: 0.3,
            slices: {
                0: {
                    color: 'red'
                },
                1: {
                    color: 'orange'
                },
                2: {
                    color: 'green'
                },
                3: {
                    color: 'black'
                }
            },
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechartWeek'));

        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Trễ', {{$monthTaskCounts['unreported']}}],
            ['Đang thực hiện', {{$monthTaskCounts['ongoing']}}],
            ['Hoàn thành', {{$monthTaskCounts['completed']}}],
            ['Trống', {{$monthTaskCounts['none']}}],
        ]);

        var options = {
            title: 'Tổng số công việc dài hạn:{{ array_sum($monthTaskCounts) }} ',
            pieHole: 0.3,
            slices: {
                0: {
                    color: 'red'
                },
                1: {
                    color: 'orange'
                },
                2: {
                    color: 'green'
                },
                3: {
                    color: 'black'
                }
            },
        };

        var chart = new google.visualization.PieChart(document.getElementById('monthPiechart'));

        chart.draw(data, options);
    }
</script>
<script>
    google.charts.load('current', {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Car Brand');
        data.addColumn('number', 'Dự án');

        var carBrands = <?php echo json_encode($chartData); ?>;

        carBrands.forEach(function(carBrand) {
            data.addRow(carBrand);
        });

        var options = {
            title: 'Biểu đồ các dự án xe tại trung tâm R&D Ô tô',
            titleTextStyle: {
                color: 'black',
                fontSize: 16,
                bold: true,
                fontName: 'Times New Roman',
            },
            hAxis: {title: 'Thương hiệu xe',fontName: 'Times New Roman',  titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }

</script>
<script>
    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Tên dự án');
        data.addColumn('number', 'Phần trăm (%)');
        
        var projects = <?php echo json_encode($projects); ?>;
        
        projects.forEach(function(project) {
            data.addRow([project.name, project.completion]);
        });

        var options = {
            chart: {
                titleTextStyle: {
                    color: 'black',
                    fontName: 'Times New Roman',
                    fontSize: 24,
                },
            },
            title: 'Biểu đồ các dự án nghiệp vụ',
            titleTextStyle: {
                color: 'black',
                fontSize: 16,
                bold: true,
                fontName: 'Times New Roman',
            },
            hAxis: {
                title: 'Mức độ hoàn thành',
                minValue: 0,
                maxValue: 100,
                titleTextStyle: {
                    fontSize: 16,
                    fontName: 'Times New Roman',
                },
            },
            bars: 'horizontal'
        };

        var chart = new google.charts.Bar(document.getElementById('projecPro'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>
<script>
    $(document).ready(function(){
        $("#exampleModalScrollable").modal('show');
    });
    $(document).ready(function(){
    $(".btn-close").click(function(){
        $("#exampleModalScrollable").modal('hide');
    });
    });
</script>

