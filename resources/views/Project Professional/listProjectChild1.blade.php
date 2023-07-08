@include('include.header')
<div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0" style="font-size:20px">DỰ ÁN KHỐI NGHIỆP VỤ</h4>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" mb-3 mt-2" style="border: 1px solid;">
                    <h4 class="card-title" style="font-size:18px; font-family: 'Times New Roman', Times, serif !important;">Tên dự án: <span style="color: red"> {{$projectpro->name}}</span> </h4>
                    <h4 class="card-title" style="font-size:18px; font-family: 'Times New Roman', Times, serif !important;">Người tạo: <span style="color: red"> {{$projectpro->user->name}}</span>  </h4>
                    <h4 class="card-title" style="font-size:18px; font-family: 'Times New Roman', Times, serif !important;">Ngày bắt đầu: <span style="color: red"> {{ date('d/m/Y', strtotime($projectpro->startdate)) }}</span></h4>
                    <h4 class="card-title" style="font-size:18px; font-family: 'Times New Roman', Times, serif !important;">Ngày kết thúc: <span style="color: red"> {{ date('d/m/Y', strtotime($projectpro->enddate)) }}</span></h4>
                    <h4 class="card-title" style="font-size:18px; font-family: 'Times New Roman', Times, serif !important;">Lưu ý: dấu <span style="color: red">*</span> này là để đánh dấu bạn có công việc nhỏ trong mục này</h4>
                </div>
                <div class="table-responsive">
                  @if ($projectpro->user_id == $user['id'])
                    <button type="button" id="addProject" class="themcongviec btn btn-outline-success waves-effect waves-light">Thêm công việc</button>
                  @endif 
                  <button type="button" class="btn ri ri-line-chart-fill btn-outline-info waves-effect waves-light" data-bs-toggle="offcanvas" data-bs-target="#offcanvasChart" aria-controls="offcanvasChart"></button>
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
                                @if (!$projectprochild1->isEmpty())
                                    @foreach ($projectprochild1 as $value)
                                        <tr data-id="{{ $value->id }}">
                                            <th>{{$stt++}}</th>
                                            <td>
                                                <a style="color: blue" href="{{ route('listProChild2', ['id' => $value->id]) }}">{{ $value->name }}</a>
                                                @if ($value->projectProChild2s()->where('user_id', $user['id'])->exists())
                                                    <span style="color: red;">*</span>
                                                @endif
                                            </td>                                            <td>{{ $value->user->name}}</td>
                                            <td>{{ $value->department->name}}</td>
                                            <td>{{ date('d/m/Y', strtotime($value->startdate)) }}</td>
                                            <td>{{ date('d/m/Y', strtotime($value->enddate)) }}</td>
                                            <td class="note-cell">{!! nl2br($value->note) !!}</td>
                                            <td class="completion">{{$value->completion}}%</td>
                                            <td class="status">
                                                @if ($value->status == 0 && $value->enddate < $ngayHienTai && $value->completion < 100)
                                                    <span style="color: red;">Trễ kế hoạch</span>
                                                @elseif ($value->status == 0 && $value->startdate <= $ngayHienTai && $value->enddate >= $ngayHienTai && $value->completion < 100)
                                                    <span style="color:#ff8206;">Đang thực hiện</span>
                                                @elseif ($value->status == 0 && $value->startdate > $ngayHienTai && $value->completion < 100)
                                                    <span style="color: black;">Chưa đến hạng</span>
                                                @elseif ($value->completion == 100)
                                                    <span style="color: green;">Hoàn Thành</span>
                                                @endif

                                            </td>                                  
                                            <td>
                                                @if($projectpro->lock == 0)
                                                {{-- NÚT XÓA, SỬA --}}
                                                    @if ($projectpro->user_id == $user['id'] && $value->completion != 100)
                                                        <button type="button" class="btn btn-outline-danger btn-sm delete ri-delete-bin-line" title="Xóa" data-dialog="dialog-{{ $value->id }}" data-id="{{ $value->id }}"></button>
                                                        <button type="button" class="btn btn-outline-secondary btn-sm sua ri-edit-box-fill" title="Sửa" data-dialog="dialog-{{ $value->id }}" data-id="{{ $value->id }}" ></button>                                                
                                                    @endif
                                                {{-- NÚT CẬP NHẬT, GHI CHÚ --}}
                                                    @if ($value->user_id == $user['id'])
                                                        @if ($value->completion != 100 && $value->projectProChild2s->isEmpty())
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasChart" aria-labelledby="offcanvasChartLabel" style="width: 100%;">
    <div class="offcanvas-header">
      <h5 id="offcanvasChartLabel">Biểu đồ: <span style="color: red"> {{$projectpro->name}}</span></h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <!-- Đặt biểu đồ ở đây -->
      <div id="chart_div"></div>
    </div>
  </div>
@include('include.footer')
<script type="text/javascript" src="{{asset('assets/js/gstatic.com_charts_loader.js')}}"></script>
<script>
//------------- THÊM CÔNG VIỆC BẰNG SWEETALERT2 ----------//
            document.getElementById('addProject').addEventListener('click', function() {
                var projectpro_id = {{$projectpro->id}}
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
                        url: "{!!route('insertWorkChild')!!}", // URL của route
                        type: 'POST',
                        data: {
                            name: result.value[0],
                            user_id: result.value[1],
                            startDate: result.value[2],
                            endDate: result.value[3],
                            projectpro_id:projectpro_id,
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
//--------------- CẬP NHẬT KẾT QUẢ ---------------------//
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
                url: "{!! route('updatePP') !!}",
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
                    url: "{!!route('notePP')!!}",
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
                        url: "{!!route('deletePP')!!}",
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
                    url: "{!!route('getPP')!!}", 
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
                                url: "{!! route('editPP') !!}",
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
//----- BIỂU ĐỒ -----//


</script>
<script type="text/javascript">
    var projectpro = {!! $projectpro !!};
    var projectprochild1 = {!! $projectprochild1 !!};
    google.charts.load('current', {'packages':['gantt']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task ID');
        data.addColumn('string', 'Task Name');
        data.addColumn('string', 'Resource');
        data.addColumn('date', 'Start Date');
        data.addColumn('date', 'End Date');
        data.addColumn('number', 'Duration');
        data.addColumn('number', 'Percent Complete');
        data.addColumn('string', 'Dependencies');

        // Add projectpro data
        data.addRow([
            'Project', projectpro.name, 'Project',
            new Date(projectpro.startdate), new Date(projectpro.enddate),
            null, projectpro.completion, null
        ]);

        // Add each projectprochild1 data
        for (var i = 0; i < projectprochild1.length; i++) {
            data.addRow([
                projectprochild1[i].id.toString(), projectprochild1[i].name, 'Task',
                new Date(projectprochild1[i].startdate), new Date(projectprochild1[i].enddate),
                null, projectprochild1[i].completion, null
            ]);
        }

        var options = {
            height: 400,
            gantt: {
            trackHeight: 30
            }
        };

        var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

        chart.draw(data, options);
    }
</script>

