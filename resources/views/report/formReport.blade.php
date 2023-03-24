@include('include.header')
<style>
        /* ẩn input file mặc định */
        input[type="file"] {
            display: none;
        }

        /* tạo button thay thế cho input file */
        label.upload-button {
            display: inline-block;
            background-color: #2c3e50;
            color: #fff;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
        }

        /* tạo hiệu ứng hover cho button */
        label.upload-button:hover {
            background-color: #34495e;
        }

        /* style text hiển thị trên button */
        label.file-upload-container {
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0;
        }

        /* tạo style cho text hiển thị trên button */
        label.file-upload-container span {
            display: inline-block;
            margin-right: 10px;
            color: #2c3e50;
        }
</style>
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
    <h4 class="mb-sm-0">BÁO CÁO CÔNG VIỆC TUẦN</h4>
</div>
<div class="col-xl-6">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title" style="color: red; font-size: 20px;">Báo cáo công việc</h3>
            <form class="custom-validation" method="post" enctype="multipart/form-data" >
                @csrf
                <div class="mb-3">
                    <label class="form-label">Hạng mục công việc</label>
                    <input type="text" class="form-control" 
                        value="{{ $workWeek->categoryWeek }}" readonly placeholder="Tên công việc">
                </div>
                <div class="mb-3">
                    <label class="form-label">Mô tả công việc</label>
                    <textarea type="text" class="form-control" 
                        value="{{ $workWeek->describeWeek }}" readonly placeholder="Mô tả công việc"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Trách nhiệm</label>
                    <input type="text" class="form-control" 
                        value="{{ $workWeek->responsibility }}" readonly placeholder="Mô tả công việc">
                </div>
                <div class="mb-3">
                    <label class="form-label">Hỗ trợ</label>
                    <input type="text" class="form-control" 
                        value="{{ $workWeek->name }}" readonly >
                </div>
                <div class="mb-3">
                    <label class="form-label">Bất cập</label>
                    <textarea type="text" class="form-control" name="Inadequacy"  placeholder="Mô tả bất cập"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Đề xuất</label>
                    <textarea type="text" class="form-control" name="Propose"  placeholder="Đề xuất"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kết quả</label>
                    <input type="number" name="result" class="form-control" min="0" max="100">
                </div>
                <label class="file-upload-container">
                    <span>Chọn file:</span>
                    <label class="upload-button">
                        <input type="file" name="file_upload">
                        Tải lên
                    </label>
                </label>
            
                <div>
                    <div>
                        <button type="submit" class="btn btn-primary waves-effect waves-light me-1">
                           Báo cáo
                        </button>
                    </div>
                </div>
            </form>
            <ul>

            </ul>
        </div>
    </div>
</div>
@include('include.footer')