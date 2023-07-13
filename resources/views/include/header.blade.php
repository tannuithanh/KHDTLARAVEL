<!doctype html>
<html lang="en">
    <title>{{ $title ?? 'Trang chủ' }}</title>
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" /> -->
    <meta content="Themesdesign" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/your-logo (3).png') }}">
    <!-- jvectormap -->
    <link href="{{ asset('assets/libs/jqvmap/jqvmap.min.css') }}" rel="stylesheet" />
   
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/js/sweetalert2.min.css')}} " id="app-style" rel="stylesheet" type="text/css" />

    

<style>
        body {
        font-family: 'Times New Roman', Times, serif !important;
    }
        #preloader {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ffffff;
    z-index: 1001;
    display: flex;
    align-items: center;
    justify-content: center;
    }

    .spinner {
    width: 150px;
    height: 150px;
    position: relative;
    margin: 100px auto;
    }

    .double-bounce1, .double-bounce2 {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background-color: #333;
    opacity: 0.6;
    position: absolute;
    top: 0;
    left: 0;
    animation: sk-bounce 2.0s infinite ease-in-out;
    }

    .double-bounce2 {
    animation-delay: -1.0s;
    }

    @keyframes sk-bounce {
    0%, 100% { 
        transform: scale(0.0);
    } 50% { 
        transform: scale(1.0);
    }
    }

</style>


</head>

<body data-sidebar="dark">
    <div id="preloader">
        <div class="spinner">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
    </div>
    
    <div class="right-bar">
        <div data-simplebar="init" class="h-100">
            <div class="simplebar-wrapper" style="margin: 0px;">
                <div class="simplebar-height-auto-observer-wrapper">
                    <div class="simplebar-height-auto-observer"></div>
                </div>
               
                <div class="simplebar-placeholder" style="width: auto; height: 850px;"></div>
            </div>
            <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
            </div>
            <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: block; height: 118px;"></div>
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
                                <img src="{{ asset('assets/images/logo-dark1.png') }}" alt="logo-dark" height="35">
                            </span>
                        </a>
                        <a href="{{ route('DashBoard') }}" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset('assets/images/logo-sm1.png') }}" alt="logo-sm-light" height="25">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('assets/images/logo-dark1.png') }}" alt="logo-light" height="63">
                            </span>
                        </a>
                    </div>
                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button>
                </div>
                <div class="d-flex">
                    <div class="d-flex">
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="{{ asset('assets/images/users/avatar-2.jpg') }}" alt="Header Avatar">
                                <span style="margin-top:2%" class="d-none d-xl-inline-block ms-1">{{ $user->name }}<br></span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>

                            </button>


                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('profile') }}"><i class=" ri-user-line" style="margin-right:4%;"></i>Thông tin cá nhân</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('departments.view') }}"><i class="ri-layout-masonry-line" style="margin-right:4%;"></i>Thông tin phòng
                                    ban</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('listUser.view') }}"><i class="ri-file-list-line" style="margin-right:4%;"></i>Quản lý nhân sự</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('listTeam.view') }}"><i class="ri-team-line" style="margin-right:4%;"></i>Quản lý nhóm</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger"  id="logout-btn"  href="{{ route('Logout') }}"><i class="ri-shut-down-line align-middle me-1 text-danger"></i>Đăng xuất</a>
                            </div>
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
                                <span>Kế hoạch ngày</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{route('viewDenyDaily')}}">Từ chối & Cập nhật</a></li>
                                <li><a href="{{route('viewApproveDaily')}}">Duyệt & Kiểm tra</a></li>
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
                                <li><a href="{{route('viewDenyWeek')}}">Từ chối & Cập nhật</a></li>
                                <li><a href="{{ route('viewApproveWeek')}}">Duyệt & Kiểm tra</a></li>
                                <li><a href="{{route('listWorkWeek')}}">Đang thực hiện</a></li>
                                <li><a href="{{ route('listReportWeekly') }}">Báo cáo</a></li>
                                <li><a href="{{ route('ChartWeek') }}">Biểu đồ</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-book-read-fill"></i>
                                <span>Kế hoạch dài hạn</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{route('viewDenyMonth')}}" >Từ chối & Cập nhật</a></li>
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