@include('include.header')
<div class="row">
    <div class="col-xl-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Sửa</h4>
        </div>
        <div class="card">
            <div class="card-body">
                <form class="needs-validation"  method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3 position-relative">
                                <label class="form-label" for="validationTooltip01">Tên nhóm</label>
                                <input type="text" class="form-control" id="validationTooltip01" name="name" value="{{ $team->name }}" placeholder="Tên nhóm" required="">
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Sửa</button>
                </form>
            </div>
        </div>
        <!-- end card -->
    </div> <!-- end col -->
</div>
@include('include.footer')