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
    <link href="{{ asset('assets/css/table.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/chunhapnhay.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/lich.css') }}" id="app-style" rel="stylesheet" type="text/css" />






</head>

<body data-sidebar="dark">
    <div class="right-bar">
        <div data-simplebar="init" class="h-100">
            <div class="simplebar-wrapper" style="margin: 0px;">
                <div class="simplebar-height-auto-observer-wrapper">
                    <div class="simplebar-height-auto-observer"></div>
                </div>
                <div class="simplebar-mask">
                    <div class="simplebar-offset" style="right: -16.6667px; bottom: 0px;">
                        <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;">
                            <div class="simplebar-content" style="padding: 0px;">
                                <div class="rightbar-title d-flex align-items-center px-3 py-4">

                                    <h5 class="m-0 me-2">Chế độ</h5>

                                    <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                                        <i class="mdi mdi-close noti-icon"></i>
                                    </a>
                                </div>
                                <!-- Settings -->
                                <hr class="mt-0">
                                <h6 class="text-center mb-0">Chọn bố cục</h6>

                                <div class="p-4">
                                    <div class="mb-2">
                                        <img src="assets/images/layouts/layout-1.png" class="img-thumbnail"
                                            alt="layout-1">
                                    </div>

                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input theme-choice" type="checkbox"
                                            id="light-mode-switch" checked="">
                                        <label class="form-check-label" for="light-mode-switch">Chế độ sáng</label>
                                    </div>

                                    <div class="mb-2">
                                        <img src="assets/images/layouts/layout-2.png" class="img-thumbnail"
                                            alt="layout-2">
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input theme-choice" type="checkbox"
                                            id="dark-mode-switch" data-bsstyle="assets/css/bootstrap-dark.min.css"
                                            data-appstyle="assets/css/app-dark.min.css">
                                        <label class="form-check-label" for="dark-mode-switch">Chế độ tối</label>
                                    </div>

                                    <div class="mb-2">
                                        <img src="assets/images/layouts/layout-3.png" class="img-thumbnail"
                                            alt="layout-3">
                                    </div>
                                    <div class="form-check form-switch mb-5">
                                        <input class="form-check-input theme-choice" type="checkbox"
                                            id="rtl-mode-switch" data-appstyle="assets/css/app-rtl.min.css">
                                        <label class="form-check-label" for="rtl-mode-switch">Chế độ RTL</label>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="simplebar-placeholder" style="width: auto; height: 850px;"></div>
            </div>
            <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
            </div>
            <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                <div class="simplebar-scrollbar"
                    style="transform: translate3d(0px, 0px, 0px); display: block; height: 118px;"></div>
            </div>
        </div>
    </div>
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
                                <span style="margin-top:2%" class="d-none d-xl-inline-block ms-1"> {{ $user->name }}  <br></span>
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
                                <a class="dropdown-item" href="{{ route('listUser.view') }}"><i class="ri-file-list-line"
                                        style="margin-right:4%;"></i>Quản lý nhân sự</a>
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
                                    <i class="mdi mdi-home-variant-outline"></i><span class="badge rounded-pill bg-primary float-end">3</span>
                                    <span>Trang chủ</span>
                                </a>
                        </li>
                        <li>
                            <a href="{{ route('listProjectManagerment') }}" class="waves-effect">
                                <i class="fas fa-project-diagram"></i>
                                <span>Quản lý dự án</span>
                            </a>
                        </li>
                        <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-book-read-fill"></i>
                                    <span>Kế hoạch công việc</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('listWorkWeek') }}">Kế hoạch tuần</a></li>
                                    <li><a href="{{ route('listWorkDaily')}}">Kế hoạch ngày</a></li>
                                </ul>
                            </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-bookmark-3-line"></i>
                                <span>Báo cáo công việc</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('listReportWeekly') }}">Báo cáo tuần</a></li>
                                <li><a href="{{ route('listReportDaily') }}">Báo cáo ngày</a></li>
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
    <div class="col-xl-6 col-sm-6">
        <div class="card">
            <div class="card-body" style="text-align: center;padding: unset;background-color: tomato;border-radius: 8px;">
                    <img style="position: absolute;left: 0;top: 0; width: 25%;" src="{{{ asset('assets/images/decore-left.png') }}}" alt="">
                    <img style="position: absolute;right: 0;top: 0;width: 25%;" src="{{{ asset('assets/images/decore-right.png') }}}" alt="">
                    <img style="margin-top: -25px;width: 30%;" src="{{{ asset('assets/images/zyro-image.png') }}}" alt="">

                <div>
                    <h3 style="color: white;">Xin chào</h3>
                    <h1 style="color: white;"><strong>{{ $user->name }}</strong></h1>
                    <h4 style="color: white;">Bạn đã hoàn tất <span style="color: green">100%</span> công việc trong ngày hôm nay</h4>
                </div>
            </div>
        </div>
    </div> <!-- end col -->

    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body">

                <div class="d-flex text-muted">
                    <div class="flex-shrink-0 me-3 align-self-center">
                        <div class="avatar-sm">

                            <div class="avatar-title bg-light rounded-circle text-primary font-size-20"
                                style="color: rgb(64, 0, 255)!important">
                                <i class="ri-bar-chart-grouped-line"></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="mb-1" style="font-size: 17px;">Công việc tuần này</p>
                        <h5 class="mb-3" style="font-size:35px">600</h5>
                    </div>
                </div>
            </div>
            <!-- end card-body -->
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex text-muted">
                    <div class="flex-shrink-0  me-3 align-self-center">
                        <div class="avatar-sm">

                            <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                <i class="fas fa-book"></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="mb-1" style="font-size: 17px;">Công việc hoàn thành</p>
                        <h5 class="mb-3" style="font-size:35px">550/650</h5>

                    </div>
                </div>
            </div>
            <!-- end card-body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->

    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-1 align-self-center">
                        <div class="avatar-sm">

                            <div class="avatar-title bg-light rounded-circle text-primary font-size-20"
                                style="color: orange!important">
                                <i class=" ri-line-chart-line"></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="mb-1" style="font-size: 17px;">Công việc phát sinh</p>
                        <h5 class="mb-3" style="font-size:35px">50</h5>
                    </div>
                </div>
            </div>
            <!-- end card-body -->
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex text-muted">
                    <div class="flex-shrink-0  me-3 align-self-center">
                        <div class="avatar-sm">
                            <div class="avatar-title bg-light rounded-circle text-primary font-size-20"
                                style="color: red!important">
                                <i class=" far fa-bookmark"></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="mb-1" style="font-size: 17px;">Công việc trễ</p>
                        <h5 class="mb-3" style="font-size:35px">100/650</h5>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end col -->
