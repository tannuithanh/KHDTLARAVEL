@include('include.header')
<header><script src="{{asset('assets/js/cdn.jsdelivr.net_npm_chart.js')}}"></script></header>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
<div style="width:75%;">
    <canvas id="workMonthChart"></canvas>
</div>
</div></div></div>

@include('include.footer')

<script>
let workmonths = @json($workmonths);

let labels = Object.keys(workmonths);
let data = {
    labels: labels,
    datasets: [
        {
            label: 'hoàn thành',
            data: labels.map(label => workmonths[label]['completed']),
            backgroundColor: 'rgba(75, 192, 192, 0.2)', // example color
        },
        {
            label: 'Đang Chờ duyệt',
            data: labels.map(label => workmonths[label]['pending']),
            backgroundColor: 'rgba(255, 206, 86, 0.2)', // example color
        },
        {
            label: 'Đang thực hiện',
            data: labels.map(label => workmonths[label]['in_progress']),
            backgroundColor: 'rgba(255, 99, 132, 0.2)', // example color
        },
        {
            label: 'Muộn',
            data: labels.map(label => workmonths[label]['late']),
            backgroundColor: 'rgba(153, 102, 255, 0.2)', // example color
        },
    ],
};

let config = {
    type: 'bar',
    data: data,
    options: {
        tooltips: {
            callbacks: {
                afterTitle: function(tooltipItems, data) {
                    let item = tooltipItems[0];
                    let label = data.labels[item.index];
                    return 'Start: ' + workmonths[label]['startMonth'] + ' - End: ' + workmonths[label]['endMonth'];
                },
            },
        },
    },
};

let myChart = new Chart(
    document.getElementById('workMonthChart'),
    config
);

    
    </script>