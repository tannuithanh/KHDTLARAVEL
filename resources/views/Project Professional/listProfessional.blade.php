@include('include.header')
<div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0" style="font-size:20px">DỰ ÁN KHỐI NGHIỆP VỤ</h4>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Danh sách dự án</h4>

                <div class="table-responsive">
                    <button type="button" id="addProject" class="themduan btn btn-outline-success waves-effect waves-light">Thêm dự án</button>
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên dự án</th>
                                <th>Phòng ban</th>
                                <th>Người tạo</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày kết thúc</th>
                                <th>Kết quả</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $stt=1 @endphp
                                @if (!$projectpro->isEmpty())
                                    @foreach ($projectpro as $value)
                                        <tr>
                                            <th>{{$stt++}}</th>
                                            <td><a href="{{ route('listProChild1', ['id' => $value->id]) }}">{{$value->name}}</a></td>
                                            <td>{{ $value->department->name}}</td>
                                            <td>{{ $value->user->name}}</td>
                                            <td>{{ date('d/m/Y', strtotime($value->startdate)) }}</td>
                                            <td>{{ date('d/m/Y', strtotime($value->enddate)) }}</td>
                                            <td>{{$value->completion}}%</td>
                                            <td>
                                                @if ($value->status == 0 && $value->enddate < $ngayHienTai)
                                                    <span style="color: red;">Trễ kế hoạch</span>
                                                @elseif ($value->status == 0 && $value->enddate > $ngayHienTai)
                                                    <span style="color:#ff8206;">Đang thực hiện</span>
                                                @elseif ($value->status == 0 && $value->startdate < $ngayHienTai)
                                                    <span style="color: black;">Chưa đến hạng</span>
                                                @elseif ($value->status == 1)
                                                    <span style="color: green;">Hoàn Thành</span>
                                                @endif
                                            </td>                                    
                                            <td>
                                                {{-- NÚT XÓA --}}
                                                    @if ($value->user_id == $user['id'])
                                                    <button type="button" class="btn btn-outline-danger btn-sm delete ri-delete-bin-line" title="Xóa" data-dialog="dialog-{{ $value->id }}" data-id="{{ $value->id }}"></button>
                                                    @endif
                                                {{-- NÚT KHÓA DỰ ÁN--}}
                                                    @if ($value->lock==0)
                                                        <button type="button" class="btn btn-outline-danger btn-sm lock ri-rotate-lock-fill" title="lock" data-dialog="dialog-{{ $value->id }}" data-id="{{ $value->id }}"></button>
                                                    @else
                                                        <button type="button" class="btn btn-outline-primary  btn-sm lock ri-lock-unlock-fill" title="UnLock" data-dialog="dialog-{{ $value->id }}" data-id="{{ $value->id }}"></button>
                                                    @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td style="text-align: center;" colspan="9"> Không có dữ liệu</td>
                                    </tr>
                                @endif             
                        </tbody>  
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@include('include.footer')
<script>
    $.ajaxSetup({
        headers: {
                'X-CSRF-TOKEN': '{!! csrf_token() !!}'
            }
    });
    //------------- THÊM DỰ ÁN BẰNG SWEETALERT2 ----------//
        document.getElementById('addProject').addEventListener('click', function() {
        Swal.fire({
            title: 'Thêm dự án',
            html:
            '<label for="swal-input1">Tên dự án</label>' +
            '<input id="swal-input1" class="swal2-input">' +
            '<label for="swal-input2">Ngày bắt đầu</label>' +
            '<input id="swal-input2" class="swal2-input" type="date">' +
            '<label for="swal-input3">Ngày kết thúc</label>' +
            '<input id="swal-input3" class="swal2-input" type="date">',
            focusConfirm: false,
            preConfirm: () => {
            return [
                document.getElementById('swal-input1').value,
                document.getElementById('swal-input2').value,
                document.getElementById('swal-input3').value
            ]
            }
        }).then((result) => {
            if (result.isConfirmed) {
            // Kiểm tra ngày
            if (new Date(result.value[2]) < new Date(result.value[1])) {
                // Nếu ngày kết thúc nhỏ hơn ngày bắt đầu, hiển thị cảnh báo
                Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: 'Ngày kết thúc không được bé hơn ngày bắt đầu',
                });
            } else {
                // Nếu ngày hợp lệ, tiếp tục gửi yêu cầu AJAX
                $.ajax({
                url: "{!!route('insertPP')!!}",
                type: 'POST',
                data: {
                    name: result.value[0],
                    startdate: result.value[1],
                    enddate: result.value[2],
                },
                success: function(response) {
                        Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: 'thêm dự án thành công',
                    }).then(() => {
                        location.reload();
                    }); 
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Xử lý khi có lỗi xảy ra
                }
                });
            }
            }
        })
        });


</script>