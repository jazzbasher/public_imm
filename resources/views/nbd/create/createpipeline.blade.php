@extends('adminlte::page')

@section('subtitle', 'Create Vending Pipeline')


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
                    <h3>Create Vending Pipeline</h3>
                    <form action="{{ route('nbd.storepipeline') }}" method="post">
                      @csrf
                      

                      <div class="form-group">
                        <label for="title">Customer</label>
                        <input type="text" class="form-control" id="customer" name="customer" autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="title">Address</label>
                        <input type="text" class="form-control" id="address" name="address" autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="title">Estimated Spend</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">$</span>
                            </div>
                            <input type="number" class="form-control" id="estimated_spend" name="estimated_spend"  min="0" placeholder="25,000" autocomplete="off">
                        </div>
                      </div>
                      <br/>

                      <div class="form-group custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" name="presentation" id="presentation">
                        <label class="custom-control-label" for="presentation">Presentation</label>
                      </div>
                      <br/>

                      <div class="form-group">
                        <label for="title">Comments</label>
                        <textarea class="form-control" id="comments" name="comments" rows="3" placeholder="Type comments here..." autocomplete="off">{{ old('comments') }}</textarea>
                          {{-- <input type="text" class="form-control" id="comments" name="comments" autocomplete="off"> --}}
                      </div>

                      <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                      <br>
                      <a href="{{ url()->previous() }}" class="btn btn-secondary mr-5">Cancel</a>
                      <button type="submit" class="btn btn-primary">Create Pipeline</button>
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