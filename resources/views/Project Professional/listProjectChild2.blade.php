@include('include.header')
<div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0" style="font-size:20px">DỰ ÁN KHỐI NGHIỆP VỤ</h4>
        <h4 class="mb-sm-0" style="font-size:20px"><a href="{{ route('listProChild1', ['id' => $projectprochild1->projectpro_id]) }}"
            type="button" class="btn btn-info"><i class="mdi mdi-keyboard-return"></i></a></h4>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" mb-3 mt-2" style="border: 1px solid;">
                    <h4 class="card-title" style="font-size:18px; font-family: 'Times New Roman', Times, serif !important;">Tên công việc: <span style="color: red"> {{$projectprochild1->name}}</span> </h4>
                    <h4 class="card-title" style="font-size:18px; font-family: 'Times New Roman', Times, serif !important;">Trách nhiệm: <span style="color: red"> {{$projectprochild1->user->name}}</span>  </h4>
                    <h4 class="card-title" style="font-size:18px; font-family: 'Times New Roman', Times, serif !important;">Ngày bắt đầu: <span style="color: red"> {{ date('d/m/Y', strtotime($projectprochild1->startdate)) }}</span></h4>
                    <h4 class="card-title" style="font-size:18px; font-family: 'Times New Roman', Times, serif !important;">Ngày kết thúc: <span style="color: red"> {{ date('d/m/Y', strtotime($projectprochild1->enddate)) }}</span></h4>
                </div>
                <div class="table-responsive">
                  @if ($projectprochild1->user_id == $user['id'])
                    <button type="button" id="addProject" class="themcongviec btn btn-outline-success waves-effect waves-light">Thêm công việc</button>
                  @endif 
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên công việc</th>
                                <th>Trách nhiệm</th>
                                <th>Phòng ban</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày kết thúc</th>
                                <th>ghi chú</th>
                                <th>Kết quả</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @php $stt=1 @endphp
                                @if (!$projectprochild2->isEmpty())
                                    @foreach ($projectprochild2 as $value)
                                        <tr data-id="{{ $value->id }}">
                                            <th>{{$stt++}}</th>
                                            <td>{{$value->name}}</td>
                                            <td>{{ $value->user->name}}</td>
                                            <td>{{ $value->department->name}}</td>
                                            <td>{{ date('d/m/Y', strtotime($value->startdate)) }}</td>
                                            <td>{{ date('d/m/Y', strtotime($value->enddate)) }}</td>
                                            <td class="note-cell">{!! nl2br($value->note) !!}</td>
                                            <td class="completion">{{$value->completion}}%</td>
                                            <td class="status">
                                                @if ($value->status == 0 && $value->enddate < $ngayHienTai && $value->completion < 100)
                                                    <span style="color: red;">Trễ kế hoạch</span>
                                                @elseif ($value->status == 0 && $value->enddate > $ngayHienTai && $value->completion < 100)
                                                    <span style="color:#ff8206;">Đang thực hiện</span>
                                                @elseif ($value->status == 0 && $value->startdate < $ngayHienTai && $value->completion < 100)
                                                    <span style="color: black;">Chưa đến hạng</span>
                                                @elseif ($value->completion == 100 )
                                                    <span style="color: green;">Hoàn Thành</span>
                                                @endif
                                            </td>                                    
                                            <td>
                                            @if($projectpro->lock == 0)
                                                {{-- NÚT XÓA, SỬA --}}
                                                    @if ($projectprochild1->user_id == $user['id'] && $value->completion != 100)
                                                        <button type="button" class="btn btn-outline-danger btn-sm delete ri-delete-bin-line" title="Xóa" data-dialog="dialog-{{ $value->id }}" data-id="{{ $value->id }}"></button>
                                                        <button type="button" class="btn btn-outline-secondary btn-sm sua ri-edit-box-fill" title="Sửa" data-dialog="dialog-{{ $value->id }}" data-id="{{ $value->id }}" ></button>                                                
                                                    @endif
                                                {{-- NÚT CẬP NHẬT, GHI CHÚ --}}
                                                    @if ($value->user_id == $user['id'])
                                                        @if ($value->completion != 100)
                                                        <button data-id="{{ $value->id }}" class="btn btn-outline-warning btn-sm edit" title="Cập nhật"><i class="ri-file-text-line"></i></button>
                                                        @endif
                                                        <button data-id1="{{ $value->id }}" class="btn btn btn-outline-info btn-sm note" title="update"><i class="mdi mdi-microsoft-onenote"></i></button>
                                                    @endif
                                            @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td style="text-align: center;" colspan="9"> Không có dữ liệu</td>
                                    </tr>
                                @endif 
                            </tr>
                        </tbody>
                       
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
  
