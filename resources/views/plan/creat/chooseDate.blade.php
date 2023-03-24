@include('include.header')
<div class="col-12">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                 <form id="form_search"   method="post">
                    @csrf
                            <div class="btn-group">
                                <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;" class="card-title">
                                    Ngày:</h4>
                                    <input type="date" class="form-control" name="week" id="validationTooltip01" placeholder="hãy nhập năm"  required="">
                            </div>
                           
                            <div class="btn-group">
                            </div>

                            <div style="margin-left: 1%;" class="btn-group">
                            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                            
                            </div>
                            <a class="btn btn-secondary waves-effect waves-light" href="{{route('listWorkWeek')}}">Trờ về</a>
                            <h6 style="color: red; margin-top:1%">Hãy chọn ngày để hệ thống xác định số tuần trong tháng</h6>
                        </div><!-- /btn-group -->
                        
            </div>
      
            </form> 
            @if(session('faild'))
            <div class="col-lg-4">
                                <div class="card card-danger">
                                    <h6 class="card-header">Thông báo</h6>
                                    <div class="card-body">
                                        <p class="card-text ">Bạn phải chọn ngày để hệ thống xác định tuần trong tháng.</p>
                                    </div>
                                </div>
                            </div>
            @elseif(session('failder'))
                        <div class="col-lg-4">
                            <div class="card card-danger">
                                <h6 class="card-header">Thông báo</h6>
                                <div class="card-body">
                                    <p class="card-text ">Ngày kết thúc không thể nhỏ hơn ngày bắt đầu. Xin vui lòng chọn lại!</p>
                                </div>
                            </div>
                        </div>                      
            @endif
                </div>

            </div>
        </div>
    </div>
</div>
@include('include.footer')