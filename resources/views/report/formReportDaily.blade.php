@include('include.header')
<div class="row">
    <div class="col-xl-5">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">BÁO CÁO CÔNG VIỆC</h4>
        </div>
        <div class="card">
            <div class="card-body">
                <form class="needs-validation"  method="Post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="validationCustom01">Bất cập</label>
                                <textarea type="text" class="form-control" id="validationCustom01" placeholder="Bất cập" value="Mark"  name="inadequacy"></textarea>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="validationCustom02">Đề xuất</label>
                                <textarea type="text" class="form-control" id="validationCustom02" placeholder="Đề xuất" value="Mark"  name="propose"></textarea>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="validationCustom03">Kết quả</label>
                                    <div class="col-md-10">
                                        <select class="form-select" name="Result">
                                            <option disabled selected hidden>Chọn...</option>
                                            <option value="Hoàn Thành" style="background-color: green;color: white">Hoàn Thành</option>
                                            <option value="Không hoàn Thành" style="background-color: rgb(239, 14, 14);color: white">Không hoàn Thành</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                                                    
                    </div>
                   
                    <button class="btn btn-primary" type="submit">Báo cáo</button>
                </form>
                
            </div>
        </div>
        <!-- end card -->
    </div> <!-- end col -->
</div>
@if (Session::has('message'))
<div class="col-lg-5">
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
                <h4 class="alert-heading">Đã xảy ra sự cố</h4>
                <p class="mb-0">Xin lỗi! Bạn vui lòng chọn kết quả</p>
                
            </div>
        </div>
    </div>
</div>
@endif
@include('include.footer')
<script>
 $(document).ready(function() {
  $("#validationCustom01").focus(function() {
    if ($("#validationCustom01").val() === '') {
      $("#validationCustom01").val('- ');
    }
  });

  $("#validationCustom01").keyup(function(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {
      document.getElementById('validationCustom01').value += '- ';
    }
    var txtval = document.getElementById('validationCustom01').value;
    if (txtval.substr(txtval.length - 1) == '\n') {
      document.getElementById('validationCustom01').value = txtval.substring(0, txtval.length - 1);
    }
  });
  $("#validationCustom02").focus(function() {
    if ($("#validationCustom02").val() === '') {
      $("#validationCustom02").val('- ');
    }
  });

  $("#validationCustom02").keyup(function(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {
      document.getElementById('validationCustom02').value += '- ';
    }
    var txtval = document.getElementById('validationCustom02').value;
    if (txtval.substr(txtval.length - 1) == '\n') {
      document.getElementById('validationCustom02').value = txtval.substring(0, txtval.length - 1);
    }
  });
});
</script>