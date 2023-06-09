@include('include.header')
<div class="row">
    <div class="col-xl-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">SỬA THÔNG TIN NHÂN SỰ</h4>
        </div>
        <div class="card">
            <div class="card-body">
                <form class="needs-validation" novalidate="" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3 position-relative">
                                <label class="form-label" for="validationTooltip01">Họ và Tên</label>
                                <input type="text" class="form-control" id="validationTooltip01"  name="name" value="{{$userById->name}}" placeholder="Họ và tên" required="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3 position-relative">
                                <label class="form-label" for="validationTooltip02">Mail</label>
                                <input type="email" class="form-control" id="validationTooltip02" name="email" value="{{$userById->email}}" placeholder="...@thaco.com.vn"  required="">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="mb-3 position-relative">
                                <label class="form-label" for="validationTooltip02">MSNV</label>
                                <input type="email" name="msnv" class="form-control" id="validationTooltip02" value="{{$userById->msnv}}" placeholder="MSNV"  required="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3 position-relative">
                                <label class="form-label" for="validationTooltip02">Phòng ban</label>
                                <select class="form-control form-select" id="validationCustom03" name="department_id">
                                    @foreach ($department as $value)
                                    <option value="{{$value->id}}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3 position-relative">
                                <label class="form-label" for="validationTooltip02">Nhóm</label>
                                <select class="form-control form-select" id="validationCustom03" name="team_id">
                                    <option value="">Không có nhóm</option>
                                    @foreach ($team as $value)
                                    <option value="{{$value->id}}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3 position-relative">
                                <label class="form-label" for="validationTooltip02">Chức vụ</label>
                                <select class="form-control form-select" id="validationCustom03" name="position_id">
                                    @foreach ($position as $value)
                                    <option value="{{$value->id}}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Sửa</button>
                    <a class="btn btn-secondary waves-effect waves-light" href="{{route('listUser.view')}}">Trờ về</a>
                </form>
            </div>
        </div>
    </div> 
</div>
@include('include.footer')