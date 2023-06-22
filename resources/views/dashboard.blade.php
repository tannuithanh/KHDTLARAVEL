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
    {{-- <link href="{{ asset('assets/css/table.css') }}" id="app-style" rel="stylesheet" type="text/css" /> --}}
    <link href="{{ asset('assets/css/chunhapnhay.css') }}" id="app-style" rel="stylesheet" type="text/css" />


    <style>
        body{
            font-family: 'Times New Roman', Times, serif !important;
        }
        .table-wrapper {
            display: inline-block;
        }
            .fullscreen-modal .modal-dialog {
            width: 90%; /* Tăng độ rộng của modal */
            max-width: 70%; /* Loại bỏ giới hạn độ rộng tối đa */
            height: auto;
            margin: 5% auto; /* Giảm lề trên và dưới để modal canh giữa */
        }

        .fullscreen-modal .modal-content {
            height: 100%;
            border-radius: 0;
            display: flex;
            flex-direction: column;
        }

        .fullscreen-modal .modal-body {
            flex-grow: 1;
            overflow-y: auto;
        
        }


        .custom-card {
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            background-color: tomato;
        }

        .custom-card .card-body {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 2rem;
        }

        .greeting-container {
            color: white;
        }

        .greeting-text {
            margin: 0;
            font-size: 1.5rem;
        }

        .greeting-user-name {
            margin: 0;
            font-size: 2.5rem;
            font-weight: bold;
        }

        .greeting-progress {
            font-size: 1.25rem;
        }

        .greeting-progress-percentage {
            color: #13fd01;
        }

        .greeting-image-container {
            width: 30%;
            position: relative;
        }

        .greeting-image {
            max-width: 100%;
            position: relative;
            top: -1.5rem;
        }

        /* Đoạn mã CSS đã đưa ra trong câu trả lời trước đây */

        #calendar {
            font-family: Arial, sans-serif;
            width: 100%;
            background-color: white;
        }

        .month {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #3a3a3a;
            color: white;
            font-size: 1.2rem;
        }

        .month-nav {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.5rem;
            outline: none;
            color: white;
        }

        .weekdays {
            display: flex;
            list-style-type: none;
            padding: 0;
            margin: 0;
            background-color: #ddd;
            color: black;
        }

        .days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .weekdays li,
        .days li {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 50px;
            font-size: 1.1rem;
        }

        .days li {
            border: 1px solid #ddd;
            background-color: white;
            cursor: pointer;
        }

        .days li:hover {
            background-color: #eee;
        }

        .current-date {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
        }

        .current-date img {
            width: 100px;
            height: auto;
            margin-left: 10px;
        }

        .day-today {
            background-color: tomato !important;
            color: white;
        }

        ul {
            padding-left: 20px;
            list-style-type: disc;
        }

        li {
            margin-bottom: 5px;
        }

        .task-table {
            width: 100%;
            border-collapse: collapse;
            border: none !important;
        }

        .task-table td {
            vertical-align: top;
            border: none !important;
        }

        .task-table .task-colon {
            width: 1%;
            white-space: nowrap;
        }
        .custom-table th {
            background-color: #007bff; /* Màu nền của thẻ <th> */
            color: #ffffff; /* Màu chữ của thẻ <th> */
            font-weight: bold; /* Chữ in đậm */
        }

    </style>

