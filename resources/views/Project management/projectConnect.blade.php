@include('include.header')

<div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">Quản lý dự án</h4>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 style="font-size: 20px" class="card-title">Dự án :  <span style="color: red; font-weight: 900">{{ $project->name_project }}</span></h4>
                <h4 style="font-size: 20px" class="card-title">Trưởng dự án :  <span style="color: red; font-weight: 900">{{ $project->name_create }}</span></h4>

                <p class="card-title-desc">Use contextual classes to color table rows or individual cells.</p>    
                
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
                </table>
            </div>
        </div>
    </div>
</div>
@include('include.footer')