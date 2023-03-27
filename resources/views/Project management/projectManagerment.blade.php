@include('include.header')
<style>
    .anc{
        color: violet
    }
</style>

<div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">Quản lý dự án</h4>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Danh sách công việc <a href="{{ route('creatProject.get') }}"
                        class="btn btn-danger btn-rounded waves-effect waves-light"><i class="mdi mdi-plus me-1"></i>Tạo
                        dự án</a></h4>
                    
               
                <form id="form_search" method="post" name="form_search">
                    @csrf
                    <div class="card-body" style="border: 1px solid; border-radius: 30px; ">
                        <div class="d-flex gap-2 flex-wrap">
                            <div class="btn-group">
                                <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;" class="card-title">
                                    Nhóm:</h4>
                                <select style="width:200px ;" class="form-control form-select" id="validationCustom03"
                                    name="teamId">
                                    <option value="">Tất cả</option>
                                    @foreach ($teams as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="btn-group">
                                <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;" class="card-title">
                                    Nhân sự:</h4>
                                <select style="width:200px ;" class="form-control form-select" id="validationCustom03"
                                    name="userName">
                                    <option value="">Tất cả</option>
                                    @foreach ($userById as $value)
                                        <option value="{{ $value->name }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="btn-group">
                                <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;" class="card-title">
                                    Ngày:</h4>
                                <input class="form-control" type="date" id="example-date-input"
                                    id="validationCustom03" required="" name="Day">
                            </div>
                            <div style="margin-left: 1%;" class="btn-group">
                                <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                            </div>
                        </div>
                    </div>
                </form>
       
                <div class="table-responsive class scrollable-table-wrapper mt-3">
                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <strong>Thông báo!</strong> Đã thêm thành công dự án.
                    </div>
                @elseif (Session::has('status'))
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <strong>Thông báo!</strong> Cập nhật thành công.
                    </div>
                @elseif (Session::has('deleteSuccess'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                        <strong>Thông báo!</strong> Bạn đã xóa thành công.
                    </div>
                @elseif (Session::has('edit'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                        <strong>Thông báo!</strong> Chỉnh sửa dự án thành công.
                    </div>
                @elseif (Session::has('failder'))
 
                    <div class="alert alert-danger alert-dismissible fade show " role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                        <strong>Thông báo!</strong> Đây không phải dự án của bạn, bạn không được truy cập vào dự án này.
                    </div>
                @endif
                    <table class="table table-centered table-nowrap mb-3">
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
                            @php $stt = 1 @endphp
                            @foreach ($project as $value)
                            @php $department_ids = explode(',', $value->department_ids) @endphp
                                @if ( $value->privacy == 0 )
                                    <tr>
                                        <td style="text-align:center ; vertical-align: middle;">{{ $stt++ }}</td>
                                        <td style=" vertical-align: middle;"><a href="{{ route('projectConnect',$value->id) }}">{{ $value->name_project }}<a></td>
                                        <td style=" vertical-align: middle;">{{ $value->describe_project }}</td>
                                        <td style="text-align:center ;vertical-align: middle;">{{ $value->name_create }}
                                        </td>
                                        <td style="text-align:center ;vertical-align: middle;">{{ date('d/m/Y', strtotime($value->start_date)) }}</td>
                                        <td style="text-align:center ;vertical-align: middle;">{{ date('d/m/Y', strtotime($value->end_date)) }}</td>
                                        <td>{!! nl2br($value->department_names) !!}</td>
                                        @if ($today < $value->start_date && $value->status == 0)
                                            <td style="width: 10px">
                                                <i class="mdi mdi-checkbox-blank-circle anc me-1 "></i> Chưa đến hạng
                                            </td>
                                            @elseif($today <= $value->end_date && $value->status == 0)
                                            <td style="width: 10px">
                                                <i class="mdi mdi-checkbox-blank-circle text-warning me-1"></i> Đang thực hiện
                                            </td>
                                            @elseif ($today > $value->end_date && $value->status == 0)
                                            <td style="width: 10px">
                                                <i class="mdi mdi-checkbox-blank-circle text-danger me-1"></i> Trễ kế hoạch
                                            </td>
                                            @elseif ($value->status == 1)
                                            <td style="width: 10px">
                                                <i class="mdi mdi-checkbox-blank-circle text-success me-1"></i> Hoàn thành
                                            </td>
                                            @elseif ($value->status == 2)
                                            <td style="width: 10px">
                                                <i class="mdi mdi-pause-circle-outline text-success me-1"></i> Tạm dừng
                                            </td>
                                            @elseif ($value->status == 3)
                                            <td style="width: 10px">
                                                <i class="mdi mdi-cancel text-danger me-1"></i> Hủy
                                            </td>
                                        @endif
                                        <td style="text-align: center;"> 
                                            <form id="delete-form-{{ $value->id }}"
                                                action="{{ route('deleteProject', $value->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                            @if ($user->name == $value->name_create)
                                            <button type="button" class="btn btn-outline-danger btn-sm delete ri-delete-bin-line" title="Xóa" data-dialog="dialog-{{ $value->id }}"></button>
                                            <a href="{{route('edit.get',$value->id)}}"class="btn btn-outline-secondary btn-sm edit" title="Sửa"><i class="fas fa-pencil-alt"></i></a>
                                            @endif
                                            </form>
                                        </td>
                                    </tr>                              
                                @elseif ( $user['name'] == $value->name_create || in_array($user['department_id'], $department_ids))
                                
                                <tr>
                                    <td style="text-align:center ; vertical-align: middle;">{{ $stt++ }}</td>
                                    <td style=" vertical-align: middle;"><a href="{{ route('projectConnect',$value->id) }}">{{ $value->name_project }}<a></td>
                                    <td style=" vertical-align: middle;">{{ $value->describe_project }}</td>
                                    <td style="text-align:center ;vertical-align: middle;">{{ $value->name_create }}
                                    </td>
                                    <td style="text-align:center ;vertical-align: middle;">{{ date('d/m/Y', strtotime($value->start_date)) }}</td>
                                    <td style="text-align:center ;vertical-align: middle;">{{ date('d/m/Y', strtotime($value->end_date)) }}</td>
                                    <td>{!! nl2br($value->department_names) !!}</td>
                                    @if ($today < $value->start_date && $value->status == 0)
                                        <td style="width: 10px">
                                            <i class="mdi mdi-checkbox-blank-circle anc me-1 "></i> Chưa đến hạng
                                        </td>
                                        @elseif($today <= $value->end_date && $value->status == 0)
                                        <td style="width: 10px">
                                            <i class="mdi mdi-checkbox-blank-circle text-warning me-1"></i> Đang thực hiện
                                        </td>
                                        @elseif ($today > $value->end_date && $value->status == 0)
                                        <td style="width: 10px">
                                            <i class="mdi mdi-checkbox-blank-circle text-danger me-1"></i> Trễ kế hoạch
                                        </td>
                                        @elseif ($value->status == 1)
                                        <td style="width: 10px">
                                            <i class="mdi mdi-checkbox-blank-circle text-success me-1"></i> Hoàn thành
                                        </td>
                                        @elseif ($value->status == 2)
                                        <td style="width: 10px">
                                            <i class="mdi mdi-pause-circle-outline text-success me-1"></i> Tạm dừng
                                        </td>
                                        @elseif ($value->status == 3)
                                        <td style="width: 10px">
                                            <i class="mdi mdi-cancel text-danger me-1"></i> Hủy
                                        </td>
                                    @endif
                                    <td style="text-align: center;"> 
                                        <form id="delete-form-{{ $value->id }}"
                                            action="{{ route('deleteProject', $value->id) }}"
                                            method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                        @if ($user->name == $value->name_create)
                                        <button type="button" class="btn btn-outline-danger btn-sm delete ri-delete-bin-line" title="Xóa" data-dialog="dialog-{{ $value->id }}"></button>
                                        <a href="{{route('edit.get',$value->id)}}"class="btn btn-outline-secondary btn-sm edit" title="Sửa"><i class="fas fa-pencil-alt"></i></a>
                                        @endif
                                        </form>
                                    </td>
                                </tr>                              
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('include.footer')
<script>
// ------------------------------------------ XÓA DỰ ÁN --------------------------------------------------// 
     document.querySelectorAll('.delete').forEach(deleteButton => {
        deleteButton.addEventListener('click', () => {
            Swal.fire({
                title: 'Bạn có muốn xóa dự án này?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy bỏ'
            }).then((result) => {
                console.log(result)
                if (result.isConfirmed) {
                    deleteButton.closest('.delete-form').submit();
                }
            });
        });
    });
</script>
