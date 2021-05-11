@extends('front.layout.main')

@section('content')

<div class="col-lg-5">
    <div class="card">
        <canvas id="myChartBar" ></canvas>
    </div>
</div>

<div class="col-lg-5">
    <div class="card">
        <canvas id="myChartPie" ></canvas>
    </div>
</div>

<div class="col-lg-5">
    <div class="card">
        <canvas id="myChartLine" ></canvas>
    </div>
</div>

<div class="col-lg-5">
    <div class="card">
        <canvas id="myChartDou" ></canvas>
    </div>
</div>

<script>
    var servico = <?php echo $servico; ?>;
    var labelBar = <?php echo $labelBar; ?>; 
    var labelsBar = <?php echo $labelsBar; ?>; 
    var servicoLine = <?php echo $servicoLine; ?>;
    var labelsLine = <?php echo $labelsLine; ?>;
    var labelLine = <?php echo $labelLine; ?>;  

    var ctxBar = document.getElementById('myChartBar').getContext('2d');
    var myChartBar = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: labelsBar,
            datasets: [{
                label: labelBar,
                data: servico,
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true,
                        stepSize: 1
                    }
                }]
            }
        }
    });

    //pie
    var ctxPie = document.getElementById('myChartPie').getContext('2d');
    var myChartPie = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: labelsBar,
            datasets: [{
                label: labelBar,
                data: servico,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            title: {
            display: true,
            text: labelBar
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

//line
var ctxLine = document.getElementById('myChartLine').getContext('2d');
    var myChartLine = new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: labelsLine,
            datasets: [{
                label: labelLine,
                data: servicoLine, 
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
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

//doughnut

var ctxDou = document.getElementById('myChartDou').getContext('2d');
    var myChartDou = new Chart(ctxDou, {
        type: 'doughnut',
        data: {
            labels: labelsLine,
            datasets: [{
                label: labelLine,
                data: servicoLine, 
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            title: {
                display: true,
                text: labelLine
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

</script>

@endsection