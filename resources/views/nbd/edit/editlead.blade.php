@extends('adminlte::page')

@section('subtitle', 'Edit Lead')


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
                    <h3>Edit Customer Lead</h3>
                    <form action="{{ route('edit.updatelead', ['id' => $id]) }}" method="post">
                      @csrf
                      @foreach($leads as $lead)

                      <div class="form-group">
                        <label for="title">New Lead</label>
                        <input type="text" class="form-control" id="new_lead" name="new_lead" value="{{ $lead->new_lead }}"  autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="title">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ $lead->address }}"  autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="title">Date Planned</label>
                        <input type="date" class="form-control" id="date_planned" name="date_planned" value="{{ $lead->date_planned }}"   autocomplete="off">
                      </div>

                      <br/>

                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="statusSwitch" name="contact_made" value="1"
                        {{ old('contact_made', $lead->contact_made) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="statusSwitch">Contact Made</label>
                      </div>


                      <br/>
                      <div class="form-group">
                        <label for="title">Contact Name</label>
                        <input type="text" class="form-control" id="contactname" name="contactname" value="{{ $lead->contactname }}"   autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="title">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $lead->email }}"   autocomplete="off">
                      </div>
                      <div class="form-group">
                        <label for="title">Notes</label>
                        <textarea class="form-control" id="comments" name="comments" rows="3" placeholder="Type comments here..." autocomplete="off">{{ $lead->comments }}</textarea>
                          {{-- <input type="text" class="form-control" id="comments" name="comments" autocomplete="off"> --}}
                      </div>
                      @endforeach
                      <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                      <br>
                      <a href="{{ url()->previous() }}" class="btn btn-secondary mr-5">Cancel</a>
                      <button type="submit" class="btn btn-primary">Update This Lead</button>
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