@extends('adminlte::page')

@section('subtitle', 'Vending Pipeline Dashboard')

@section('content_top_nav_right')
            {{ Breadcrumbs::render('adminallpipelines') }}
@endsection


@section('content')
@if (session()->has('success'))
    <div id="flash-message" class="alert alert-success">
        {{ session('success') }} 
    </div>
@endif
@if (session()->has('error'))
    <div id="flash-message" class="alert alert-danger">
        {{ session('error') }} 
    </div>
@endif

@section('plugins.Datatables', true)
<div class="container-fluid">
    <section class="content">
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <div class="chart-container">
                    <canvas id="myChart"></canvas>
              </div>  
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <div class="chart-container">
                    <canvas id="contact"></canvas>
              </div> 
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <div class="chart-container">
                    <canvas id="myPolarChart"></canvas>
              </div> 
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <div class="chart-container">
                    <canvas id="test"></canvas>
              </div>
            </div>
          </div>
        </div>

        <div class="card border border-dark p-2 m-1">
            <div class="row">
              <div class="col-12 text-center">
                <h5><b>Vending Pipelines - All Sales Team</b></h5>
              </div>
            </div>
            <x-adminlte-datatable id="admincustomerlead" class="with-buttons" :heads="$heads" :config="$pipelinesconfig" striped compact with-buttons hoverable bordered compressed/>
        </div>
    </section>
</div>
@stop

@push('css')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
    <style>
        .chart-container {
          position: relative;     /* Crucial for Chart.js positioning */
          width: 90%;            /* Forces container to fill horizontal space */
          min-width: 0;           /* Overrides default Flexbox/Grid intrinsic width limits */
          height: 18vh;           /* Provide a flexible or static height constraint */
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script src="{{ asset('js/flash-remove.js') }}"></script>

    <script>      
    var chartLabels = @json($userlabel);
    var chartDataValues = @json($pipelinedata);
 
    new Chart(document.getElementById("myChart"), {
    type: 'pie',
    data: {
      labels: chartLabels,
      datasets: [
        {
          label: chartLabels,
          data: chartDataValues,
          backgroundColor: [
          'rgb(81 103 153)',
          'rgb(118 137 68)',
          'rgb(158 132 85)',
          'rgb(84 5 41)',
          'rgb(100 102 101)',
          'rgb(169 216 207)',
          'rgb(60 94 69)',
          'rgb(214 4 88)', 
          'rgb(58 55 31)',
          'rgb(232 197 122)',
          'rgb(244 223 198)',
          'rgb(40 47 145)',
          'rgb(177 216 2)',
          'rgb(158 25 109)',
          'rgb(127 33 66)',
          'rgb(38 0 23)',
          ],
        },
      ]
    },
    options: {
      tooltips: {
      },
      indexAxis: 'y',
      responsive: true,
      maintainAspectRatio: false,
      legend: { display: false },
      title: {
        display: true,
        text: 'Vending Pipelines By SalesPerson'
      }, 
    }
  });
  </script>

  <script>
    var chartLabels = @json($userpreslabel);
    var chartDataValues = @json($presdata);

    new Chart(document.getElementById("contact"), {
    type: 'bar',
    data: {
      labels: chartLabels,
      datasets: [
        { 
          backgroundColor: [
            'rgb(144, 202, 249)',
            'rgb(128, 203, 196)',
            'rgb(165, 214, 167)', 
            'rgb(244, 143, 177)',
            'rgb(206, 147, 216)',
            'rgb(255, 224, 130',
            'rgb(60 94 69)',
            'rgb(214 4 88)', 
            'rgb(58 55 31)',
            'rgb(232 197 122)',
            'rgb(244 223 198)',
            'rgb(40 47 145)',
            'rgb(81 103 153)',
            'rgb(118 137 68)',
            'rgb(158 132 85)',  
            'rgb(177 216 2)',
            'rgb(158 25 109)',
            'rgb(127 33 66)',
            'rgb(38 0 23)',
          ],

        data: chartDataValues

        },
      ]
    },
    options: {
      tooltips: {
        displayColors: false,
      },
      scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true,
                min: 0
            }
        }]
      },

      responsive: true,
      maintainAspectRatio: false,
      legend: { display: false },
      title: {
        display: true,
        text: 'Presentations By Salesperson'
      },
      
    }
  });
  </script>

<script>

    const ctx = document.getElementById('myPolarChart').getContext('2d');
    var chartLabels = @json($spendlabel);
    var chartDataValues = @json($spenddata);
    const data = {
      labels: chartLabels,
      datasets: [{
        label: 'My Polar Dataset',
        data: chartDataValues,
        backgroundColor: [
          'rgba(255, 99, 132, 0.5)',
          'rgba(75, 192, 192, 0.5)',
          'rgba(255, 205, 86, 0.5)',
          'rgba(201, 203, 207, 0.5)',
          'rgba(54, 162, 235, 0.5)'
        ],
        borderColor: [
          'rgb(255, 99, 132)',
          'rgb(75, 192, 192)',
          'rgb(255, 205, 86)',
          'rgb(201, 203, 207)',
          'rgb(54, 162, 235)'
        ],
        borderWidth: 1
      }]
    };

    const config = {
      type: 'polarArea',
      data: data,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scale: {
            gridLines: {
                color: 'rgba(255, 255, 255, 0.1)' // Soft white gridlines
            },
            ticks: {
                backdropColor: 'transparent', // Removes grey box behind numbers
                fontColor: 'rgba(255, 255, 255, 0.7)', // Light text for numbers
                callback: function(value, index, values) {
                        return value.toLocaleString('en-US'); // Adds commas
                    }
            },
            pointLabels: {
                fontColor: 'rgba(255, 255, 255, 0.8)' // Light label text (Red, Blue, etc.)
            },
        },
      legend: { display: false },
      title: {
        display: true,
        text: 'Potential Value'
      },

        
      }
    };

    const myPolarChart = new Chart(ctx, config);

  </script>

<script>
  var chartLabels = @json($spendlabel);
    var chartDataValues = @json($spenddata);
 
    new Chart(document.getElementById("test"), {
    type: 'doughnut',
    data: {
      labels: chartLabels,
      datasets: [
        {
          label: chartLabels,
          data: chartDataValues,
          backgroundColor: [
          'rgba(255, 205, 86, 0.5)',
          'rgba(201, 203, 207, 0.5)',
          'rgba(54, 162, 235, 0.5)',
          'rgba(255, 99, 132, 0.5)',
          'rgba(75, 192, 192, 0.5)',
          'rgb(58 55 31)',
          'rgb(232 197 122)',
          'rgb(244 223 198)',
          'rgb(40 47 145)',
          'rgb(177 216 2)',
          'rgb(158 25 109)',
          'rgb(127 33 66)',
          'rgb(38 0 23)',
          ],
        },
      ]
    },
    options: {
      tooltips: {
      },
      indexAxis: 'y',
      responsive: true,
      maintainAspectRatio: false,
      legend: { display: false },
      title: {
        display: true,
        text: 'Pipelines By SalesPerson'
      }, 
    }
  });
  </script>

@endpush