<style>
    .toggle-work-list {
        cursor: pointer;
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
                                <img src="{{ asset('assets/images/logo-dark1.png') }}" alt="logo-dark"
                                    height="35">
                            </span>
                        </a>
                        <a href="{{ route('DashBoard') }}" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset('assets/images/logo-sm1.png') }}" alt="logo-sm-light"
                                    height="25">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('assets/images/logo-dark1.png') }}" alt="logo-light"
                                    height="63">
                            </span>
                        </a>
                    </div>
                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button>
                </div>
                <div class="d-flex">
                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-apps-2-line"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end" style="">
                            <div class="px-lg-2">
                                <div class="row g-0">
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="http://113.161.6.179:8089/RD/" target="_blank">
                                    
                                            <span>CHỮ KÝ ĐIỆN TỬ</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="http://113.161.6.179:8089/mahoatenduan/" target="_blank">
                                           
                                            <span>MÃ HÓA TÊN DỰ ÁN</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="http://113.161.6.179:8089/QLTB/" target="_blank">
                                  
                                            <span>QUẢN LÝ THIẾT BỊ</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="https://eoffice.thacochulai.vn/" target="_blank">
                                  
                                            <span>THACO EOFFICE</span>
                                        </a>
                                    </div>
                                </div>

                             
                            </div>
                        </div>
                    </div>
                    {{---------------------------------------------------------------------------------------------------------------------}}
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
                            <button type="button" class="btn header-item noti-icon waves-effect"
                                data-toggle="fullscreen">
                                <i class="ri-fullscreen-line"></i>
                            </button>
                        </div>
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect"
                                id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
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
                            <a href="{{ route('listCarBrands')}} " class="waves-effect">
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
                                <span>Kế hoạch dài hạn</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">

                                <li><a href="{{route('viewDenyDaily')}}">Từ chối</a></li>
                                <li>
                                    <a href="{{route('viewApproveDaily')}}" class="waves-effect">
                                        @if ($count == 0)
                                            <span class="badge rounded-pill bg-primary float-end"></span>
                                        @else
                                            <span class="badge rounded-pill bg-primary float-end">{{$count}}</span>
                                        @endif

                                        <span>Duyệt & Kiểm tra</span>
                                    </a>
                                </li>
                                <li><a href="{{route('listWorkDaily')}}">Đang thực hiện</a></li>
                                <li><a href="{{ route('listReportDaily') }}">Báo cáo</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-book-read-fill"></i>
                                <span>Kế hoạch tuần</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{route('viewDenyWeek')}}">Từ chối</a></li>
                                <li><a href="{{ route('viewApproveWeek')}}">Duyệt & Kiểm tra</a></li>
                                <li><a href="{{route('listWorkWeek')}}">Đang thực hiện</a></li>
                                <li><a href="{{ route('listReportWeekly') }}">Báo cáo</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-book-read-fill"></i>
                                <span>Kế hoạch tháng</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{route('viewDenyMonth')}}" >Từ chối</a></li>
                                <li><a href="{{route('viewApproveMonth')}}">Duyệt & Kiểm tra</a></li>
                                <li><a href="{{route('listStartMonth')}}">Đang thực hiện</a></li>
                                <li><a href="{{route('listReportMonth')}}">Báo cáo</a></li>
                                <li><a href="{{route('ChartMonth')}}">Biểu đồ</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Trang chủ</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div class="greeting-container">
                                        <h3 class="greeting-text" style="font-family: 'Times New Roman', Times, serif !important;font-weight: bold">Xin chào</h3>
                                        <h1 class="greeting-user-name"  style="font-family: 'Times New Roman', Times, serif !important;font-weight: bold">{{ $user->name }}</h1>
                                        <h4 class="greeting-progress"  style="font-family: 'Times New Roman', Times, serif !important;font-weight: bold">Hãy làm việc ngay thôi nào</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12">.
                                <div class="card">
                                    <div class="card-body" style="height: 520px">
                                        <div class="container my-4">
                                            <h2 class="mb-3" style="font-family: 'Times New Roman', Times, serif !important;font-weight: bold">Dự án bạn đang tham gia ({{ count($projects) }})</h2>
                                        
                                            @foreach ($projects as $project)
                                                <div class="mb-4" style="font-family: 'Times New Roman', Times, serif !important;font-weight: bold">
                                                    <h3 style="font-family: 'Times New Roman', Times, serif !important;font-weight: bold">Tên dự án: {{ $project->name_project }}</h3>
                                                    
                                                    @foreach ($project->projectDepartments as $projectDepartment)
                                                        @php
                                                            $userWorksInDepartment = $projectDepartment->works->filter(function ($work) use ($user) {
                                                                return $work->responsibility == $user->name;
                                                            });
                                                        @endphp
                                        
                                                        @if (count($userWorksInDepartment))
                                                            <h4 style="font-family: 'Times New Roman', Times, serif !important;font-weight: bold" class="toggle-work-list">[+] Công việc của bạn trong dự án: {{ $projectDepartment->name }}</h4>
                                                            <ul class="work-list" style="display: none;">
                                                                @foreach ($userWorksInDepartment as $work)
                                                                    @if($work->completion < 100)
                                                                        <li style="font-size:20px">
                                                                            <a href="{{ route('ProjectCon', ['id' => $work->id]) }}">
                                                                                {{ $work->name_work }}
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    @endforeach
                                                    <hr>
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col -->

                        <div class="col-xl-6">
                            <div class="card calendar-card">
                                <div class="card-body">
                                    <div id="carouselExampleSlidesOnly" class="carousel slide"
                                        data-bs-ride="carousel" data-interval="3000">
                                        <div class="carousel-inner" role="listbox">
                                            <div class="carousel-item">
                                                <img style="width: 100%; height: 19.5rem;" class="d-block img-fluid"
                                                    src="{{ asset('assets/images/background.JPG') }}"
                                                    alt="First slide">
                                            </div>
                                            <div class="carousel-item active">
                                                <img style="width: 100%;height: 19.5rem;" class="d-block img-fluid"
                                                    src="{{ asset('assets/images/MAN HINH THACO_13.1-16x9_Mau1.jpg') }}"
                                                    alt="Second slide">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="calendar">

                                        <div class="month">
                                            <button class="month-nav prev">&#10094;</button>
                                            <div class="month-name" id="month-name">Tháng 4</div>
                                            <button class="month-nav next">&#10095;</button>
                                        </div>
                                        <ul class="weekdays">
                                            <li>T2</li>
                                            <li>T3</li>
                                            <li>T4</li>
                                            <li>T5</li>
                                            <li>T6</li>
                                            <li>T7</li>
                                            <li>CN</li>
                                        </ul>
                                        <ul class="days" id="days">
                                            <!-- Các ngày của tháng sẽ được thêm vào đây bằng JavaScript -->
                                        </ul>

                                    </div>

                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>




                    @include('include.footer')
