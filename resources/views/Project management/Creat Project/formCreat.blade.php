@include('include.header')
<style>
    table,
    th,
    td {
        border: none !important;
    }
</style>
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
    <h4 class="mb-sm-0">Quản lý dự án</h4>
</div>

<div class="col-xl-6">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Tạo dự án</h4>

            <form method="Post" class="custom-validation" novalidate="">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Tên dự án</label>
                    <div>
                        <input type="text" name="name_project" class="form-control" required=""
                            placeholder="Tên dự án">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ngày/Tháng/Năm</label>
                    <div class="input-daterange input-group" id="datepicker6" data-date-format="dd/mm/yyyy"
                        data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                        <input type="text" class="form-control" name="startdate" id="project_start_date" placeholder="Ngày bắt đầu" />
                        <input type="text" class="form-control" name="enddate" id="project_end_date" placeholder="Ngày kết thúc" />                        
                    </div>
                </div>
                <div class="mb-3" id="department-select">
                    <label class="form-label">Phòng ban tham gia</label>
                    <div id="departments-wrapper">
                        <button type="button" id="add-department" class="btn btn-primary">+</button>
                    </div>
                </div>
                <div>
                    <div>
                        <button type="submit" class="btn btn-primary waves-effect waves-light me-2">
                            Tạo
                        </button>
                        <a class="btn btn-secondary waves-effect">
                            Trở về
                        </a>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@if (Session::has('no'))
    <div class="card alert border mt-4 mt-lg-0 p-0 mb-0">
        <div class="card-header bg-soft-danger">
            <div class="d-flex">
                <div class="flex-grow-1">
                    <h5 class="font-size-16 text-danger my-1">Cảnh báo</h5>
                </div>
                <div class="flex-shrink-0">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="text-center">
                <div class="mb-4">
                    <i class="mdi mdi-alert-outline display-4 text-danger"></i>
                </div>
                <h4 class="alert-heading">Bạn không thể chọn ngày nhỏ hơn hoặc bằng ngày hôm nay</h4>


            </div>
        </div>
    </div>
@endif
@if (Session::has('nono'))
    <div class="card alert border mt-4 mt-lg-0 p-0 mb-0">
        <div class="card-header bg-soft-danger">
            <div class="d-flex">
                <div class="flex-grow-1">
                    <h5 class="font-size-16 text-danger my-1">Cảnh báo</h5>
                </div>
                <div class="flex-shrink-0">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="text-center">
                <div class="mb-4">
                    <i class="mdi mdi-alert-outline display-4 text-danger"></i>
                </div>
                <h4 class="alert-heading">Bạn không thể để trống phòng ban tham gia được</h4>


            </div>
        </div>
    </div>
@endif
@include('include.footer')
<script>
    $(document).ready(function() {
        $("#validationCustom04").focus(function() {
            if ($("#validationCustom04").val() === '') {
                $("#validationCustom04").val('- ');
            }
        });

        $("#validationCustom04").keyup(function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                document.getElementById('validationCustom04').value += '- ';
            }
            var txtval = document.getElementById('validationCustom04').value;
            if (txtval.substr(txtval.length - 1) == '\n') {
                document.getElementById('validationCustom04').value = txtval.substring(0, txtval
                    .length - 1);
            }
        });
    });



    $(document).ready(function () {
        var departments = [
            // Sử dụng dữ liệu từ danh sách phòng ban của bạn
            @foreach ($departments as $value)
                { id: "{{ $value->id }}", name: "{{ $value->name }}" },
            @endforeach
        ];

        $("#project_start_date, #project_end_date").on("change", function () {
        var projectStartDate = $("#project_start_date").val();
        var projectEndDate = $("#project_end_date").val();
        if (projectStartDate && projectEndDate) {
            $("#departments-wrapper .department-row").each(function () {
                $(this).find("input[name='start_date[]']").attr("min", projectStartDate).attr("max", projectEndDate);
                $(this).find("input[name='end_date[]']").attr("min", projectStartDate).attr("max", projectEndDate);
            });
        }
    });
        function convertToISODate(dateString) {
            var parts = dateString.split("/");
            var dateObject = new Date(parts[2], parts[1] - 1, parts[0]);
            return dateObject.toISOString().slice(0, 10);
        }
        function createDepartmentRow() {
            var $row = $("<div>").addClass("department-row");
            
            $row.append('<label class="form-label">Phòng ban:</label>');
            var $select = $("<select>").addClass("form-control").attr("name", "departments[]");
            departments.forEach(function (dept) {
                $select.append($("<option>").attr("value", dept.id).text(dept.name));
            });
            
            $row.append($select);
            
            var projectStartDate = $("#project_start_date").val();
            var projectEndDate = $("#project_end_date").val();
            var isoProjectStartDate = convertToISODate(projectStartDate);
            var isoProjectEndDate = convertToISODate(projectEndDate);
            $row.append('<label class="form-label">Ngày bắt đầu:</label>');
            $row.append('<input type="date" class="form-control" name="start_date[]" placeholder="Ngày bắt đầu" min="' + isoProjectStartDate + '" max="' + isoProjectEndDate + '" required="">');

            $row.append('<label class="form-label">Ngày kết thúc:</label>');
            $row.append('<input type="date" class="form-control" name="end_date[]" placeholder="Ngày kết thúc" min="' + isoProjectStartDate + '" max="' + isoProjectEndDate + '" required="">');

            $row.append('<label class="form-label">Tên công việc:</label>');
            $row.append('<input type="text" class="form-control" name="task_name[]" placeholder="Tên công việc" required="">');

            $row.append('<button type="button" style="margin-top: 10px;" class="btn btn-danger remove-department">Xóa</button>');
            return $row;
        }

        $("#add-department").on("click", function () {
            var $row = createDepartmentRow();
            if ($("#departments-wrapper .department-row").length > 0) {
                var $hr = $('<hr>').css({'height': '5px', 'background-color': '#0000007d'});
                $("#departments-wrapper").append($hr);
            }
            $("#departments-wrapper").append($row);
        });

        $("#departments-wrapper").on("click", ".remove-department", function () {
            if ($(this).closest(".department-row").prev().is("hr")) {
                $(this).closest(".department-row").prev().remove();
            }
            $(this).closest(".department-row").remove();
        });
    });
</script>


