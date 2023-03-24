@include('include.header')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
                <div class="row">
                    <div class="col-md-3 border-right">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span class="font-weight-bold">{{ $user->name }}</span><span class="text-black-50">{{ $user->email }}</span><span> </span></div>
                    </div>
                    <div class="col-md-5 border-right">
                        <div class="p-3 py-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-right">Thông tin cá nhân</h4>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12"><label class="labels">Họ và tên</label><input type="text" class="form-control" placeholder="Họ và tên" readonly value="{{ $user->name }}"></div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6"><label class="labels">Mã số nhân viên</label><input type="text" class="form-control" placeholder="Mã số nhân viên" readonly value="{{ $user->msnv }}"></div>
                                <div class="col-md-6"><label class="labels">Địa chỉ email</label><input type="email" class="form-control" placeholder="Địa chỉ" readonly value="{{ $user->email }}"></div>
                                <div class="col-md-12"><label class="labels">Phòng ban</label><input type="text" class="form-control" placeholder="Phòng ban" readonly value="{{ $user->department_id }}" ></div>
                                <div class="col-md-6"><label class="labels">Nhóm</label><input type="text" class="form-control" placeholder="Nhóm" readonly value="{{ $user->team_id }}" ></div>
                                <div class="col-md-6"><label class="labels">Chức vụ</label><input type="text" class="form-control" readonly value="{{ $user->position_id }}" placeholder="Chức vụ" ></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('include.footer')