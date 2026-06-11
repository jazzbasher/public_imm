@extends('adminlte::page')

@section('subtitle', 'NBD Conversion')

@section('adminlte_js')
    @parent
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Remove the global dark-mode class from body
            document.body.classList.remove('dark-mode');
            
            // Revert AdminLTE layout to light mode
            document.body.classList.add('layout-fixed'); 
        });
    </script>
@stop

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

<section class="content">
    <div class="card border border-dark p-2 m-1" style="background-color: #FFFFFA; border-style: solid;">
        <div class="row">
          <div class="col-12 text-center">
            <h5><b>{{ $salesperson }} :: New Customer Leads</b></h5>
          </div>
        </div>
        <x-adminlte-datatable id="customerleads" class="with-buttons" :heads="$leadheads" :config="$leadconfig" striped compact with-buttons hoverable bordered compressed/>
    </div>
    <div class="card border border-dark p-2 m-1" style="background-color: #FAFDFF;">
        <div class="row">
          <div class="col-12 text-center">
            <h5><b>{{ $salesperson }} :: New Opportunities</b></h5>
          </div>
        </div>
        <x-adminlte-datatable id="newopps" class="with-buttons" :heads="$oppsheads" :config="$oppsconfig" striped compact with-buttons hoverable bordered compressed/>
    </div>
    <div class="card border border-dark p-2 m-1" style="background-color: #F7FCF8;">
        <div class="row">
          <div class="col-12 text-center">
            <h5><b>{{ $salesperson }} :: Joint Calls</b></h5>
          </div>
        </div>
        <x-adminlte-datatable id="jointcalls" class="with-buttons" :heads="$callsheads" :config="$callsconfig" striped compact with-buttons hoverable bordered compressed/>
    </div>
    <div class="card border border-dark p-2 m-1" style="background-color: #FCF9F7;">
        <div class="row">
          <div class="col-12 text-center">
            <h5><b>{{ $salesperson }} :: Conversions</b></h5>
          </div>
        </div>
        <x-adminlte-datatable id="conversions" class="with-buttons" :heads="$conversionsheads" :config="$conversionsconfig" striped compact with-buttons hoverable bordered compressed/>
    </div>
    <div class="card border border-dark p-2 m-1" style="background-color: #F7F7F7;">
        <div class="row">
          <div class="col-12 text-center">
            <h5><b>{{ $salesperson }} :: Vending Pipelines</b></h5>
          </div>
        </div>
        <x-adminlte-datatable id="pipelines" class="with-buttons" :heads="$pipelinesheads" :config="$pipelinesconfig" striped compact with-buttons hoverable bordered compressed/>
    </div>
</section>



@stop

@push('css')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/mobile-tables.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
    <style>
        .rowwcolor {
  background-color: #fff5d9;
}
</style>

@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script src="{{ asset('js/flash-remove.js') }}"></script>


@endpush