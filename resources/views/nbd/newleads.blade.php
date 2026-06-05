@extends('adminlte::page')

@section('subtitle', 'NBD New Leads')

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="card">
         <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-cyan elevation-1"><i class="fas fa-users"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Leads</span>
                <span class="info-box-number">{{ $newlead->count() }}
                </span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-phone-volume"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Contacted</span>
                <span class="info-box-number">{{ $countleads }}</span>
              </div>
            </div>
          </div>
          <div class="clearfix hidden-md-up"></div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-bell"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Dates Coming Due</span>
                <span class="info-box-number">       
                <span class="badge badge-warning">{{ $countalerts }}</span>                      
                </span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <a href="{{ route('nbd.create.createlead') }}">
              <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-plus-square"></i></span>
              <div class="info-box-content">                <span class="info-box-text">Create New Lead</span>
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
                          New Lead
                      </th>
                      <th>
                          Address
                      </th>
                      <th>
                          Planned
                      </th>
                      <th>
                          Contacted?
                      </th>
                      <th>
                          Name
                      </th>
                      <th>
                          Email
                      </th>
                      <th>
                          Comments
                      </th>
                      <th>
                          Created
                      </th>
                      <th>
                      </th>
                  </tr>
              </thead>
              <tbody>
              @foreach($newlead as $lead)
                  <tr>
                      <td>
                          {{ $lead->new_lead }}
                      </td>
                      <td>
                          {{ $lead->address }} 
                      </td>
                      <td>
                          {{ $lead->date_planned ? \Carbon\Carbon::parse($lead->date_planned)->format("m/d/y") : ''  }}
                      </td>
                      <td class="text-center">
                        <input type="checkbox" data-on="Yes" data-off="No" data-toggle="toggle" data-onstyle="success" data-offstyle="dark" data-style="border" data-size="xs" name="contact_made" value="1" @checked($lead->contact_made == 1) disabled>
                      </td>
                      <td>
                          {{ $lead->contactname}}
                      </td>
                      <td>
                          {{ $lead->email }}
                      </td>
                      <td>
                          {{ $lead->comments }}
                      </td>
                      <td>
                          {{ $lead->created_at ? \Carbon\Carbon::parse($lead->created_at)->format("m/d/y") : ''  }}
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