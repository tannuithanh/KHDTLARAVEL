@include('include.header')


<div class="row">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">Cập nhật dự án</h4>
    </div>  
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <form class="needs-validation" method="post" novalidate="">
                    @csrf
                    <input type="hidden" name="works[0][active]" value="0">
                    @foreach ($project_manager as $index => $value)
                    <div class="mb-3" id="form-create-plan" data-index="{{$index}}">
                  
                        <div style="border-bottom: 3px solid gray!important;">
                           
                            <h2 style="color: red" class="card-title font-weight-bold">{{$value->tenphongban}}</h2>
                            <input type="text" class="form-control" id="validationCustom05" placeholder="" value="{{$value->id}}" hidden name="works[{{$index}}][id]">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="validationCustom04">Tên công việc</label>
                                        <input type="text" class="form-control" id="validationCustom05" placeholder="" value="{{$value->name}}" required="" name="works[{{$index}}][name]">
                                        <div class="invalid-feedback">
                                            Vui lòng nhập dữ liệu.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label" for="validationCustom04">Ngày bắt đầu</label>
                                        <input type="date" class="form-control" id="start_date{{$index}}" placeholder="" value="{{$value->startdate}}" min="{{$start_date}}" max="{{$end_date}}" required="" name="works[{{$index}}][startdate]">
                                        <div class="invalid-feedback">
                                            Vui lòng nhập dữ liệu.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label" for="validationCustom05">Ngày kết thúc</label>
                                        <input type="date" class="form-control" id="end_date" placeholder="" value="{{$value->enddate}}" min="{{$start_date}}" max="{{$end_date}}" required="" name="works[{{$index}}][enddate]">
                                        <div class="invalid-feedback">
                                            Vui lòng nhập dữ liệu.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                        </div>
                        
                    </div>


                    @endforeach
                    <button class="btn btn-primary" type="submit">Cập nhật</button>

                </form>

            </div>
        </div>
        <!-- end card -->
    </div> <!-- end col -->
</div>
@include('include.footer')
