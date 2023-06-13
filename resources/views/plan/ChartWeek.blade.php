@include('include.header')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            {{-- <form action="{{ route('ChartWeek') }}" method="POST">
                @csrf
                <input type="date" name="week_start" value="{{ $weekStart }}">
                <input type="submit" value="Xem tuần">
            </form> --}}
            
            <h1>Biểu đồ công việc tuần từ {{ date('d-m-Y', strtotime($weekStart)) }} đến {{ date('d-m-Y', strtotime($weekEnd)) }}</h1>
            <canvas id="myChart"></canvas>
        </div>
    </div>
</div>
@include('include.footer')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Đang thực hiện', 'Đã hoàn thành'],
            datasets: [{
                label: 'Số lượng công việc',
                data: [{{ $workInProgressCount }}, {{ $completedWorkCount }}],  // thay thế ở đây
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

