@include('include.header')
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">CẬP NHẬT CÔNG VIỆC NGÀY TỪ KẾ HOẠCH TUẦN</h4> 
    </div>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <form class="needs-validation"  method="post">
                    @csrf
                    <div class="mb-3" id="form-create-plan">
                        <div style="border-bottom: 3px solid gray!important;">
                            <h2 class="card-title font-weight-bold">Công Việc ngày</h2>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="validationCustom03">Hạng Mục Công Việc</label>
                                        <input readonly type="text" value="{{$workDaily->categoryDaily}}" class="form-control" id="validationCustom03" placeholder="hạng mục công việc" name="categoryDaily" required="">
                                
                                        <div class="invalid-feedback">
                                            Vui lòng nhập dữ liệu.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="validationCustom04">Chi Tiết Công Việc</label>
                                        <textarea rows="1" value="{{$workDaily->describeDaily}}" cols="" type="text" class="form-control" id="validationCustom04" placeholder="Chi tiết công việc"  required="" name="describeDaily"></textarea>
                                        <div class="invalid-feedback">
                                            Vui lòng nhập dữ liệu.
                                        </div>
                                    </div>
                                </div>                                  
                         
                                    <div class="col-md-2">
                                      <div class="mb-3">
                                        <input class="form-check-input" type="checkbox" value="option1" id="option1" name="option" checked >
                                        <label class="form-label">Tăng ca</label>
                                        <div id="option1-content">
                                        <select class="form-control" name="time">
                                          <option value="OT: 18h30">OT: 18h30</option>
                                          <option value="OT: 20h45">OT: 20h45</option>
                                          <option value="OT: 22h15">OT: 22h15</option>
                                          <option value="OT: 24h"> OT: 24h </option>
                                        </select>
                                      </div>
                                    </div> 
                                </div>                                                   
                                    <div class="col-md-2">
                                      <div class="mb-3">
                                        <input class="form-check-input" type="checkbox" value="option2" id="option2" name="option" >
                                        <label class="form-label" for="validationCustom05">Thời lượng</label>
                                        <div id="option2-content" style="display:none;">
                                        <input type="number" class="form-control" id="validationCustom05" placeholder="" > 
                                      </div>
                                    </div>
                                  </div>
                                  
                                
                            </div>

                            <div class="row">
                            <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="validationCustom05">Ngày\Tháng\Năm</label>
                                        <input readonly value="{{$workDaily->date}}" type="date" class="form-control" id="validationCustom05" placeholder="" required="" name="date">
                                        <div class="invalid-feedback">
                                            Vui lòng nhập dữ liệu.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="mb-3">
                                      <label class="form-label" for="validationCustom03">Hỗ Trợ</label>
                                      <select class="select2 form-control select2-multiple" name="support[]" multiple data-placeholder="Tên nhân sự hỗ trợ">
                                        <option value=""></option> <!-- Option trống -->
                                        @foreach ($allUser as $value)
                                            <option value="{{ $value->name }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                  </div>
                              </div>
                                <div class="col-md-4">
                                  <div class="mb-3">
                                      <label class="form-label" for="validationCustom03">Mục tiêu  ( Hiện tại là <span style="color:red">{{$countWorkWeek_id->total}}%</span> )</label>
                                      <input type="number" style="font-size: 18px" class="form-control" min="1" max="{{100 - $countWorkWeek_id->total}}" name="ResultByWookWeek" required="" placeholder="%">
                                  </div>
                              </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="validationCustom08">ghi chú</label>
                                        <textarea type="text" class="form-control" id="validationCustom04" placeholder=""  name="note"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
{{-- 
                    <button type="button" id="add-form-create" class="btn btn-info waves-effect waves-light">Thêm Công Việc</button> --}}
                    <button class="btn btn-primary" type="submit">Cập nhật</button>

                </form>

            </div>
        </div>
        <!-- end card -->
    </div> <!-- end col -->
</div>

@include('include.footer')
<script>
    $(document).ready(function() {
      $('input[type="checkbox"]').click(function() {
        var option = $(this).val();
        if ($(this).prop('checked')) {
          if (option == 'option1') {
            $('#option1-content').show();
            $('#option1-content select').attr('name','time');
            $('#option2-content').hide().removeAttr('name');
          } else if (option == 'option2') {
            $('#option2-content').show();
            $('#option2-content input[type="number"]').attr('name','time');
            $('#option1-content').hide().removeAttr('name');
          }
        } 
      });
    });
  const checkboxes = document.querySelectorAll('input[name="option"]');
  checkboxes.forEach((checkbox) => {
    checkbox.addEventListener('change', () => {
      checkboxes.forEach((otherCheckbox) => {
        if (otherCheckbox !== checkbox) {
          otherCheckbox.checked = false;
        }
      });
    });
  });

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