</body>
{{-- <div class="modal fade fullscreen-modal" id="todayTasksModal" tabindex="-1" role="dialog" style="font-size: 30px"
    aria-labelledby="todayTasksModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #F8F8F8;">
                <h5 style="font-size: 30px;font-weight: bold;font-family: 'remixicon';" class="modal-title" id="todayTasksModalLabel">THÔNG BÁO</h5>    
            </div>
            <div class="modal-body" style="background-color: #F8F8F8;">
                <div class="card">
                    <div class="card-body">
                        <div class="table-wrapper">
                <h3>I. Công việc ngày ({{ date('d/m/Y', strtotime($mydate)) }})</h3>
                <table class="table table-dark mb-0">
                    <thead>
                        <tr>
                            <th style="text-align: left; " scope="col">STT</th>
                            <th style="text-align: left; " scope="col">Tên công việc</th>
                            <th style="text-align: left; " scope="col">Trạng thái</th>
                        </tr>
                    </thead>                    
                    <tbody>
                        @foreach ($workDaily as $key => $task)
                            <tr>
                                <td  style="text-align: center;font-weight: bold;">{{ $key + 1 }}</td>
                                <td>{{ $task->categoryDaily }}</td>
                                @if ($task->status == -1 )
                                    <td style="text-align: center; color: rgb(248, 16, 16);"> Cần cập nhật </td>
                                @elseif($task->status == 0)
                                    <td style="text-align: center; color: rgb(251, 147, 2) "> Cần thực hiện </td> 
                                @else
                                    <td style="text-align: center; color: rgb(0, 255, 17) "> Đã hoàn thành </td> 
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
         
        <div class="card">

                <h3>II. Công việc tuần {{$currentWeekInMonth}} tháng {{$currentMonth}}</h3>
                <table class="table table-dark mb-0">

                    <thead>
                        <tr>
                            <th style="text-align: left;" scope="col">STT</th>
                            <th style="text-align: left;" scope="col">Tên công việc</th>
                            <th style="text-align: left;" scope="col">Ngày bắt đầu</th>
                            <th style="text-align: left;" scope="col">Ngày kết thúc</th>
                            <th style="text-align: left;" scope="col">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasksThisWeek as $key => $task)
                            <tr>
                                <td  style="text-align: center;font-weight: bold;">{{ $key + 1 }}</td>
                                <td>{{ $task->categoryWeek }}</td>
                                <td>{{ date('d/m/Y', strtotime($task->startdate)) }}</td>
                                <td>{{ date('d/m/Y', strtotime($task->enddate)) }}</td>
                                @if ($task->status == -1 )
                                    <td style="text-align: center; color: rgb(248, 16, 16); "> Cần cập nhật </td>
                                @elseif($task->status == 0)
                                    <td style="text-align: center; color: rgb(251, 147, 2) "> Đang thực hiện </td> 
                                @else
                                    <td style="text-align: center; color: rgb(0, 255, 17) "> Đã hoàn thành </td> 
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Thêm các hạng mục khác ở đây -->
            </div>
            </div>
        </div>
    </div>
            <div class="modal-footer" style="background-color: #F8F8F8;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div> --}}

</html>
<script>
    let currentDate = new Date();

    function updateCalendar() {
        const monthNames = [
            "Tháng 1",
            "Tháng 2",
            "Tháng 3",
            "Tháng 4",
            "Tháng 5",
            "Tháng 6",
            "Tháng 7",
            "Tháng 8",
            "Tháng 9",
            "Tháng 10",
            "Tháng 11",
            "Tháng 12",
        ];

        const monthName = document.getElementById("month-name");
        monthName.textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;

        const daysInMonth = new Date(
            currentDate.getFullYear(),
            currentDate.getMonth() + 1,
            0
        ).getDate();
        const days = document.getElementById("days");
        days.innerHTML = "";

        for (let i = 1; i <= daysInMonth; i++) {
            const day = document.createElement("li");
            day.textContent = i;

            if (
                i === new Date().getDate() &&
                currentDate.getMonth() === new Date().getMonth() &&
                currentDate.getFullYear() === new Date().getFullYear()
            ) {
                day.classList.add("day-today");
            }

            days.appendChild(day);
        }
    }

    function changeMonth(step) {
        currentDate.setMonth(currentDate.getMonth() + step);
        updateCalendar();
    }

    document.querySelector(".prev").addEventListener("click", () => changeMonth(-1));
    document.querySelector(".next").addEventListener("click", () => changeMonth(1));

    updateCalendar();
</script>
<script>
    $(document).ready(function() {
        // Hiển thị hộp thoại (modal) khi có công việc trong ngày
        if ({{ count($workDaily) }} > 0) {
            $('#todayTasksModal').modal('show');
        }
    });
</script>
<script>
$(document).ready(function() {
    $(".toggle-work-list").click(function() {
        var workList = $(this).next(".work-list");
        if (workList.css("display") == "none") {
            workList.show();
            $(this).text($(this).text().replace('[+]', '[-]'));
        } else {
            workList.hide();
            $(this).text($(this).text().replace('[-]', '[+]'));
        }
    });
});
</script>