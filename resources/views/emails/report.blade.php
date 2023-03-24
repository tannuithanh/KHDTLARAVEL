<style> 
    table, th, td {  
        font-family: 'Times New Roman', Times, serif;
        border: 1px solid black;  
        border-collapse: collapse;  
    }  
    th {  
        font-family: 'Times New Roman', Times, serif;
        background-color: rgb(115, 116, 123);
        padding: 5px;
        font-size: 14px;
        color: antiquewhite;  
    }  
    h5 {
        font-size: 16px;
        font-family: 'Times New Roman', Times, serif
    }
</style>

    <h5>Kính gửi Anh/Chị !</h5>
    <h5>Báo cáo công việc ngày: <span style="color:red; font-family: 'Times New Roman', Times, serif"> {{$today}}</span> </h5>  
    <h5>Nhân sự: <span style="color:red; font-family: 'Times New Roman', Times, serif"> {{ $user['name']}}</span> </h5>  
        <table class="table table-editable table-nowrap align-middle table-edits ">
            <thead>
                <tr>
                    <th style="text-align:center ;" class="table-header">STT</th>
                    <th style="text-align:center ;" class="table-header">Hạng mục công việc</th>
                    <th style="text-align:center ;" class="table-header">Mô tả công việc</th>
                    <th style="text-align:center ;" class="table-header">Trách nhiệm</th>
                    <th style="text-align:center ;" class="table-header">Hỗ trợ</th>
                    <th style="text-align:center ;" class="table-header">Ngày Tháng Năm</th>
                    <th style="text-align:center ;" class="table-header">Mục tiêu</th>
                    <th style="text-align:center ;" class="table-header">Kết quả</th>
                    <th style="text-align:center ;" class="table-header">Bất cập</th>
                    <th style="text-align:center ;" class="table-header">Đề xuất</th>

                </tr>
            </thead>
            <tbody>
                @foreach($tableData['tableData'] as $key => $row)
                @if ($row['stt']!=null)
                <tr>
                    <td style="text-align:center ;" >{{ $row['stt'] }}</td>
                    <td style="text-align:left ;">{{ $row['categoryDaily'] }}</td>
                    <td style="text-align:left ;">{!! nl2br($row['describeDaily']) !!}</td>
                    <td style="text-align:center ;">{{ $row['responsibility'] }}</td>
                    <td style="text-align:center ;">{!! nl2br($row['support']) !!}</td>
                    <td style="text-align:center ;">{{ $row['date'] }}</td>
                    <td style="text-align:center ;">{{ $row['ResultByWookWeek'] }}</td>
                    @if ($row['Result']=="Hoàn Thành")
                    <td style="text-align:center ;color: white; background-color: green;border: 1px solid black!important" >{{$row['Result']}}</td>
                    @elseif ($row['Result']=="Không hoàn Thành")
                    <td style="text-align:center ;color: white; background-color: rgb(244, 1, 1);border: 1px solid black!important" >{{$row['Result']}}</td>  
                    @endif
                    <td style="text-align:center ;">{!! nl2br($row['inadequacy']) !!}</td>
                    <td style="text-align:center ;">{!! nl2br($row['propose']) !!}</td>
                </tr>               
                @endif
                @endforeach         
            </tbody>
        </table>

    <h5>Đây là mail tự động, vui lòng không trả lời mail này.</h5>
    <h5>Trân trọng cảm ơn!</h5>

  <h5 style="font-size:20px;color:blue">NHÓM QTHT CNTT - R&D Ô TÔ</h5>
  <p style="font-size:18px;color: rgb(29, 103, 187) !important" >Nguyễn Thanh Quốc: 0327 144 123</p >
    <p style="font-size:18px;color: rgb(29, 103, 187) !important" >Trưởng phòng Quản Trị Dữ Liệu</p >
    <p style="font-size:18px;color: rgb(29, 103, 187) !important" >Email: Nguyenthanhquoc@thaco.com.vn</p >
  <p style="font-size:18px;color: rgb(29, 103, 187) !important" >Nguyễn Văn Tiến: 0327 144 123</p >
  <p style="font-size:18px;color: rgb(29, 103, 187) !important" >Chuyên viên CNTT</p >
  <p style="font-size:18px;color: rgb(29, 103, 187) !important" >Email: nguyenvantien@thaco.com.vn</p >
    <p style="font-size:18px;color: rgb(29, 103, 187) !important" ></p > 
    <p style="font-size:18px;color: rgb(29, 103, 187) !important" >Nguyễn Minh Tân: 0886 418 363</p >
        <p style="font-size:18px;color: rgb(29, 103, 187) !important" >Chuyên viên Quản lý Thông tin – Dữ liệu</p > 
            <p style="font-size:18px;color: rgb(29, 103, 187) !important" >Email: nguyenminhtan@thaco.com.vn</p >

                <p style="font-size:18px;color: rgb(29, 103, 187) !important" >Hoàng Ngọc Thành: 0337 376 917</p >
                    <p style="font-size:18px;color: rgb(29, 103, 187) !important" >Chuyên viên Quản lý Thông tin – Dữ liệu</p > 
                        <p style="font-size:18px;color: rgb(29, 103, 187) !important" > Email: hoangngocthanh@thaco.com.vn</p >


