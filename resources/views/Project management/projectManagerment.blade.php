@include('include.header')
<div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">Quản lý dự án</h4>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Danh sách công việc <a href="{{route('creatProject.get')}}"
                    class="btn btn-danger btn-rounded waves-effect waves-light"><i class="mdi mdi-plus me-1"></i>Tạo dự án</a></h4>
              
                    @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                        <strong>Thông báo!</strong> Đã thêm thành công dự án.
                    </div>
                    @elseif (Session::has('status'))
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <strong>Thông báo!</strong> Cập nhật thành công.
                    </div>
                    @endif
                <form id="form_search" method="post" name="form_search">
                    @csrf
                    <div class="card-body" style="border: 1px solid; border-radius: 30px; ">
                        <div class="d-flex gap-2 flex-wrap">
                            <div class="btn-group">
                                <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;" class="card-title">
                                    Nhóm:</h4>
                                <select style="width:200px ;" class="form-control form-select" id="validationCustom03" name="teamId">
                                    <option value="">Tất cả</option>
                                    @foreach ($teams as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="btn-group">
                                <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;" class="card-title">
                                    Nhân sự:</h4>
                                <select style="width:200px ;" class="form-control form-select" id="validationCustom03" name="userName">
                                    <option value="">Tất cả</option>
                                    @foreach ($userById as $value)
                                    <option value="{{ $value->name }}">{{ $value->name }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="btn-group">
                            <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;" class="card-title">Ngày:</h4>
                            <input class="form-control" type="date" id="example-date-input" id="validationCustom03"
                                required="" name="Day">
                            </div>
                            <div style="margin-left: 1%;" class="btn-group">
                            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                            </div>
                        </div>
            </div>
            </form>
                <div class="table-responsive class scrollable-table-wrapper mt-3">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="text-align:center ;" class="table-header">STT</th>
                                <th style="text-align:center ;" class="table-header">Tên dự án</th>
                                <th style="text-align:center ;" class="table-header">Mô tả dự án</th>
                                <th style="text-align:center ;" class="table-header">Trưởng dự án</th>
                                <th style="text-align:center ;" class="table-header">Ngày bắt đầu</th>
                                <th style="text-align:center ;" class="table-header">Ngày kết thúc</th>
                                <th style="text-align:center ;" class="table-header">Phòng ban tham gia</th>
                                <th style="text-align:center ;" class="table-header">Trạng thái</th>
                                <th style="text-align:center ;" class="table-header">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@include('include.footer')
