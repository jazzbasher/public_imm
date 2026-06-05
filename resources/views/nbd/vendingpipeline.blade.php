@extends('adminlte::page')

@section('subtitle', 'NBD Current Promo')

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="card">
         <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-phone-alt"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Promos</span>
                <span class="info-box-number">{{ $pipelines->count() }}
                </span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-calendar-alt"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Conversions</span>
                <span class="info-box-number">0</span>
              </div>
            </div>
          </div>
          <div class="clearfix hidden-md-up"></div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="far fa-clock"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Something</span>
                <span class="info-box-number">       
                <span class="badge badge-warning"></span>                      
                </span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <a href="{{ route('nbd.create.createpipeline') }}">
              <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-plus-square"></i></span>
              <div class="info-box-content">                
                <span class="info-box-text">Create Vending Pipeline</span>
                <span class="info-box-number"> </span>
              </div>
            </div>
          </div></a>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive"> 
          <table class="table table-sm table-striped projects">
              <thead class="small">
                  <tr>
                      <th>
                          Customer
                      </th>
                      <th>
                          City
                      </th>
                      <th>
                          Estimated Spend
                      </th>
                      <th>
                          Presentation
                      </th>
                      <th>
                          Site Survey
                      </th>
                      <th>
                          Notes
                      </th>
                                     
                      <th>
                          Created
                      </th>
                      <th>
                      </th>
                  </tr>
              </thead>
              <tbody>
              @foreach($pipelines as $pipeline)
                  <tr>
                      <td>
                          {{ $pipeline->customer }}
                      </td>
                      <td>
                          {{ $pipeline->address }} 
                      </td>
                      <td>
                          {{ $pipeline->estimated_spend }}
                      </td>
                     
                           <td>
                        <input type="checkbox" data-on="Yes" data-off="No" data-toggle="toggle" data-onstyle="success" data-offstyle="dark" data-style="border" data-size="xs" name="presentation" value="1" @checked($pipeline->presentation == 1) disabled>
                      
                      </td>
                       <td>
                        <input type="checkbox" data-on="Yes" data-off="No" data-toggle="toggle" data-onstyle="success" data-offstyle="dark" data-style="border" data-size="xs" name="site_survey" value="1" @checked($pipeline->site_survey == 1) disabled>
                      </td>
                      <td>
                          {{ $pipeline->comments }}
                      </td>
                     
                      <td>
                          {{ $pipeline->created_at ? \Carbon\Carbon::parse($pipeline->created_at)->format("m/d/y") : ''  }}
                      </td>                                      
                      <td class="project-actions text-center">
                          <a class="btn btn-primary btn-sm" href="#"> 
                              <i class="fas fa-edit">
                              </i>
                              Edit
                          </a>
                      </td>
                  </tr>                
                  @endforeach              
              </tbody>
          </table>
        </div>
        </div>
      </div>
    </section>
    @stop

    @push('css')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    @endpush

    @push('js')
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    @endpush