@include('include.header')
<style>
    textarea[name="describeWeek"] {
  font-size: 18px;
  white-space: pre-wrap;
  word-wrap: break-word;
}
</style>
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
    <h4 class="mb-sm-0">TẠO CÔNG VIỆC TUẦN</h4>
</div>

<div class="col-xl-12">
    <div class="card" style="font-size: 18px">
        <div class="card-body">
            <h3 class="card-title" style="color: red; font-size: 20px;">Công việc tuần @if (session('weekNumber'))
                    {{ session('weekNumber') }}
                    @endif tháng @if (session('month'))
                        {{ session('month') }}
                    @endif
            </h3>
            <form class="custom-validation" method="post">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Hạng mục công việc</label>
                    <input type="text" style="font-size: 18px" class="form-control" name="categoryWeek"
                        required="" placeholder="Tên công việc">
                </div>
                <div class="mb-3">
                    <label class="form-label">Mô tả công việc</label>
                    <textarea id="myTextarea" style="font-size: 18px" type="text" class="form-control" name="describeWeek" required="" placeholder="Mô tả công việc" rows="5"></textarea>
                
                </div>
                <div class="mb-3">
                    <label class="form-label">Hỗ trợ</label>
                    <select class="select2 form-control select2-multiple" name="support[]" multiple data-placeholder="Tên nhân sự hỗ trợ">
                        <option value=""></option> <!-- Option trống -->
                        @foreach ($allUser as $value)
                            <option value="{{ $value->name }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="example-date-input" required multiple="multiple" class="col-md-2 col-form-label">Ngày
                        bắt đầu</label>
                    <select name="startdate" class="form-select">
                        @if (session('weekdays'))
                            @foreach (session('weekdays') as $day)
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="mb-3">
                    <label for="example-date-input" required multiple="multiple" class="col-md-2 col-form-label">Ngày
                        kết thúc</label>
                    <select name="enddate" class="form-select">
                        @if (session('weekdays'))
                            @foreach (session('weekdays') as $day)
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ghi chú</label>
                    <div>
                        <input style="font-size: 18px" type="text" class="form-control" name="note"
                            placeholder="Ghi chú">
                    </div>
                </div>
                <div>
                    <div>
                        <button type="submit" class="btn btn-primary waves-effect waves-light me-1">
                            Tạo
                        </button>
                        <a class="btn btn-secondary waves-effect waves-light" href="{{ route('listWorkWeek') }}">Trở
                            về</a>
                    </div>
                </div>
            </form>
            <ul>

            </ul>
        </div>
    </div>
</div>
@include('include.footer')
<script>
$(document).ready(function() {
var dayNames = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];

$("select[name='startdate'], select[name='enddate']").change(function() {
var startDate = new Date($("select[name='startdate']").val());
var endDate = new Date($("select[name='enddate']").val());

if (endDate.getTime() < startDate.getTime()) {
alert("Ngày kết thúc phải sau ngày bắt đầu.");
return;
}

var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;

$("div[id^='workDescription_']").remove();

// Tính toán chỉ số của ngày bắt đầu trong tuần
var startDayOfWeek = startDate.getDay();

for (var i = 0; i < diffDays; i++) {
var date = new Date(startDate);
date.setDate(startDate.getDate() + i);
var dayOfWeek = dayNames[(startDayOfWeek + i) % 7]; // Lấy ngày trong tuần dựa trên chỉ số và thứ tự ngày
var inputName = "workDescription_" + dayOfWeek;
var inputLabel = "Công việc ngày " + date.toLocaleDateString();

var inputHtml = '<div class="mb-3" id="workDescription_' + dayOfWeek + '"><label class="form-label">' + inputLabel + '</label><select class="form-control" name="' + inputName + '" ><option value="">Không OT</option><option value="OT: 18h30">OT: 18h30</option><option value="OT: 20h45">OT: 20h45</option><option value="OT: 22h15">OT: 22h15</option><option value="OT: 24h"> OT: 24h </option></select></div>';

$("button[type='submit']").before(inputHtml);
}
});
});


</script>
<script>
  $(document).ready(function() {
  $("#myTextarea").focus(function() {
    if ($("#myTextarea").val() === '') {
      $("#myTextarea").val('- ');
    }
  });

  $("#myTextarea").keyup(function(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {
      document.getElementById('myTextarea').value += '- ';
    }
    var txtval = document.getElementById('myTextarea').value;
    if (txtval.substr(txtval.length - 1) == '\n') {
      document.getElementById('myTextarea').value = txtval.substring(0, txtval.length - 1);
    }
  });
});
    </script>

