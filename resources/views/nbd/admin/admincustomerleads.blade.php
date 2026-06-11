@extends('adminlte::page')

@section('subtitle', 'New Leads Dashboard')


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
              <div class="chart-container" id="meeting-chart">
                    <canvas id="myChart"></canvas>
              </div>  
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <div class="chart-container" id="contactchart">
                    <canvas id="contact"></canvas>
              </div> 
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <div class="chart-container" id="createddates">
                    <canvas id="monthchart"></canvas>
              </div> 
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <div class="chart-container" id="myPolarChart">
                    <canvas id="myDonutChart"></canvas>
              </div>
            </div>
          </div>
        </div>

        <div class="card border border-dark p-2 m-1">
            <div class="row">
              <div class="col-12 text-center">
                <h5><b>New Customer Leads - All Sales Team</b></h5>
              </div>
            </div>
            <x-adminlte-datatable id="admincustomerlead" class="with-buttons" :heads="$heads" :config="$config" striped compact with-buttons hoverable bordered compressed/>
        </div>
    </section>
</div>
@stop

@push('css')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/mobile-tables.css') }}">
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
    var chartDataValues = @json($leadsdata);
 
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
        text: 'Leads By SalesPerson'
      }, 
    }
  });
  </script>

  <script>
    var chartLabels = @json($usercontactlabel);
    var chartDataValues = @json($contactdata);

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
        text: 'Contact Made By Salesperson'
      },
      
    }
  });
  </script>

   <script>
      var chartLabels = @json($monthlabels);
      var chartDataValues = @json($monthdata);
      new Chart(document.getElementById("monthchart"), {
          type: 'line',
          data: {
            labels: chartLabels,
            datasets: [{
              label: "",
              borderColor: 'rgb(75, 192, 192)',
              backgroundColor: "#FFFFFF",
              fill: false,
              tension: 0.2,
              data: chartDataValues
            }]
          },
          options: {
              legend: { display: false },
              title: {
                  display: true,
                  text: 'Leads By Month'
              },
              responsive: true,
      maintainAspectRatio: false,

          }
      });
    </script>

    <script>
    const ctx = document.getElementById('myDonutChart').getContext('2d');

    const myDonutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Red', 'Blue', 'Yellow'],
            datasets: [{
                label: 'Votes',
                data: [12, 19, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
          maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
  </script>
@endpush