@extends('adminlte::page')

@section('subtitle', 'Create Promo')


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
                    <h3>Create New Promo</h3>
                    <form action="{{ route('nbd.storepromo') }}" method="post">
                      @csrf
                      

                      <div class="form-group">
                        <label for="title">Date</label>
                        <input type="date" class="form-control" id="promo_date" name="promo_date" autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="title">Customer</label>
                        <input type="text" class="form-control" id="customer" name="customer" autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="title">Contact Name</label>
                        <input type="text" class="form-control" id="contact_name" name="contact_name" autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="title">Sample</label>
                        <input type="text" class="form-control" id="sample" name="sample" autocomplete="off">
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