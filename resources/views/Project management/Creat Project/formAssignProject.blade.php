@include('include.header')

<div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0" style="font-size:20px">Quản lý dự án</h4>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form class="needs-validation" novalidate="" method="post">
                        @csrf
              
                        <div id="tasksContainer">
                            <div class="task">
                                <h4 class="card-title">Giao việc 1</h4>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3 position-relative">
                                            <label class="form-label" for="validationTooltip01">Tên công việc</label>
                                            <input type="text" class="form-control" id="validationTooltip01" placeholder="First name" name="name_work[]" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3 position-relative">
                                            <label class="form-label" for="validationTooltip02">Trách nhiệm</label>
                                            <div style="margin-left:10px" class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="responsibilityType[0]" id="individualRadio" value="individual" checked>
                                                <label class="form-check-label" for="individualRadio">Cá nhân</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="responsibilityType[0]" id="teamRadio" value="team">
                                                <label class="form-check-label" for="teamRadio">Nhóm</label>
                                            </div>
                                            <select class="form-control individualSelect" name="responsibility[]" id="individualSelect">
                                              <option value="">chọn...</option> <!-- Thêm option có giá trị rỗng này -->
                                              @foreach ($user_list as $value)
                                                <option value="{{$value->name}}">{{$value->name}}</option>
                                              @endforeach
                                            </select>
                                            <select class="form-control teamSelect" name="team_id[]" id="teamSelect" style="display: none;">
                                              <option value="">chọn...</option> <!-- Thêm option có giá trị rỗng này -->
                                              @foreach ($team_id as $value)
                                                <option value="{{$value->id}}">{{$value->name}}</option>
                                              @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3 position-relative">
                                            <label class="form-label" for="validationTooltipUsername">Ngày bắt đầu</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control" id="validationTooltipUsername" placeholder="Username" name="startdate[]" min="{{$project_department->startdate}}"  max="{{$project_department->enddate}}" aria-describedby="validationTooltipUsernamePrepend" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="mb-3 position-relative">
                                          <label class="form-label" for="validationTooltipUsername">Ngày kết thúc</label>
                                          <div class="input-group">
                                              <input type="date" class="form-control" id="validationTooltipUsername" placeholder="Username" name="enddate[]" min="{{$project_department->startdate}}"  max="{{$project_department->enddate}}" aria-describedby="validationTooltipUsernamePrepend" required="">
                                          </div>
                                      </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <input type="text" value="{{$id}}" hidden name="id">
                        <button type="button" class="btn btn-info waves-effect waves-light btn-add-task">Thêm việc</button>
                        <button class="btn btn-primary" type="submit">Giao việc</button>
                    </form>
                    
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->
    </div>
@include('include.footer')
<script>
   $(document).ready(function() {
    $('#tasksContainer').on('change', 'input[type=radio][name^=responsibilityType]', function() {
        var $task = $(this).closest('.task');
        if (this.value === 'individual') {
            $task.find('.individualSelect').show();
            $task.find('.teamSelect').hide();
            $task.find('.teamSelect').val(''); // Thêm dòng này
        } else if (this.value === 'team') {
            $task.find('.individualSelect').hide();
            $task.find('.teamSelect').show();
            $task.find('.individualSelect').val(''); // Thêm dòng này
        }
    });
});



    function createTaskHtml(taskNumber) {
  return `
  <hr style="height: 5px; background-color: #767575;">
    <div class="task">
      <h4 class="card-title">Giao việc ${taskNumber} </h4> 
      <div class="row">
        <div class="col-md-4">
          <div class="mb-3 position-relative">
            <label class="form-label" for="validationTooltip01">Tên công việc</label>
            <input type="text" class="form-control" id="validationTooltip01" placeholder="First name" name="name_work[]" required="">
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3 position-relative">
            <label class="form-label" for="validationTooltip02">Trách nhiệm</label>
            <div style="margin-left:10px" class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="responsibilityType[${taskNumber - 1}]" id="individualRadio" value="individual" checked>
              <label class="form-check-label" for="individualRadio">Cá nhân</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="responsibilityType[${taskNumber - 1}]" id="teamRadio" value="team">
              <label class="form-check-label" for="teamRadio">Nhóm</label>
            </div>
            <select class="form-control individualSelect" name="responsibility[]" id="individualSelect">
              <option value="">chọn...</option>
              @foreach ($user_list as $value)
              <option value="{{$value->name}}">{{$value->name}}</option>                                 
              @endforeach
            </select>
            <select class="form-control teamSelect" name="team_id[]" id="teamSelect" style="display: none;">
              <option value="">chọn...</option>
              @foreach ($team_id as $value)
              <option value="{{$value->id}}">{{$value->name}}</option>                                 
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3 position-relative">
            <label class="form-label" for="validationTooltipUsername">Ngày hoàn thành</label>
            <div class="input-group">
              <input type="date" class="form-control" id="validationTooltipUsername" placeholder="Username"  name="startdate[]" min="{{$project_department->startdate}}"  max="{{$project_department->enddate}}" name="completion_date[]" aria-describedby="validationTooltipUsernamePrepend" required="">
            </div>
          </div>
     
        </div>
        <div class="col-md-4">
                                      <div class="mb-3 position-relative">
                                          <label class="form-label" for="validationTooltipUsername">Ngày kết thúc</label>
                                          <div class="input-group">
                                              <input type="date" class="form-control" id="validationTooltipUsername" placeholder="Username" name="enddate[]" min="{{$project_department->startdate}}"  max="{{$project_department->enddate}}" aria-describedby="validationTooltipUsernamePrepend" required="">
                                          </div>
                                      </div>
                                  </div>
        
      </div>
  
    </div>
   
  `;
}

function addTask() {
  const tasksContainer = $('#tasksContainer');
  const taskNumber = tasksContainer.find('.task').length + 1;
  const taskHtml = createTaskHtml(taskNumber);
  tasksContainer.append(taskHtml);
}

$(document).ready(function() {
  $('.btn-add-task').on('click', function() {
    addTask();
  });
});

    </script>
    
