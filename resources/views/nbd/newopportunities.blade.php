@extends('adminlte::page')

@section('subtitle', 'NBD New Opportunities')

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="card">
         <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-crosshairs"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Opportunities</span>
                <span class="info-box-number">{{ $newopportunity->count() }}
                </span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fab fa-quora"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Quotes Given</span>
                <span class="info-box-number">{{ $countquotes }}</span>
              </div>
            </div>
          </div>
          <div class="clearfix hidden-md-up"></div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><i class="far fa-clock"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Close Date Alerts</span>
                <span class="info-box-number">       
                <span class="badge badge-warning">{{ $countclose }}</span>                      
                </span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <a href="{{ route('nbd.create.createopportunity') }}">
              <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-plus-square"></i></span>
              <div class="info-box-content">                <span class="info-box-text">Create New Opportunity</span>
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
                          Interest
                      </th>
                      <th>
                          Quote?
                      </th>
                      <th>
                          Value
                      </th>
                      <th>
                          Projected
                      </th>
                      <th>
                          Confidence
                      </th>
                      <th>
                          Vendor Rep
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
              @foreach($newopportunity as $opportunity)
                  <tr>
                      <td>
                          {{ $opportunity->customer }}
                      </td>
                      <td>
                          {{ $opportunity->interest }} 
                      </td>
                      
                      <td class="text-center">
                        <input type="checkbox" data-on="Yes" data-off="No" data-toggle="toggle" data-onstyle="success" data-offstyle="dark" data-style="border" data-size="xs" name="contact_made" value="1" @checked($opportunity->quote == 1) disabled>
                      </td>
                      <td>
                          {{ $opportunity->projected_value }}
                      </td>
                      <td>
                          {{ $opportunity->close_date ? \Carbon\Carbon::parse($opportunity->close_date)->format("m/d/y") : ''  }}
                      </td>
                      <td>
                          {{ $opportunity->confidence }}
                      </td>
                      <td>
                          {{ $opportunity->rep }}
                      </td>
                      <td>
                          {{ $opportunity->comments }}
                      </td>
                      <td>
                          {{ $opportunity->created_at ? \Carbon\Carbon::parse($opportunity->created_at)->format("m/d/y") : ''  }}
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