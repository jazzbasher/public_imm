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
                <span class="info-box-number">{{ $promos->count() }}
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
            <a href="{{ route('nbd.create.createpromo') }}">
              <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-plus-square"></i></span>
              <div class="info-box-content">                
                <span class="info-box-text">Create New Promo</span>
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
                          Date
                      </th>
                      <th>
                          Customer
                      </th>
                      <th>
                          Contact Name
                      </th>
                      <th>
                          Sample
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
              @foreach($promos as $promo)
                  <tr>
                      <td>
                          {{ $promo->promo_date }}
                      </td>
                      <td>
                          {{ $promo->customer }} 
                      </td>
                      <td>
                          {{ $promo->contact_name }}
                      </td>
                      <td>
                          {{ $promo->sample }}
                      </td>
                      <td>
                          {{ $promo->comments }}
                      </td>
                     
                      <td>
                          {{ $promo->created_at ? \Carbon\Carbon::parse($promo->created_at)->format("m/d/y") : ''  }}
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
    <link rel="stylesheet" href="{{ asset('css/mobile-tables.css') }}">
    @endpush

    @push('js')
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    @endpush