@include('include.footer')
<script>
//---- THÊM CÔNG VIỆC BẰNG SWALERT2 ----//
         document.getElementById('addProject').addEventListener('click', function() {
                var projectprochild1 = {{$projectprochild1->id}}
                var userAll = {!! json_encode($userAll) !!};
                    let selectHtml = '<select id="swal-input2" class="swal2-input">';
                    let lastDepartment = '';

                            userAll.forEach(function(user, index) {
                                if(user.department){
                                    if(lastDepartment != '' && lastDepartment != user.department.name){
                                        selectHtml += '</optgroup>';
                                    }
                                    if(lastDepartment != user.department.name){
                                        selectHtml += `<optgroup label="${user.department.name}">`;
                                    }
                                    selectHtml += `<option value="${user.id}">${user.name}</option>`;
                                    if(index == userAll.length - 1){
                                        selectHtml += '</optgroup>';
                                    }
                                    lastDepartment = user.department.name;
                                }
                            });
                            selectHtml += '</select>';

                            Swal.fire({
                title: 'Thêm công việc',
                html:
                    '<input id="swal-input1" class="swal2-input" placeholder="Tên công việc">' +
                    selectHtml +
                    '<input id="swal-input3" type="date" class="swal2-input" placeholder="Ngày bắt đầu">' +
                    '<input id="swal-input4" type="date" class="swal2-input" placeholder="Ngày kết thúc">',
                focusConfirm: false,
                confirmButtonText: 'Thêm công việc',
                preConfirm: () => {
                    let name = document.getElementById('swal-input1').value;
                    let responsible = document.getElementById('swal-input2').value;
                    let startDate = document.getElementById('swal-input3').value;
                    let endDate = document.getElementById('swal-input4').value;

                    if(new Date(endDate) < new Date(startDate)) {
                        Swal.showValidationMessage('Ngày kết thúc không được bé hơn ngày bắt đầu');
                    }

                    return [name, responsible, startDate, endDate];
                },
                onOpen: function() {
                    $('#swal-input2').select2();
                }
            }).then(function(result) {
                if(result.isConfirmed) {
                    // Gửi dữ liệu bằng AJAX khi nút "Thêm" được nhấn
                    $.ajax({
                        url: "{!!route('insertWorkChild2')!!}", // URL của route
                        type: 'POST',
                        data: {
                            name: result.value[0],
                            user_id: result.value[1],
                            startDate: result.value[2],
                            endDate: result.value[3],
                            projectprochild1:projectprochild1,
                            _token: '{!! csrf_token() !!}',  // CSRF token
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: 'thêm công việc thành công',
                            }).then(() => {
                                location.reload();
                            }); 
                        }
                    });
                }
            });
        });
//---- CẬP NHẬT KẾT QUẢ ----// 
    $(document).ready(function() {
            $('.edit').on('click', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Cập nhật kết quả',
                    input: 'number',
                    inputPlaceholder: 'Nhập số (bé hơn 100)',
                    inputAttributes: {
                        min: 0,
                        max: 100,
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Cập nhật',
                    cancelButtonText: 'Hủy',
                    preConfirm: (value) => {
                        if (!value || value > 100) {
                            Swal.showValidationMessage('Vui lòng nhập số bé hơn 100');
                        }
                    }
                }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{!! route('updatePP2') !!}",
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id: id,
                        value: result.value
                    },
                    success: function(response) {
                        Swal.fire('Thành công!', 'Cập nhật thành công.', 'success');
                        $('tr[data-id="' + id + '"] .completion').text(result.value + '%');
                        if (result.value == 100) {
                            $('tr[data-id="' + id + '"] .status').text('Hoàn Thành').css('color','green');
                            $('tr[data-id="' + id + '"] .edit').hide();
                            $('tr[data-id="' + id + '"] .delete').hide();
                            $('tr[data-id="' + id + '"] .sua').hide();
                        }
                    },
                    error: function(response) {
                        Swal.fire('Lỗi!', 'Cập nhật thất bại.', 'error');
                    }
                });
            }
        });
        });
    });
