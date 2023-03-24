@include('include.header')
<style>
    table, th, td {
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

            <form  method="Post" class="custom-validation" novalidate="">
                    @csrf
                <div class="mb-3">
                    <label class="form-label">Tên dự án</label>
                    <div>
                        <input type="text" name="name_project" class="form-control" required="" placeholder="Tên dự án">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mô tả dự án</label>
                    <div>
                        <textarea id="validationCustom04" type="text" name="describe_project" class="form-control" required="" placeholder="Mô tả dự án"></textarea>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ngày/Tháng/Năm</label>
                    <div class="input-daterange input-group" id="datepicker6" data-date-format="dd/mm/yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                        <input type="text" class="form-control" name="start_date" placeholder="Ngày bắt đầu" />
                        <input type="text" class="form-control" name="end_date" placeholder="Ngày kết thúc" />
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Phòng ban tham gia</label>
                    <select class="select2 form-control select2-multiple" name="departments[]" multiple data-placeholder="Tên nhân sự hỗ trợ">
                        <option value=""></option> <!-- Option trống -->
                        @foreach ($departments as $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3" >
                    <label class="form-label" >Chế độ</label>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="1" checked="">
                        <label class="form-check-label" for="exampleRadios1">
                            Công khai
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="2">
                        <label class="form-check-label" for="exampleRadios2">
                            Riêng tư
                        </label>
                    </div>
                    <label class="form-check-label" for="exampleRadios2" style="color:red">
                        Ghi chú: Chế độ riêng tư sẽ ẩn đối với những phòng ban không có trong danh sách dự án
                    </label>
                </div>
                <div>
                    <div>
                        <button type="submit" class="btn btn-primary waves-effect waves-light me-2">
                            Tạo
                        </button>
                        <a href="{{route('listProjectManagerment')}}" class="btn btn-secondary waves-effect">
                            Trở về
                        </a>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
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
    document.getElementById('validationCustom04').value = txtval.substring(0, txtval.length - 1);
  }
});
});
</script>