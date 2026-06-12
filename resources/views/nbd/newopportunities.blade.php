@extends('adminlte::page')

@section('subtitle', 'NBD New Opportunities')

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
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-hand-holding-usd"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Value</span>
                <span class="info-box-number">
                          @if(!empty($totalvalue ))
                          $
                          @endif

                        {{ $totalvalue !== null ? number_format($totalvalue,0) : '' }}</span>
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
          <div> 
          <table class="table-card-mobile table table-sm table-striped projects">
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
                          Edit
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
                          @if(!empty($opportunity->projected_value ))
                          ${{ number_format($opportunity->projected_value, 0) }}
                          @endif
                      </td>
                      <td>
                          {{ $opportunity->close_date ? \Carbon\Carbon::parse($opportunity->close_date)->format("m/d/y") : ''  }}
                      </td>
                      <td>
                          {{ $opportunity->confidence }}
                          @isset($opportunity->confidence)
                          %
                          @endisset
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
                      <td class="project-actions">
                          <a type="button" href="{{ route('edit.opportunity', ['id' => $opportunity->id]) }}" class="btn btn-tool" title="Edit this opportunity">
              <i class="fas fa-edit"></i>

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
    <script src="{{ asset('js/flash-remove.js') }}"></script>
    @endpush