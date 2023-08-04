@include('include.header')
<div class="col-12" id="group-container">
        <div class="card" >
            <div class="card-body">
                <h4 class="card-title">Công Việc 1</h4>
                <div class="row">
                    <div class="col">
                        <label for="start-time">Thời gian bắt đầu:</label>
                        <input type="time" id="start-time" class="form-control start-time">
                    </div>
                    <div class="col">
                        <label for="end-time">Thời gian kết thúc:</label>
                        <input type="time" id="end-time" class="form-control end-time">
                    </div>
                    <div class="col">
                        <label for="task">Nội dung công việc:</label>
                        <input type="text" id="task" class="form-control task" required>
                    </div>
                    <div class="col">
                        <label for="project">Dự Án/ Hạng mục:</label>
                        <input type="text" id="project" class="form-control project" required>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <label>Thứ trong tuần:</label>
                        <div class="form-check">
                            <input class="form-check-input weekday-1" type="checkbox" value="" id="weekday-1">
                            <label class="form-check-label weekday-1" for="weekday-1">
                                Thứ Hai
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input weekday-2" type="checkbox" value="" id="weekday-2">
                            <label class="form-check-label" for="weekday-2">
                                Thứ Ba
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input weekday-3" type="checkbox" value="" id="weekday-3">
                            <label class="form-check-label" for="weekday-3">
                                Thứ Tư
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input weekday-4" type="checkbox" value="" id="weekday-4">
                            <label class="form-check-label" for="weekday-4">
                                Thứ Năm
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input weekday-5" type="checkbox" value="" id="weekday-5">
                            <label class="form-check-label" for="weekday-5">
                                Thứ Sáu
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input weekday-6" type="checkbox" value="" id="weekday-6">
                            <label class="form-check-label" for="weekday-6">
                                Thứ Bảy
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input weekday-7" type="checkbox" value="" id="weekday-7">
                            <label class="form-check-label" for="weekday-7">
                                Chủ Nhật
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Tăng ca:</label>
                        <div class="form-group">
                            <label for="overtime-1">Thứ Hai:</label>
                            <select class="form-control overtime-1" id="overtime-1">
                                <option value="">Không tăng ca </option>
                                <option value="18:30">18:30</option>
                                <option value="20:45">20:45</option>
                                <option value="22:45">22:45</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="overtime-2">Thứ Ba:</label>
                            <select class="form-control overtime-2" id="overtime-2">
                                <option value="">Không tăng ca </option>
                                <option value="18:30">18:30</option>
                                <option value="20:45">20:45</option>
                                <option value="22:45">22:45</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="overtime-3">Thứ Tư:</label>
                            <select class="form-control overtime-3" id="overtime-3">
                                <option value="">Không tăng ca </option>
                                <option value="18:30">18:30</option>
                                <option value="20:45">20:45</option>
                                <option value="22:45">22:45</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="overtime-4">Thứ Năm:</label>
                            <select class="form-control overtime-4" id="overtime-4">
                                <option value="">Không tăng ca </option>
                                <option value="18:30">18:30</option>
                                <option value="20:45">20:45</option>
                                <option value="22:45">22:45</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="overtime-5">Thứ Sáu:</label>
                            <select class="form-control overtime-5" id="overtime-5">
                                <option value="">Không tăng ca </option>
                                <option value="18:30">18:30</option>
                                <option value="20:45">20:45</option>
                                <option value="22:45">22:45</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="overtime-6 overtime-6">Thứ Bảy:</label>
                            <select class="form-control" id="overtime-6">
                                <option value="">Không tăng ca </option>
                                <option value="18:30">18:30</option>
                                <option value="20:45">20:45</option>
                                <option value="22:45">22:45</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="overtime-7 overtime-7">Chủ Nhật:</label>
                            <select class="form-control" id="overtime-7">
                                <option value="">Không tăng ca </option>
                                <option value="18:30">18:30</option>
                                <option value="20:45">20:45</option>
                                <option value="22:45">22:45</option>
                            </select>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <div class="card" >
    <div class="card-body">
        <div class="row">
            <div class="col">
                <button type="button" id="create" class="btn btn-success">Tạo</button>
                <button type="button" id="insert" class="btn btn-primary">Thêm</button>
                <button type="button" id="delete" class="btn btn-danger">Xóa</button>
            </div>
        </div>
    </div>
    </div>
    

