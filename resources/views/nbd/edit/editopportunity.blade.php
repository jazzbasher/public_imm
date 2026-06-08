@extends('adminlte::page')

@section('subtitle', 'Edit Opportunity')


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
                    <h3>Edit Opportunity</h3>
                    <form action="{{ route('edit.updateopportunity', ['id' => $id]) }} }}" method="post">
                      @csrf
                      
                      @foreach($opportunities as $opportunity)
                      <div class="form-group">
                        <label for="title">Customer</label>
                        <input type="text" class="form-control" id="customer" name="customer" value="{{ $opportunity->customer }}" autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="title">Product Interest</label>
                        <input type="text" class="form-control" id="interest" name="interest" value="{{ $opportunity->interest }}"  autocomplete="off">
                      </div>
                      

                      <br/>

                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="statusSwitch" name="quote" value="1"
                        {{ old('quote', $opportunity->quote ) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="statusSwitch">Quote Given</label>
                      </div>

                      <br/>

                      <div class="form-group">
                        <label for="priceInput">Projected Value</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">$</span>
                            </div>
                            <input type="number" class="form-control" id="projected_value" name="projected_value" min="0" placeholder="25,000" value="{{ $opportunity->projected_value }}" >
                          </div>
                      </div>
                      <div class="form-group">
                        <label for="title">Projected Close Date</label>
                        <input type="date" class="form-control" id="close_date" name="close_date" value="{{ $opportunity->close_date }}"  autocomplete="off">
                      </div>

                      <div class="form-group">
                      <label for="confidence">Confidence of Close</label>
                        <select class="custom-select" id="confidence" name="confidence">
                          <option selected>{{ $opportunity->confidence }}</option>
                          <option value="100">100%</option>
                          <option value="75">75%</option>
                          <option value="50">50%</option>
                          <option value="25">25%</option>
                          <option value="0">0%</option>
                        </select>
                    </div>
                      <div class="form-group">
                        <label for="title">Vendor Rep</label>
                        <input type="text" class="form-control" id="rep" name="rep" value="{{ $opportunity->rep }}"  autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="title">Comments</label>
                        <textarea class="form-control" id="comments" name="comments" rows="3" placeholder="Type comments here..." autocomplete="off">{{ $opportunity->comments }}</textarea>
                          {{-- <input type="text" class="form-control" id="comments" name="comments" autocomplete="off"> --}}
                      </div>
                      @endforeach

                      <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                      <br>
                      <a href="{{ url()->previous() }}" class="btn btn-secondary mr-5">Cancel</a>
                      <button type="submit" class="btn btn-primary">Update This Opportunity</button>
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