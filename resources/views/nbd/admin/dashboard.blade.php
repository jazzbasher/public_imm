@extends('adminlte::page')

@section('subtitle', 'Admin Dash')

@section('content_top_nav_right')
            {{ Breadcrumbs::render('adminhome') }}
@endsection

@section('css')

@stop 


@section('content')

    <section class="content" style="margin-top: 5px;">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $leadscount }}</h3>
                <p>New Customer Leads</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="{{ route('admin.nbd.leads') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $oppcount }}</h3>
                <p>New Opportunities</p>
              </div>
              <div class="icon">
                <i class="fas fa-lightbulb"></i>
              </div>
              <a href="{{ route('admin.nbd.opps') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $pipelinecount }}</h3>

                <p>Vending Pipeline</p>
              </div>
              <div class="icon">
                <i class="fas fa-wave-square"></i>
              </div>
              <a href="{{ route('admin.nbd.pipelines') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>
                  @isset($sumtotal )
                          $
                  @endisset

                        {{ $sumtotal !== null ? number_format($sumtotal,0) : '' }}

              </h3>
                <p>Potential Revenue</p>
              </div>
              <div class="icon">
                <i class="fas fa-search-dollar"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
        <div class="row">
          <section class="col-lg-12 connectedSortable">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-child mr-1"></i>
                  Sales Crew
                </h3>               
              </div><!-- /.card-header -->
              {{-- <div class="card-body">
                <div class="tab-content p-0">
                  @foreach($userleads as $userlead)
                  <li>{{ $userlead->name }}</li>
                  <li>{{ $userlead->newcustomerleads_count }}</li>
                  <li>{{ $userlead->newopps_count }}</li>
                  @endforeach
                </div>
              </div> --}}
              <div class="card-body">
                    <table class="table" role="table">
                      <thead>
                        <tr>
                          <th scope="col">Name</th>
                          <th scope="col">New Leads</th>
                          <th scope="col">New Opps</th>
                          <th scope="col">Joint Calls</th>
                          <th scope="col">Conversions</th>
                          <th scope="col">Vending Pipelines</th>
                        </tr>
                      </thead>
                      <tbody>

                        @foreach($userleads as $userlead)
                        <tr class="align-middle">
                          <td><a href="{{ route('sales.user', ['id' => $userlead->id]) }}" class="text-reset">{{ $userlead->name }}</a></td>
                          <td>{{ $userlead->newcustomerleads_count }}</td>
                          <td>{{ $userlead->newopps_count }}</td>
                          <td>{{ $userlead->jointcalls_count }}</td>
                          <td>{{ $userlead->conversions_count }}</td>
                          <td>{{ $userlead->pipelines_count }}</td>
                          
                        </tr>
                        
                        @endforeach
                        
                      </tbody>
                    </table>
                  </div>
            </div>
          </section>
        </div>
        <div class="row">
          <section class="col-lg-12 connectedSortable">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="ion ion-clipboard mr-1"></i>
                  Test Placeholder
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <ul class="todo-list" data-widget="todo-list">
                 
                </ul>
              </div>
              <div class="card-footer clearfix">
              </div>
            </div>
          </section>
         {{--  <section class="col-lg-5 connectedSortable">
            <div class="card bg-gradient-primary">
              <div class="card-header border-0">
                <h3 class="card-title">
                   <i class="far fa-calendar-alt"></i>
                  Calendar Test
                </h3>
                <div class="card-body">
                    <div id="calendar" style="width: 100%; display: inline-block;"></div>
                </div>
              </div>
              <div class="card-footer bg-transparent">
                <div class="row">
                  <div class="col-4 text-center">
                    <div id="sparkline-1"></div>
                    <div class="text-white">     </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <div id="sparkline-2"></div>
                    <div class="text-white">    </div>
                  </div>
                  <div class="col-4 text-center">
                    <div id="sparkline-3"></div>
                    <div class="text-white">    </div>
                  </div>
                </div>
              </div>
            </div>
          </section> --}}
        </div>
      </div><!-- /.container-fluid -->
    </section>
  </div>
@stop

@push('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

@push('js')
{{--    <script>
        var chartLabels = @json($labels);
        var chartDataValues = @json($chartdata);
        new Chart(document.getElementById("myChart"), {
    type: 'bar',
    data: {
      labels: chartLabels,
      datasets: [
        {
          label: "Cost YTD",
          backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
          data: chartDataValues
        }
      ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: 'Top 5 Equipment Cost YTD'
      }
    }
});
    </script> --}}
    
@endpush