</div>


<div class="row">
    <div class="col-xl-7">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title" style="font-size: 20px">Biểu đồ thống kê công việc tháng 1</h5>
                <div>
                    <ul class="list-unstyled">
                        <li class="py-3">
                            <div class="d-flex">
                                <div class="avatar-xs align-self-center me-3" style="height: 4rem;width:4rem;">
                                    <div class="avatar-title rounded-circle bg-light text-primary font-size-18" style="font-size:30px!important;">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-2" style="font-size: 20px;">Công việc hoàn thành</p>
                                    <div class="progress progress-sm animated-progess" style="height: 12px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 70%"
                                            aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="py-3">
                            <div class="d-flex">
                                <div class="avatar-xs align-self-center me-3" style="height: 4rem;width:4rem;">
                                    <div class="avatar-title rounded-circle bg-light text-primary font-size-18" style="font-size:30px!important;">
                                        <i class="ri-calendar-2-line"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-2" style="font-size: 20px;">Đang thực hiện</p>
                                    <div class="progress progress-sm animated-progess" style="height: 12px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 45%"
                                            aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="py-3">
                            <div class="d-flex">
                                <div class="avatar-xs align-self-center me-3" style="height: 4rem;width:4rem;">
                                    <div class="avatar-title rounded-circle bg-light text-primary font-size-18" style="font-size:30px!important;">
                                        <i class="ri-close-circle-line"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-2" style="font-size: 20px;">Công việc trễ</p>
                                    <div class="progress progress-sm animated-progess" style="height: 12px;">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 19%"
                                            aria-valuenow="19" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <hr>

                <div class="text-center">
                    <div class="row">
                        <div class="col-4">
                            <div class="mt-2" style="font-size: 16px;">
                                <p class="text-muted mb-2">Công việc hoàn thành</p>
                                <h5 class="font-size-16 mb-0" style="color: green;font-size: 30px!important;">70</h5>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mt-2" style="font-size: 16px;">
                                <p class="text-muted mb-2">Đang thực hiện</p>
                                <h5 class="font-size-16 mb-0" style="color: orange;font-size: 30px!important;">45</h5>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mt-2" style="font-size: 16px;">
                                <p class="text-muted mb-2">Công việc đã trễ</p>
                                <h5 class="font-size-16 mb-0" style="color: red;font-size: 30px!important;">19</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card-body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
    <!-- end col -->


    <div class="col-lg-5">
        <div class="card">
            <div class="card-body">

                <div id='fullDiv' style="text-align: center">
                    <img style="    height: 93px; width: 260px;" src="{{ asset('assets/images/logo.png') }}"
                        alt="">
                </div>
                <div id='fullDiv'>
                    <ul class="lichne">
                        <li class="lichne1">SUN</li>
                        <li class="lichne1">MON</li>
                        <li class="lichne1">TUE</li>
                        <li class="lichne1">WED</li>
                        <li class="lichne1">THUR</li>
                        <li class="lichne1">FRI</li>
                        <li class="lichne1">SAT</li>
                        <li class="lichne1">1</li>
                        <li class="lichne1">2</li>
                        <li class="lichne1">3</li>
                        <li class="lichne1">4</li>
                        <li class="lichne1">5</li>
                        <li class="lichne1">6</li>
                        <li class="lichne1">7</li>
                        <li class="lichne1">8</li>
                        <li class="lichne1">9</li>
                        <li class="lichne1">10</li>
                        <li class="lichne1">11</li>
                        <li class="lichne1">12</li>
                        <li class="lichne1">13</li>
                        <li class="lichne1">14</li>
                        <li class="lichne1">15</li>
                        <li class="lichne1">16</li>
                        <li class="lichne1">17</li>
                        <li class="lichne1">18</li>
                        <li class="lichne1">19</li>
                        <li class="lichne1">20</li>
                        <li class="lichne1">21</li>
                        <li class="lichne1">22</li>
                        <li class="lichne1">23</li>
                        <li class="lichne1">24</li>
                        <li class="lichne1">25</li>
                        <li class="lichne1">26</li>
                        <li class="lichne1">27</li>
                        <li class="lichne1">28</li>
                        <li class="lichne1">29</li>
                        <li class="lichne1">30</li>
                        <li class="lichne1">31</li>
                        <li class="lichne1">1</li>
                        <li class="lichne1">2</li>
                        <li class="lichne1">3</li>
                        <li class="lichne1">4</li>
                    </ul>
                </div>

            </div>
            <hr>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Hôm nay</h4>

                    <div class="pe-3" data-simplebar style="max-height: 287px;">
                        <a href="#" class="text-body d-block">
                            <div class="d-flex py-3">
                                <div class="flex-shrink-0 me-3 align-self-center">
                                </div>

                                <div class="flex-grow-1 overflow-hidden">
                                    <h5 class="font-size-14 mb-1">Công việc mới:</h5>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="text-body d-block">
                            <div class="d-flex py-3">
                                <div class="flex-shrink-0 me-3 align-self-center">
                                </div>

                                <div class="flex-grow-1 overflow-hidden">
                                    <h5 class="font-size-14 mb-1">Công việc đến hạng:</h5>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="text-body d-block">
                            <div class="d-flex py-3">
                                <div class="flex-shrink-0 me-3 align-self-center">
                                </div>

                                <div class="flex-grow-1 overflow-hidden">
                                    <h5 class="font-size-14 mb-1">Công việc được giao:</h5>
                                </div>
                            </div>
                        </a>

                    </div>
                    <!-- end card-body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->


        </div>
@include('include.footer')
        </body>

        </html>
