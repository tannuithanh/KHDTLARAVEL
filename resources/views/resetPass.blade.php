<!DOCTYPE html>
<html lang="en">

<head>
    <title>Quên mật khẩu</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="shortcut icon" href="{{asset('assets/images/your-logo (3).png')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/login/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/login/fonts/iconic/css/material-design-iconic-font.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/login/vendor/animate/animate.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/login/vendor/css-hamburgers/hamburgers.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/login/vendor/animsition/css/animsition.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/login/vendor/select2/select2.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/login/vendor/daterangepicker/daterangepicker.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/login/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/login/css/main.css') }}">
    <!--===============================================================================================-->
</head>

<body>

    <div class="limiter">
        <div class="container-login100" style="background-image: url('{{ asset('assets/images/background.JPG') }}');">
            <div class="wrap-login100">
                <form class="login100-form validate-form" method="post">
                    @csrf
                    <img style="width: 100%; margin-left: 8px;" src="{{ asset('assets/images/thacoauto-w.png') }}" alt="">
                    <span style=" font-family: revert;
                    font-size: 30px;
                    font-weight: bold;
                    color: #70a1e2;
                    line-height: 1.2;
                    text-align: center;
                    text-transform: uppercase;
                    display: block;
                    margin-top: 15px">Kế
                        hoạch điện tử</span>
                    <img style="margin-top:30px;border-radius:10%;margin-bottom:5%" class="login100-form-logo" src="{{ asset('assets/images/work-from-home-illustration-concept-man-working-laptop-home_427922-148.webp') }}" alt="">
                    <span style=" font-family: revert;
                        font-size: 30px;
                        color: #fff;
                        line-height: 1.2;
                        text-align: center;
                        text-transform: uppercase;
                        display: block;
                        margin-top: 45px;
                        margin-bottom: 15px">
                        THAY ĐỔI MẬT KHẨU
                    </span>
                    <div class="wrap-input100 validate-input" data-validate="Enter username">
                        <input class="input100" type="password" name="pass" placeholder="Nhập mật khẩu mới">
                        <span class="focus-input100"  data-placeholder="&#xf191;"></span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Enter username">
                        <input class="input100" type="password" name="passComfirm" placeholder="Nhập lại mật khẩu">
                        <span class="focus-input100"  data-placeholder="&#xf191;"></span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Enter username">
                        <input class="input100" type="number" name="recover" placeholder="Nhập mã xác thực">
                        <span class="focus-input100"  data-placeholder="&#xf191;"></span>
                    </div>
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                           Thay đổi
                        </button>
                    </div>

                    <div class="text-center p-t-90">
                        <a class="txt1" href="">
                            Quên mật khẩu?
                        </a>
                    </div>
                    @if (Session::has('faild'))
                    <div style="margin-top:20px" class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                        <strong>Thông báo!</strong> Mật khẩu không khớp.
                    </div>
                    @elseif (Session::has('khongduoc'))
                    <div style="margin-top:20px" class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                        <strong>Thông báo!</strong> Mã xác thực không tồn tại.
                    </div>
                    @endif

                </form>
            </div>
        </div>
    </div>


    <div id="dropDownSelect1"></div>

    <!--===============================================================================================-->
    <script src="{{ asset('assets/login/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('assets/login/vendor/animsition/js/animsition.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('assets/login/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('assets/login/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('assets/login/vendor/select2/select2.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('assets/login/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/login/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('assets/login/vendor/countdowntime/countdowntime.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('assets/login/js/main.js') }}"></script>

</body>

</html>