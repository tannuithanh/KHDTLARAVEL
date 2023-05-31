@include('include.header')
<style>
    td,
    th {
        font-size: 20px;
    }

    .texta {
    color: #0043ff !important;  
    }
    .texta:hover {
        color: #0fde51 !important;  
    }
</style>

<div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0" style="font-size:20px">Quản lý dự án</h4>
        <h4 class="mb-sm-0" style="font-size:20px"><a href="{{ route('listCarBrands', $id) }}" type="button"
                class="btn btn-info"><i class="mdi mdi-keyboard-return"></i></a></h4>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title" style="font-size:20px">Thương hiệu xe: <span
                        style="color: red">{{ $CarBrands->name }}</span></h4>
                <a href="{{ route('creatProject.get', $id) }}"
                    class="btn btn-danger btn-rounded waves-effect waves-light"><i class="mdi mdi-plus me-1"></i>Tạo dự
                    án</a></h4>
                <div class="table-responsive class scrollable-table-wrapper mt-3">
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                            <strong>Thông báo!</strong> Đã thêm thành công dự án.
                        </div>
                    @elseif (Session::has('deleteSuccess'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                            <strong>Thông báo!</strong> Bạn đã xóa thành công.
                        </div>
                    @elseif (Session::has('failder'))
                        <div class="alert alert-danger alert-dismissible fade show " role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                            <strong>Thông báo!</strong> Đây không phải dự án của bạn, bạn không được truy cập vào dự án
                            này.
                        </div>
                    @endif

                    <table class="table table-centered table-nowrap mb-3">
                        <thead>
                            <tr>
                                <th style="text-align:center ;" class="table-header">STT</th>
                                <th style="text-align:center ;" class="table-header">Tên dự án</th>
                                <th style="text-align:center ;" class="table-header">Trưởng dự án</th>
                                <th style="text-align:center ;" class="table-header">Ngày bắt đầu</th>
                                <th style="text-align:center ;" class="table-header">Ngày Kết thúc</th>
                                <th style="text-align:center ;" class="table-header">Kết quả</th>
                                <th style="text-align:center ;" class="table-header">Trạng thái</th>
                                <th style="text-align:center ;" class="table-header">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $stt = 1;
                            @endphp
                            @if (!$project->isEmpty())
                                @foreach ($project as $value)
                                    @php
                                        $isProjectDelayed = false;
                                    @endphp
                                    @foreach ($value->projectDepartments as $projectDepartment)
                                        @if ($projectDepartment->enddate < $today && $projectDepartment->status == 0 && $projectDepartment->completion < 100)
                                            @php
                                                $isProjectDelayed = true;
                                            @endphp
                                        @endif

                                        @if (!$isProjectDelayed)
                                            @foreach ($projectDepartment->works as $work)
                                                @if ($work->enddate < $today && $work->status == 0 && $work->completion == 0)
                                                    @php
                                                        $isProjectDelayed = true;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                    <tr class="{{ $isProjectDelayed ? 'red-background' : '' }}">
                                        <td style="text-align:center ;">{{ $stt++ }}</td>
                                        <td style="text-align:center ;"><a class="texta"
                                                href="{{ route('projectConnect', $value->id) }}">{{ $value->name_project }}</a>
                                        </td>
                                        <td style="text-align:center ;">{{ $value->name_create }}</td>
                                        <td style="text-align:center ;">{{ $value->start_date }}</td>
                                        <td style="text-align:center ;">{{ $value->end_date }}</td>
                                        
                                        @if ($value->status == 0 && $value->start_date <= $today && $today <= $value->end_date && $value->completion <= 100)
                                            <td class="completion"
                                                style="text-align:center ;background-color: yellow; color: black">
                                                {{ $value->completion }}%</td>
                                            <td class="status"
                                                style="text-align:center ; background-color: yellow; color: black">
                                                Đang thực hiện
                                            </td>
                                        @elseif ($value->status == 1 && $value->completion == 100)
                                            <td class="completion"
                                                style="text-align:center ;background-color: green; color: black">
                                                {{ $value->completion }}%</td>
                                            <td class="status"
                                                style="text-align:center ; background-color: green; color: black">
                                                Hoàn thành
                                            </td>
                                        @elseif ($value->end_date < $today)
                                            <td class="completion"
                                                style="text-align:center; background-color: red; color: black">
                                                {{ $value->completion }}%</td>
                                            <td class="status"
                                                style="text-align:center ; background-color: red; color: black">
                                                Trễ Kế hoạch
                                            </td>
                                        @endif
                                        <td style="text-align:center ;">
                                            @if ($user['name']==$value->name_create || $user['department_id'] == 10)
                                                @if ($value->lock==0 )
                                                    <button type="button" class="btn btn-outline-danger btn-sm lock ri-rotate-lock-fill" title="lock" data-dialog="dialog-{{ $value->id }}" data-id="{{ $value->id }}"></button>
                                                @else
                                                    <button type="button" class="btn btn-outline-primary  btn-sm lock ri-lock-unlock-fill" title="UnLock" data-dialog="dialog-{{ $value->id }}" data-id="{{ $value->id }}"></button>
                                                @endif
                                            @endif
                                            @if ($value->completion == 100 && $value->status == 0 && $user['name']==$value->name_create)
                                                <a id="done-{{ $value->id }}" data-id="{{ $value->id }}"
                                                    class="btn btn-outline-success btn-sm done" title="hoàn thành"><i
                                                        class="ri-calendar-check-line"></i></a>
                                                        <button type="button"
                                                        class="btn btn-outline-danger btn-sm delete ri-delete-bin-line"
                                                        title="Xóa" data-dialog="dialog-{{ $value->id }}"
                                                        data-id="{{ $value->id }}"></button>
                                            @endif
                                            
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="text-align:center ;" colspan="8">Không có dự án</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    @include('include.footer')
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
//---------------------------------- XÓA DỰ ÁN ---------------------------------------//
                        document.addEventListener('DOMContentLoaded', function() {
                            const deleteButtons = document.querySelectorAll('.delete');

                            deleteButtons.forEach((button) => {
                                button.addEventListener('click', (event) => {
                                    event.preventDefault();
                                    const projectId = event.target.dataset.id;
                                    Swal.fire({
                                        title: 'Bạn có chắc chắn muốn xóa dự án này?',
                                        text: "Thao tác này sẽ không thể hoàn tác!",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Xóa',
                                        cancelButtonText: 'Hủy'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Thực hiện xóa dự án bằng AJAX
                                            deleteProject(projectId, event.target.closest('tr'));
                                        }
                                    });
                                });
                            });
                        });

                        function deleteProject(projectId, tableRow) {
                            // Thay thế 'url-to-delete-project' với URL thực của bạn để xóa dự án
                            const deleteUrl = `{{ route('deleteProject', ['id' => '_ID_']) }}`.replace('_ID_', projectId);

                            $.ajax({
                                url: deleteUrl,
                                type: 'DELETE',
                                data: {
                                    _token: '{!! csrf_token() !!}'
                                },
                                success: function(data) {
                                    if (data.success) {
                                        // Xóa hàng từ bảng
                                        tableRow.remove();

                                        Swal.fire(
                                            'Đã xóa!',
                                            'Dự án đã được xóa thành công.',
                                            'success'
                                        );
                                    } else {
                                        Swal.fire(
                                            'Lỗi!',
                                            'Có lỗi xảy ra khi xóa dự án.',
                                            'error'
                                        );
                                    }
                                },
                                error: function() {
                                    Swal.fire(
                                        'Lỗi!',
                                        'Có lỗi xảy ra khi xóa dự án.',
                                        'error'
                                    );
                                }
                            });
                        }

//---------------------------------- CẬP NHẬT DỰ ÁN ---------------------------------------//
                        $(document).on('click', '.done', function(e) {
                            e.preventDefault();

                            const projectId = $(this).data('id');

                            Swal.fire({
                                title: 'Bạn có chắc chắn đã hoàn thành dự án này?',
                                text: 'Dự án sẽ được đánh dấu là hoàn thành.',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Có',
                                cancelButtonText: 'Không'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: "{!! route('update.status') !!}",
                                        type: 'POST',
                                        data: {
                                            _token: '{!! csrf_token() !!}',
                                            id: projectId
                                        },
                                        success: function(data) {
                                            if (data.success) {
                                                Swal.fire(
                                                    'Hoàn thành!',
                                                    'Dự án đã được cập nhật thành công.',
                                                    'success'
                                                );
                                                $('#done-' + projectId).hide();
                                                // Cập nhật giao diện
                                                const completionCell = $(e.target).closest('tr').find(
                                                    '.completion');
                                                const statusCell = $(e.target).closest('tr').find('.status');

                                                completionCell.css('background-color', 'green');
                                                statusCell.css('background-color', 'green');

                                                completionCell.text('100%');
                                                statusCell.text('Hoàn thành');
                                            } else {
                                                Swal.fire(
                                                    'Lỗi!',
                                                    'Có lỗi xảy ra khi cập nhật dự án.',
                                                    'error'
                                                );
                                            }
                                        },
                                        error: function() {
                                            Swal.fire(
                                                'Lỗi!',
                                                'Có lỗi xảy ra khi cập nhật dự án.',
                                                'error'
                                            );
                                        }
                                    });
                                }
                            });
                        });
                        //------------------------------ KHÓA DỰ ÁN ------------------------------------------//
        document.addEventListener('DOMContentLoaded', () => {
        const lockButtons = document.querySelectorAll('.lock');
        lockButtons.forEach((button) => {
            button.addEventListener('click', async () => {
            const id = button.dataset.id;

            const { isConfirmed } = await Swal.fire({
                title: 'Bạn có muốn khóa kế hoạch này?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Có',
                cancelButtonText: 'Không',
            });

            if (isConfirmed) {
                // Gửi id đến controller để xử lý việc khóa kế hoạch
                const lockUrl = "{{ route('lock', ['id' => ':id']) }}".replace(':id', id);
                await fetch(lockUrl, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ id }),
                });

                Swal.fire('Kế hoạch đã được khóa!', '', 'success').then(function () {
                                    location.reload();
                                });
            }
            });
        });
        });
//----------------------- UNLOCK DỰ ÁN -----------------------------------------//
    document.addEventListener('DOMContentLoaded', () => {
    const unlockButtons = document.querySelectorAll('.ri-lock-unlock-fill');
    unlockButtons.forEach((button) => {
        button.addEventListener('click', async () => {
        const id = button.dataset.id;

        const { isConfirmed } = await Swal.fire({
            title: 'Bạn có muốn mở khóa kế hoạch này?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Có',
            cancelButtonText: 'Không',
        });

        if (isConfirmed) {
            // Gửi id đến controller để xử lý việc mở khóa kế hoạch
            const unlockUrl = "{{ route('unlock', ['id' => ':id']) }}".replace(':id', id);
            await fetch(unlockUrl, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ id }),
            });

            Swal.fire('Kế hoạch đã được mở khóa!', '', 'success').then(function () {
                                    location.reload();
                                });
        }
        });
    });
    });

</script>
