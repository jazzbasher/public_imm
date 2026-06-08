@extends('adminlte::page')

@section('subtitle', 'Edit Joint Call')


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
                    <h3>Edit Joint Call</h3>
                    <form action="{{ route('edit.updatejointcall', ['id' => $id]) }}" method="post">
                      @csrf
                      @foreach($jointcalls as $jointcall)

                      <div class="form-group">
                        <label for="title">Customer Name</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ $jointcall->customer_name }}"  autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="title">Vendor</label>
                        <input type="text" class="form-control" id="vendor" name="vendor" value="{{ $jointcall->vendor }}"   autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="title">Vendor Rep</label>
                        <input type="text" class="form-control" id="vendor_rep" name="vendor_rep" value="{{ $jointcall->vendor_rep }}"   autocomplete="off" required>
                      </div>
                      

                      <div class="form-group">
                        <label for="title">Date Worked</label>
                        <input type="date" class="form-control" id="date_worked" name="date_worked" value="{{ $jointcall->date_worked }}"   autocomplete="off">
                      </div>

                      <div class="form-group">
                        <label for="title">Comments</label>
                        <textarea class="form-control" id="comments" name="comments" rows="3" placeholder="Type comments here..." autocomplete="off">{{ $jointcall->comments }}</textarea>
                          {{-- <input type="text" class="form-control" id="comments" name="comments" autocomplete="off"> --}}
                      </div>
                      @endforeach
                      <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                      <br>
                      <a href="{{ url()->previous() }}" class="btn btn-secondary mr-5">Cancel</a>
                      <button type="submit" class="btn btn-primary">Update This Joint Call</button>
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