//-------- GHI CHÚ CHILD 1 ---------//
    $(document).on('click', '.note', function() {
            var id = $(this).data('id1');
            Swal.fire({
                title: 'Cập nhật ghi chú',
                input: 'textarea',
                inputLabel: 'Nhập ghi chú mới',
                inputValue: '',
                showCancelButton: true,
                inputValidator: (value) => {
                    if (!value) {
                        return 'Bạn cần nhập ghi chú!'
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{!!route('notePP2')!!}",
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            id: id,
                            note: result.value
                        },
                        success: function(response) {
                            Swal.fire('Thành công!', 'Ghi chú đã được cập nhật.', 'success');
                            // Cập nhật ghi chú trong bảng (nếu cần)
                            $('tr[data-id="' + id + '"] .note-cell').text(result.value);
                        },
                        error: function(response) {
                            Swal.fire('Lỗi!', 'Có lỗi xảy ra.', 'error');
                        }
                    });
                }
            });
        });
//----- SỬA DỰ ÁN CHILD 1 ----//
    $(document).ready(function() {
            $('.sua').click(function() {
                var userAll = {!! json_encode($userAll) !!};
                        let selectHtml = '<select id="swal-input2" class="swal2-input">';
                        let lastDepartment = '';

                                userAll.forEach(function(user, index) {
                                    if(user.department){
                                        if(lastDepartment != '' && lastDepartment != user.department.name){
                                            selectHtml += '</optgroup>';
                                        }
                                        if(lastDepartment != user.department.name){
                                            selectHtml += `<optgroup label="${user.department.name}">`;
                                        }
                                        selectHtml += `<option value="${user.id}">${user.name}</option>`;
                                        if(index == userAll.length - 1){
                                            selectHtml += '</optgroup>';
                                        }
                                        lastDepartment = user.department.name;
                                    }
                                });
                                selectHtml += '</select>';
                var id = $(this).data('id');
                $.ajax({
                    url: "{!!route('getPP2')!!}", 
                    type: 'post',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id: id,
                    },
                    success: function(response) {
                        var startDate = response.startdate;

                        var endDate = response.enddate;
                        Swal.fire({
                        title: 'Sửa công việc',
                        html:
                            '<input id="swal-input1" class="swal2-input" placeholder="Tên công việc" value="' + response.name + '">' +
                            selectHtml +
                            '<input id="swal-input3" type="date" class="swal2-input" placeholder="Ngày bắt đầu" value="' + startDate + '">' +
                            '<input id="swal-input4" type="date" class="swal2-input" placeholder="Ngày kết thúc" value="' + endDate + '">',

                        focusConfirm: false,
                        confirmButtonText: 'Cập nhật công việc',
                        preConfirm: () => {
                            return {
                                name: document.getElementById('swal-input1').value,
                                responsible : document.getElementById('swal-input2').value,
                                startDate: document.getElementById('swal-input3').value,
                                endDate: document.getElementById('swal-input4').value,
                            };
                        },
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{!!route('editPP2')!!}",
                                type: 'POST',
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content'),
                                    id: id,
                                    ...result.value,
                                },
                                success: function(response) {
                                    Swal.fire('Thành công!', 'Cập nhật công việc thành công.', 'success').then(() => {
                                    location.reload();
                                }); 
                                },
                                error: function(response) {
                                    Swal.fire('Lỗi!', 'Có lỗi xảy ra.', 'error');
                                },
                            });
                        }
                    });
                },
            });
        });
    });
//----- XÓA DỰ ÁN CHILD 1 -----//
    $(document).ready(function() {
            $('.delete').click(function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Bạn có chắc muốn xóa công việc này?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có, xóa nó!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{!!route('deletePP2')!!}",
                            type: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                id: id,
                            },
                            success: function(response) {
                                $('tr[data-id="' + id + '"]').fadeOut('slow');
                            },
                            error: function(response) {
                                Swal.fire('Lỗi!', 'Có lỗi xảy ra.', 'error');
                            }
                        });
                    }
                });
            });
        });
</script>