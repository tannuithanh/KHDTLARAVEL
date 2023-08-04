</div>

</div>
<!-- End Page-content -->

<footer class="footer">
    <div class="container-fluid">
        <div class="row">

        </div>
    </div>
</footer>

</div>
<!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->
<div class="right-bar">
    
</div>
<!-- /Right-bar -->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>document.write(new Date().getFullYear())</script>  <i class="ri-truck-fill"></i> TRUNG TÂM R&D Ô tô
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                <i class="ri-phone-fill"></i> hoteline: 0886418363
                </div>
            </div>
        </div>
    </div>

</footer>
<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>
<script src="{{asset('assets/js/jquery-3.7.0.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>
<script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/libs/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('assets/libs/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<script src="{{asset('assets/js/select2.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('assets/libs/spectrum-colorpicker2/spectrum.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
<script src="{{asset('assets/js/app.js')}}"></script>
<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@pnotify/core@5/dist/PNotify.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@pnotify/mobile@5/dist/PNotifyMobile.js"></script>

</body>
</html>
<script>
$(document).ready(function() {
    $('.select2').select2();
});
</script>
<script>
    
$(window).on('load', function() {
  $('#preloader').fadeOut('slow');
});



</script>
<script>
$(document).ready(function() {
    // Kết nối đến Pusher
    var pusher = new Pusher('7d8971148f0705c48349', {
        cluster: 'ap1'
    });

    // Đăng ký kênh và sự kiện cho công việc ngày
    var dailyChannel = pusher.subscribe('workdaily');
    dailyChannel.bind('WorkdailyStatusUpdated', function(data) {
        var message = data.message;
        showPNotifyNotification(message);
    });

    // Đăng ký kênh và sự kiện cho công việc tháng
    var monthlyChannel = pusher.subscribe('workmonth');
    monthlyChannel.bind('WorkmonthStatusUpdated', function(data) {
        var message = data.message;
        showPNotifyNotification(message);
    });
});

let stackBottomLeft = new PNotify.Stack({
    dir1: "up",
    dir2: "right",
    firstpos1: 20,
    firstpos2: 20,
    context: document.body,
    remove: false,  // Đặt thành false để ngăn thông báo cũ bị loại bỏ
    maxOpen: 2,  // Số lượng thông báo tối đa mở cùng một lúc
    modal: false,  // Đặt modal là false để loại bỏ tính chất modalish
    overlayClose: false  // Đặt overlayClose là false để ngăn người dùng đóng thông báo bằng cách nhấp vào màn hình
});


// Sử dụng Stack trong thông báo
function showPNotifyNotification(message) {
    PNotify.notice({
        title: 'THÔNG BÁO',
        text: message,
        stack: stackBottomLeft,
        modules: new Map([
            ...PNotify.defaultModules,
        ])
    });
}
</script>