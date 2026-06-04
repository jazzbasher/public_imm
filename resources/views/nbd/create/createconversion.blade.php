@extends('adminlte::page')

@section('subtitle', 'Create Conversion')


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@section('content')
    <section class="content" style="margin-top: 5px;">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12">
            <div class="container h-100 mt-5">
                <div class="row h-100 justify-content-center align-items-center">
                  
                  <div class="col-10 col-md-8 col-lg-6">
                    <h3>Create New Conversion</h3>
                    <form action="{{ route('nbd.storeconversion') }}" method="post">
                      @csrf
                      

                      <div class="form-group">
                        <label for="title">New Supplier</label>
                        <input type="text" class="form-control" id="new_supplier" name="new_supplier" autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="title">Supplier Converted From</label>
                        <input type="text" class="form-control" id="supplier_converted_from" name="supplier_converted_from" autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="title">Annual Opportunity Volume</label>
                        <input type="number" class="form-control" id="annual_opp_volume" name="annual_opp_volume" autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="title">Supplier Contact Name</label>
                        <input type="text" class="form-control" id="supplier_contact_name" name="supplier_contact_name" autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="title">End User</label>
                        <input type="text" class="form-control" id="end_user" name="end_user" autocomplete="off">
                      </div>
                
                      <div class="form-group">
                        <label for="title">Product Converted To</label>
                        <input type="text" class="form-control" id="product_converted_to" name="product_converted_to" autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="title">Comments</label>
                        <textarea class="form-control" id="comments" name="comments" rows="3" placeholder="Type comments here..." autocomplete="off">{{ old('comments') }}</textarea>
                          {{-- <input type="text" class="form-control" id="comments" name="comments" autocomplete="off"> --}}
                      </div>

                      <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                      <br>
                      <a href="{{ url()->previous() }}" class="btn btn-secondary mr-5">Cancel</a>
                      <button type="submit" class="btn btn-primary">Enter</button>
                    </form>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
  </div>
@stop