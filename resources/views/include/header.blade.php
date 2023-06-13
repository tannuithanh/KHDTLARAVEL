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
   
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Bootstrap Css -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    
    <link href="{{ asset('assets/css/chunhapnhay.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/lich.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/thongbao.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/xuongdong.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/pageloading.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://d3js.org/d3.v4.min.js"></script>

    

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
                                        <img src="assets/images/layouts/layout-1.png" class="img-thumbnail" alt="layout-1">
                                    </div>

                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked="">
                                        <label class="form-check-label" for="light-mode-switch">Chế độ sáng</label>
                                    </div>

                                    <div class="mb-2">
                                        <img src="assets/images/layouts/layout-2.png" class="img-thumbnail" alt="layout-2">
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch" data-bsstyle="assets/css/bootstrap-dark.min.css" data-appstyle="assets/css/app-dark.min.css">
                                        <label class="form-check-label" for="dark-mode-switch">Chế độ tối</label>
                                    </div>

                                    <div class="mb-2">
                                        <img src="assets/images/layouts/layout-3.png" class="img-thumbnail" alt="layout-3">
                                    </div>
                                    <div class="form-check form-switch mb-5">
                                        <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch" data-appstyle="assets/css/app-rtl.min.css">
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
                        <div class="dropdown d-none d-lg-inline-block ms-1">
                            <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ri-apps-2-line"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end" style="">
                                <div class="px-lg-2">
                                    <div class="row g-0">
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="http://113.161.6.179:8089/RD/">
                                        
                                                <span>CHỮ KÝ ĐIỆN TỬ</span>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="http://113.161.6.179:8089/mahoatenduan/">
                                               
                                                <span>MÃ HÓA TÊN DỰ ÁN</span>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="http://113.161.6.179:8089/QLTB/">
                                      
                                                <span>QUẢN LÝ THIẾT BỊ</span>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="https://eoffice.thacochulai.vn/">
                                      
                                                <span>THACO EOFFICE</span>
                                            </a>
                                        </div>
                                    </div>
    
                                 
                                </div>
                            </div>
                        </div>
                    <div class="dropdown d-inline-block d-lg-none ms-2">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-search-line"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
                            <form class="p-3">
                                <div class="mb-3 m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ...">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit"><i class="ri-search-line"></i></button>
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
                                <span>Quản lý dự án</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-book-read-fill"></i>
                                <span>Kế hoạch ngày</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{route('viewDenyDaily')}}">Từ chối</a></li>
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
                                <li><a href="{{route('viewDenyWeek')}}">Từ chối</a></li>
                                <li><a href="{{ route('viewApproveWeek')}}">Duyệt & Kiểm tra</a></li>
                                <li><a href="{{route('listWorkWeek')}}">Đang thực hiện</a></li>
                                <li><a href="{{ route('listReportWeekly') }}">Báo cáo</a></li>
                                <li><a href="{{ route('ChartWeek') }}">Biểu đồ</a></li>
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
                                <li><a >Biểu đồ</a></li>
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