@include('include.header')
<div class="row">
    <div class="col-xl-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">THÊM NHÓM</h4>
        </div>
        <div class="card">
            <div class="card-body">
                <form class="needs-validation"  method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3 position-relative">
                                <label class="form-label" for="validationTooltip01">Tên nhóm</label>
                                <input type="text" class="form-control" id="validationTooltip01" name="name" placeholder="Tên nhóm" required="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3 position-relative">
                                <label class="form-label" for="validationTooltip02">Phòng ban</label>
                                <select class="form-control form-select" id="validationCustom03" name="departmentsId">
                                    @foreach ($department as $value)
                                    <option value="{{$value->id}}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                  
                    </div>
                    <button class="btn btn-primary" type="submit">Tạo nhóm</button>
                </form>
            </div>
        </div>
        <!-- end card -->
    </div> <!-- end col -->
</div>
@include('include.footer')