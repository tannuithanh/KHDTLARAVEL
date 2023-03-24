@include('include.header')
<head>
    <!-- Thêm đoạn mã này vào phần head của trang HTML -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  </head>
<div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">DANH SÁCH NHÓM</h4>
    </div>
    <div class="col-lg-6">
        @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>Thông báo!</strong> Tạo nhóm thành công.
        </div>
        @elseif (Session::has('deleteSuccess'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>Thông báo!</strong> Xóa nhóm thành công.
        </div>
        @elseif (Session::has('fail'))
        <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>Thông báo!</strong> Bạn không có quyền chỉnh sửa nhóm này.
        </div>
        @elseif (Session::has('oke'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>Thông báo!</strong> Bạn đã chỉnh sửa thành công.
        </div>
        @endif
        <div class="card">
            <div class="card-body">
                @if ($user->position_id == 1 || $user->position_id == 2 || $user->position_id == 3 || $user->position_id == 4 ||$user->position_id == 5 ||$user->position_id == 6 ||$user->position_id == 10 )
                    
                
                <h4 class="card-title"> <a href="{{ route('addTeams') }}" class="btn btn-danger btn-rounded waves-effect waves-light"><i class="mdi mdi-plus me-1">
                    </i>Thêm nhóm</a></h4>
                @endif
                    <table class="table table-editable table-nowrap align-middle table-edits ">
                        <thead>
                            <tr>
                                <th style="text-align:center; width: 0" class="table-header">STT</th>
                                <th style="text-align:center ;" class="table-header">Tên nhóm</th>
                                <th style="text-align:center ;" class="table-header">Phòng</th>
                                <th style="text-align:center ;" class="table-header">Thao tác</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @php $stt=1 @endphp
                            @foreach ($team as $value)
                            <tr>
                                @if(Session::has('hack') && session('hack') == $value->id)
                                    <th style=" background-color: #00802c3b">{{ $stt++ }}</th>
                                    <th style=" background-color: #00802c3b">{{ $value->name }}</th>
                                    <th style=" background-color: #00802c3b">{{ $value->tenphongban }}</th>
                                @else
                                    <th >{{ $stt++ }}</th>
                                    <th>{{ $value->name }}</th>
                                    <th>{{ $value->tenphongban }}</th>
                                @endif
                                <th style="text-align:center ;"> 
                                    <form action="{{route('deleteTeam',$value->id)}}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        @if ($user->position_id == 1 || $user->position_id == 2 || $user->position_id == 3 || $user->position_id == 4 ||$user->position_id == 5 ||$user->position_id == 6 ||$user->position_id == 10 )
                                            <a href="{{ route('editTeam',$value->id) }}" class="btn btn-outline-secondary btn-sm edit" title="Sửa"><i class="fas fa-pencil-alt"></i></a>
                                            <button type="button" class="btn btn-outline-danger btn-sm delete ri-delete-bin-line" title="Xóa" data-dialog="dialog-{{ $value->id }}"></button>
                                        @endif
                                    </form>
                                </th>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                title: 'Bạn có muốn nhóm này này?',
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