@include('include.header')
<style>
            .modal-backdrop {
            /* add this to make the backdrop cover the whole page */
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
            background-color: #000;
            opacity: .5;
        }

        .modal {
            /* add this to create a layer above the rest of the page */
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 1050;
            display: none;
            overflow: hidden;
        }

</style>
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
    <h4 class="mb-sm-0">SỬA CÔNG VIỆC</h4>
</div>

<div class="col-xl-12">
    <div class="card" style="font-size: 18px">
        <div class="card-body">
            <form class="custom-validation" method="post">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Hạng mục công việc</label>
                    <input type="text" style="font-size: 18px" class="form-control" name="categoryMonth" value="{{$workmonth->categoryMonth}}"
                        required="" placeholder="Tên công việc">
                </div>
                <div class="mb-3">
                    <label class="form-label">Mô tả công việc</label>
                    <textarea id="myTextarea" style="font-size: 18px" type="text"  class="form-control" name="describeMonth" required="" placeholder="Mô tả công việc" rows="5">{{ $workmonth->describeMonth }}</textarea>
                
                </div>
                <div class="mb-3">
                    <label class="form-label">Hỗ trợ</label>
                    <select class="select2 form-control select2-multiple" name="support[]" multiple data-placeholder="Tên nhân sự hỗ trợ">
                        <option value=""></option> <!-- Option trống -->
                        @foreach ($allUser as $value)
                            <option value="{{ $value->name }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
                <label for="start-date" required multiple="multiple" >Ngày bắt đầu</label>
                <div class="mb-3 col-lg-2">
                    <input class="form-control" type="date" name="startMonth" value="{{$workmonth->startMonth}}" id="start-date">
                </div>
                <label for="end-date" required multiple="multiple" class="col-md-2 col-form-label">Ngày kết thúc</label>
                <div class="mb-3 col-lg-2">
                    <input class="form-control" type="date" value="{{$workmonth->endMonth}}" name="endMonth" id="end-date">
                </div>
                <div class="mb-3 ">
                    <label class="form-label">Ghi chú</label>
                    <div>
                        <textarea style="font-size: 18px" type="text" class="form-control" name="note"
                            placeholder="Ghi chú">{{ $workmonth->note }}</textarea>
                    </div>
                </div>
                <div>
                    <div>
                        <button type="submit" class="btn btn-primary waves-effect waves-light me-1">
                            Tạo
                        </button>
                        <a class="btn btn-secondary waves-effect waves-light" href="{{ route('viewApproveMonth') }}">Trở
                            về</a>
                    </div>
                </div>
            </form>
            <ul>

            </ul>
        </div>
    </div>
</div>
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card alert border mt-4 mt-lg-0 p-0 mb-0">
                <div class="card-header bg-soft-danger">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h5 class="font-size-16 text-danger my-1">Danger Alert</h5>
                        </div>
                        <div class="flex-shrink-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>                                                                                                          
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="mb-4">
                            <i class="mdi mdi-alert-outline display-4 text-danger"></i>
                        </div>
                        <h4 class="alert-heading">Cảnh báo</h4>
                        <p class="mb-0">Ngày kết thúc bé hơn ngày bắt đầu hoặc tổng 2 giá trị bé hơn 7 ngày</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('include.footer')
<script>
    var startDateInput = document.getElementById('start-date');
    var endDateInput = document.getElementById('end-date');

    function checkDate() {
        var startDate = new Date(startDateInput.value);
        var endDate = new Date(endDateInput.value);

        if (startDate > endDate) {
            alert('Ngày kết thúc không được bé hơn ngày bắt đầu!');
            resetInputs();
        } else {
            var diff = Math.abs(endDate - startDate);
            var diffDays = Math.ceil(diff / (1000 * 60 * 60 * 24));
            if (diffDays <= 7) {
                alert('Kế hoạch tháng nên không thể chọn 7 ngày nếu 7 ngày thì qua tạo kế hoạch tuần!');
                resetInputs();
            }
        }
    }

    function resetInputs() {
        startDateInput.value = "";
        endDateInput.value = "";
    }

    startDateInput.addEventListener('change', checkDate);
    endDateInput.addEventListener('change', checkDate);
$(document).ready(function() {
    // Check if there are any errors
    @if($errors->any())
        // If there are errors, show the modal
        $('#errorModal').modal('show');
    @endif
});

</script>