@include('include.footer')
<script>
    window.onload = function() {
        var addButton = document.getElementById('insert');
        var deleteButton = document.getElementById('delete');
        var container = document.getElementById('group-container');  // Thay đổi này để phù hợp với ID của container chứa các group
        var currentTaskNumber = 1;  // Biến global theo dõi số lượng công việc hiện tại

        addButton.addEventListener('click', function() {
            // Tăng số lượng công việc hiện tại
            currentTaskNumber++;

            // Tạo group HTML
            var groupHTML = `<div class="card" >
            <div class="card-body">
                <h4 class="card-title">Công Việc ${currentTaskNumber}</h4>
                <div class="row">
                    <div class="col">
                        <label for="start-time">Thời gian bắt đầu:</label>
                        <input type="time" id="start-time-${currentTaskNumber}" class="form-control start-time">
                    </div>
                    <div class="col">
                        <label for="end-time">Thời gian kết thúc:</label>
                        <input type="time" id="end-time-${currentTaskNumber}" class="form-control end-time">
                    </div>
                    <div class="col">
                        <label for="task">Nội dung công việc:</label>
                        <input type="text" id="task-${currentTaskNumber}" class="form-control task">
                    </div>
                    <div class="col">
                        <label for="project">Dự Án/ Hạng mục:</label>
                        <input type="text" id="project-${currentTaskNumber}" class="form-control project">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <label>Thứ trong tuần:</label>
                        <div class="form-check">
                            <input class="form-check-input weekday-1" type="checkbox" value="" id="weekday-1-${currentTaskNumber}">
                            <label class="form-check-label weekday-1" for="weekday-1">
                                Thứ Hai
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input weekday-2" type="checkbox" value="" id="weekday-2-${currentTaskNumber}">
                            <label class="form-check-label" for="weekday-2">
                                Thứ Ba
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input weekday-3" type="checkbox" value="" id="weekday-3-${currentTaskNumber}">
                            <label class="form-check-label" for="weekday-3">
                                Thứ Tư
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input weekday-4" type="checkbox" value="" id="weekday-4-${currentTaskNumber}">
                            <label class="form-check-label" for="weekday-4">
                                Thứ Năm
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input weekday-5" type="checkbox" value="" id="weekday-5-${currentTaskNumber}">
                            <label class="form-check-label" for="weekday-5">
                                Thứ Sáu
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input weekday-6" type="checkbox" value="" id="weekday-6-${currentTaskNumber}">
                            <label class="form-check-label" for="weekday-6">
                                Thứ Bảy
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input weekday-7" type="checkbox" value="" id="weekday-7-${currentTaskNumber}">
                            <label class="form-check-label" for="weekday-7">
                                Chủ Nhật
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Tăng ca:</label>
                        <div class="form-group">
                            <label for="overtime-1">Thứ Hai:</label>
                            <select class="form-control overtime-1" id="overtime-1-${currentTaskNumber}">
                                <option value="">Không tăng ca </option>
                                <option value="18:30">18:30</option>
                                <option value="20:45">20:45</option>
                                <option value="22:45">22:45</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="overtime-2">Thứ Ba:</label>
                            <select class="form-control overtime-2" id="overtime-2-${currentTaskNumber}">
                                <option value="">Không tăng ca </option>
                                <option value="18:30">18:30</option>
                                <option value="20:45">20:45</option>
                                <option value="22:45">22:45</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="overtime-3">Thứ Tư:</label>
                            <select class="form-control overtime-3" id="overtime-3-${currentTaskNumber}">
                                <option value="">Không tăng ca </option>
                                <option value="18:30">18:30</option>
                                <option value="20:45">20:45</option>
                                <option value="22:45">22:45</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="overtime-4">Thứ Năm:</label>
                            <select class="form-control overtime-4" id="overtime-4-${currentTaskNumber}">
                                <option value="">Không tăng ca </option>
                                <option value="18:30">18:30</option>
                                <option value="20:45">20:45</option>
                                <option value="22:45">22:45</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="overtime-5">Thứ Sáu:</label>
                            <select class="form-control overtime-5" id="overtime-5-${currentTaskNumber}">
                                <option value="">Không tăng ca </option>
                                <option value="18:30">18:30</option>
                                <option value="20:45">20:45</option>
                                <option value="22:45">22:45</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="overtime-6 overtime-6">Thứ Bảy:</label>
                            <select class="form-control" id="overtime-6-${currentTaskNumber}">
                                <option value="">Không tăng ca </option>
                                <option value="18:30">18:30</option>
                                <option value="20:45">20:45</option>
                                <option value="22:45">22:45</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="overtime-7 overtime-7">Chủ Nhật:</label>
                            <select class="form-control" id="overtime-7-${currentTaskNumber}">
                                <option value="">Không tăng ca </option>
                                <option value="18:30">18:30</option>
                                <option value="20:45">20:45</option>
                                <option value="22:45">22:45</option>
                            </select>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>`;

            // Thêm group vào cuối trang
            container.innerHTML += groupHTML;
        });

        deleteButton.addEventListener('click', function() {
            // Xóa group cuối cùng
            var groups = container.getElementsByClassName('card');  // Thay đổi này để phù hợp với class của group của bạn
            var lastGroup = groups[groups.length - 1];

            if (lastGroup) {
                lastGroup.parentNode.removeChild(lastGroup);
                currentTaskNumber--;
            }
        });
    }

    $('#create').click(function() {
    var cards = $('.card');
    var data = [];
    var checkboxChecked = false;

    for (var i = 0; i < cards.length; i++) {
        var inputs = $(cards[i]).find('.form-control');
        var checkboxes = $(cards[i]).find('.form-check-input');
        var taskData = {};

        for (var j = 0; j < inputs.length; j++) {
            var input = inputs[j];
            taskData[input.id] = $(input).val();

            if (input.id.includes('start-time') || input.id.includes('end-time')) {
                var inputValue = $(input).val();

                if (!inputValue) {
                    Swal.fire('Lỗi!', 'Vui lòng điền đầy đủ thông tin!', 'error');
                    return;
                }
                
                var timeParts = inputValue.split(':');
                var inputHour = parseInt(timeParts[0]);
                var inputMinutes = parseInt(timeParts[1]);

                if (input.id.includes('start-time')) {
                    if (inputHour < 7 || (inputHour === 7 && inputMinutes < 30) ||
                        (inputHour === 11 && inputMinutes > 45)  ||
                        (inputHour === 16 && inputMinutes > 30)) {
                        Swal.fire('Lỗi!', 'Thời gian bắt đầu buổi sáng phải từ 7:30 đến 11:45, và buổi chiều từ 12:45 đến 16:30!', 'error');
                        return;
                    }
                    if (inputValue > $(inputs[j + 1]).val()) {
                        Swal.fire('Lỗi!', 'Thời gian bắt đầu phải trước thời gian kết thúc!', 'error');
                        return;
                    }
                }
                
                if (input.id.includes('end-time')) {
                    if ((inputHour < 7 || (inputHour === 7 && inputMinutes < 30)) ||
                        (inputHour === 11 && inputMinutes > 45) || inputHour > 16 || 
                        (inputHour === 16 && inputMinutes > 30)) {
                        Swal.fire('Lỗi!', 'Thời gian kết thúc buổi sáng phải từ 7:30 đến 11:45, và buổi chiều từ 12:45 đến 16:30!', 'error');
                        return;
                    }
                    if (inputValue < $(inputs[j - 1]).val()) {
                        Swal.fire('Lỗi!', 'Thời gian kết thúc phải sau thời gian bắt đầu!', 'error');
                        return;
                    }
                }
            }
        }

        checkboxes.each(function() {
            if ($(this).prop('checked')) {
                checkboxChecked = true;
                return false; // Thoát khỏi vòng lặp each
            }
        });

        data.push(taskData);
    }

    if (!checkboxChecked) {
        Swal.fire('Lỗi!', 'Vui lòng chọn ít nhất một ngày trong tuần!', 'error');
        return;
    }

    $.ajax({
        url: "{!!route('TaoLichLamViec1')!!}",
        type: 'POST',
        data: {
            tasks: data,
            _token: '{!! csrf_token() !!}'
        },
        success: function(response) {
            Swal.fire('Thành công!', 'Dữ liệu đã được gửi thành công!', 'success');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire('Lỗi!', 'Có lỗi xảy ra khi gửi dữ liệu!', 'error');
        }
    });
});





</script>