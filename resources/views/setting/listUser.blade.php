@include('include.header')
<head>

  </head>
<div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">DANH SÁCH NHÂN SỰ</h4>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                @if (Session::has('successful'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Thông báo!</strong> Đã thêm thành công nhân sự mới.
                </div>
                @elseif (Session::has('success'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Thông báo!</strong> Đã sửa thành công thông tin nhân sự.
                </div>
                
                @elseif(Session::has('deleteSuccess'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Thông báo!</strong> Bạn đã xóa thành công nhân sự.
                </div>
                @endif

                @if ( $user->position_id == 11 ||$user->position_id == 5 ||$user->position_id == 6 ||$user->position_id == 10 )
                    
                
                <h4 class="card-title"> <a href="{{ route('addUsers') }}" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-plus me-1">
                    </i>Thêm nhân sự</a></h4>
                @endif
                @if ( $user->position_id == 1 ||$user->position_id == 2 ||$user->position_id == 3 ||$user->position_id == 4 )   
                <form id="form_search" method="post">
                    @csrf
                    <div class="card-body" >
                        <div class="d-flex gap-2 flex-wrap">
                            <div class="btn-group">
                                <h4 style="margin-right:1%; min-width: max-content;margin-top:10px;" class="card-title">
                                    Phòng:</h4>
                                <select style="width:200px ;" class="form-control form-select" id="validationCustom03" name="departmentsId">
                                    <option value="">Tất cả</option>
                                    @foreach ($departmentAll as $value)
                                    <option value="{{$value->id}}">{{$value->name}}</option>   
                                    @endforeach
                                </select>
                            </div>

                            <div style="margin-left: 1%;" class="btn-group">
                                <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                            </div>
                        </div><!-- /btn-group -->
                    </div>
                </form>
                @endif 
                    <table class="table table-editable table-nowrap align-middle table-edits ">
                        <thead>
                            <tr>
                                <th style="text-align:center ;" class="table-header">STT</th>
                                <th style="text-align:center ;" class="table-header">Họ và Tên</th>
                                <th style="text-align:center ;" class="table-header">Email</th>
                                <th style="text-align:center ;" class="table-header">MSNV</th>
                                <th style="text-align:center ;" class="table-header">Phòng ban</th>
                                <th style="text-align:center ;" class="table-header">Nhóm</th>
                                <th style="text-align:center ;" class="table-header">Chức vụ</th>
                                @if ( $user->position_id == 11 ||$user->position_id == 5 ||$user->position_id == 6 ||$user->position_id == 10 )
                                <th style="text-align:center ;" class="table-header">Thao tác</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ( $allUser as $value )
                                    <tr>
                                        <th style="text-align:center ;width:0">
                                            {{ ($allUser->currentPage() - 1) * $allUser->perPage() + $loop->iteration }}
                                        </th>
                                        @if ($user->id == $value->id)
                                            <th style="color:red;">{{ $value->name }}</th>
                                        @else
                                            <th >{{ $value->name }}</th>
                                        @endif
                                        <th >{{ $value->email }}</th>
                                        <th style="text-align:center ;">{{ $value->msnv }}</th>
                                        <th >{{ $value->tenphongban }}</th>
                                        <th >{{ $value->tennhom }}</th>
                                        <th >{{ $value->tenchucvu }}</th>
                                        @if ( $user->position_id == 11 ||$user->position_id == 5 ||$user->position_id == 6 ||$user->position_id == 10 )
                                            <th style="text-align:center ;">
                                                <form method="POST" action="{{route('deleteUsers',$value->id)}}" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('editUsers',$value->id) }}" class="btn btn-outline-secondary btn-sm edit" title="Sửa"><i class="fas fa-pencil-alt"></i></a>
                                                    <button type="button" class="btn btn-outline-danger btn-sm delete ri-delete-bin-line" title="Xóa" data-dialog="dialog-{{ $value->id }}"></button>
                                                </form>
                                            </th>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                    </table>
                    <div >
                    {!!  $allUser->links('pagination::bootstrap-4') !!}
                </div>
                </div>

            </div>
        </div>
    </div>
</div>
@include('include.footer')
<script>
    document.querySelectorAll('.delete').forEach(deleteButton => {
        deleteButton.addEventListener('click', () => {
            Swal.fire({
                title: 'Bạn có muốn xóa nhân sự này?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy bỏ'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteButton.closest('.delete-form').submit();
                }
            });
        });
    });
</script>