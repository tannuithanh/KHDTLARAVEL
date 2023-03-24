@include('include.header')
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">GIAO CÔNG VIỆC NGÀY</h4> 
    </div>
<div class="mb-3 d-none" id="form-create-plan-default" name="1">
    <div style="border-bottom: 3px solid gray!important;" class="mt-5">
        <h2 class="card-title font-weight-bold mt-2 mb-3" id="create-plan-title">Công Việc</h2>

        <div class="row">
            <div class="col-md-4">
                <input type="hidden" name="works[0][active]" value="0">
                <div class="mb-3">
                    <label class="form-label" for="validationCustom03">Hạng Mục Công Việc</label>
                    <input type="text" class="form-control" id="validationCustom03" placeholder="" required="">
                    <div class="invalid-feedback">
                        Vui lòng nhập dữ liệu.
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label" for="validationCustom04">Chi Tiết Công Việc</label>
                    <textarea rows="1" cols="" type="text" class="form-control" id="validationCustom04" placeholder="" required="" name="works[0][detail]"></textarea>
                    <div class="invalid-feedback">
                        Vui lòng nhập dữ liệu.
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label" for="validationCustom05">Giờ Thực Hiện</label>
                    <input type="number" class="form-control" id="validationCustom05" placeholder="" required="" name="works[0][time]">
                    <div class="invalid-feedback">
                        Vui lòng nhập dữ liệu.
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
        <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label" for="validationCustom03">Thời gian chi tiết</label>
                    <input type="datetime-local" class="form-control" id="validationCustom05" placeholder="" required="" name="works[0][timeDetail]">
                    <div class="invalid-feedback">
                        Vui lòng nhập dữ liệu.
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label" for="validationCustom03">Hỗ Trợ</label>
                    <input type="text" value="Không" class="form-control" id="validationCustom03" placeholder="" required="" name="works[0][support]">
                    <div class="invalid-feedback">
                        Vui lòng nhập dữ liệu.
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label" for="validationCustom04">Ghi chú</label>
                    <input type="text" class="form-control" id="validationCustom04" placeholder="" required="" name="works[0][note]">
                    <div class="invalid-feedback">
                        Vui lòng nhập dữ liệu.
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label" for="validationCustom04">Người được giao</label>
                    <select class="form-control form-select" id="validationCustom03" name="works[0][category_work_id]"> Chọn... 
                                            <option>Nguyễn Minh Tân</option>
                                            <option>Nguyễn Văn Tiến</option>
                                            <option>Hoàng Ngọc Thành</option>
                                        </select>
                    <div class="invalid-feedback">
                        Vui lòng nhập dữ liệu.
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- end form default -->


<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <form class="needs-validation" action="{{ route('listWorkDaily') }}" method="post" novalidate="">
                    <input type="hidden" name="works[0][active]" value="0">
                    <div class="mb-3" id="form-create-plan">
                        <div style="border-bottom: 3px solid gray!important;">
                            <h2 class="card-title font-weight-bold">Công Việc 1</h2>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="validationCustom03">Hạng Mục Công Việc</label>
                                        <input type="text" class="form-control" id="validationCustom03" placeholder="" required="">
                                
                                        <div class="invalid-feedback">
                                            Vui lòng nhập dữ liệu.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="validationCustom04">Chi Tiết Công Việc</label>
                                        <textarea rows="1" cols="" type="text" class="form-control" id="validationCustom04" placeholder="" required="" name="works[0][detail]"></textarea>
                                        <div class="invalid-feedback">
                                            Vui lòng nhập dữ liệu.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="validationCustom05">Giờ Thực Hiện</label>
                                        <input type="number" class="form-control" id="validationCustom05" placeholder="" required="" name="works[0][time]">
                                        <div class="invalid-feedback">
                                            Vui lòng nhập dữ liệu.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label" for="validationCustom03">Thời gian chi tiết</label>
                    <input type="datetime-local" class="form-control" id="validationCustom05" placeholder="" required="" name="works[0][timeDetail]">
                    <div class="invalid-feedback">
                        Vui lòng nhập dữ liệu.
                    </div>
                </div>
            </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="validationCustom03">Hỗ Trợ</label>
                                        <input value="Không" type="text" class="form-control" id="validationCustom03" placeholder="" required="" name="works[0][support]">
                                        <div class="invalid-feedback">
                                            Vui lòng nhập dữ liệu.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="validationCustom04">ghi chú</label>
                                        <input type="text" class="form-control" id="validationCustom04" placeholder="" required="" name="works[0][note]">
                                        <div class="invalid-feedback">
                                            Vui lòng nhập dữ liệu.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="validationCustom04">Người được giao</label>
                                        <select class="form-control form-select" id="validationCustom03" name="works[0][category_work_id]"> Chọn... 
                                            <option>Nguyễn Minh Tân</option>
                                            <option>Nguyễn Văn Tiến</option>
                                            <option>Hoàng Ngọc Thành</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Vui lòng nhập dữ liệu.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <button type="button" id="add-form-create" class="btn btn-info waves-effect waves-light">Thêm Công Việc</button>
                    <button class="btn btn-primary" type="submit">Xác nhận</button>

                </form>

            </div>
        </div>
        <!-- end card -->
    </div> <!-- end col -->
</div>

@include('include.footer')
