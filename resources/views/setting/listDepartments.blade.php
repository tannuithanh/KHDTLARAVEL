@include('include.header')
<div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">DANH SÁCH PHÒNG BAN</h4>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                    <table class="table table-editable table-nowrap align-middle table-edits ">
                        <thead>
                            <tr>
                                <th style="text-align:center ;" class="table-header">STT</th>
                                <th style="text-align:center ;" class="table-header">Tên phòng ban</th>
                                <th style="text-align:center ;" class="table-header">Mô tả phòng ban</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $stt=1;
                            @endphp
                            @foreach ( $departments as $value )
                           <tr>
                                <th style="text-align:center ;width:0">{{ $stt++ }}</th>
                                <th >{{ $value->name }}</th>
                                <th style="text-align:center ;">{{ $value->description }}</th>
                           </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@include('include.footer')