@extends('adminlte::page')

@section('subtitle', 'Create Opportunity')


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
                    <h3>Create New Opportunity</h3>
                    <form action="{{ route('nbd.storeopportunity') }}" method="post">
                      @csrf
                      

                      <div class="form-group">
                        <label for="title">Customer</label>
                        <input type="text" class="form-control" id="customer" name="customer" autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="title">Product Interest</label>
                        <input type="text" class="form-control" id="interest" name="interest" autocomplete="off">
                      </div>
                      

                      <br/>

                      <div class="form-group custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" name="quote" id="quote">
                        <label class="custom-control-label" for="quote">Quote Given?</label>
                      </div>
                      <br/>

                      <div class="form-group">
  <label for="priceInput">Projected Value</label>
  <div class="input-group">
    <div class="input-group-prepend">
      <span class="input-group-text">$</span>
    </div>
    <input type="number" class="form-control" id="projected_value" name="projected_value" min="0" step="0.01" placeholder="25,000">
  </div>
</div>
                      <div class="form-group">
                        <label for="title">Projected Close Date</label>
                        <input type="date" class="form-control" id="close_date" name="close_date" autocomplete="off">
                      </div>

                      <div class="form-group">
                      <label for="confidence">Confidence of Close</label>
                        <select class="custom-select" id="confidence" name="confidence">
                          <option selected>Choose...</option>
                          <option value="100">100%</option>
                          <option value="75">75%</option>
                          <option value="50">50%</option>
                          <option value="25">25%</option>
                          <option value="0">0%</option>
                        </select>
                    </div>
                      <div class="form-group">
                        <label for="title">Rep Worked With</label>
                        <input type="text" class="form-control" id="rep" name="rep" autocomplete="off">
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