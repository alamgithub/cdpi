@extends('webfront.app')

@section('content')
  <!-- Services Form Section -->
	<div class="container">
     @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

        @if(session('success'))
            <div class="alert alert-success">
              {{session('success')}}
            </div>
            @endif

          @if(session('fail'))
          <div class="alert alert-danger">
            {{session('fail')}}
          </div>
          @endif

  <h2>Horizontal form</h2>
  <form class="form-horizontal" action="{!! url('/register') !!}" method="post">
  	 @csrf
    <div class="form-group">
      <label class="control-label col-sm-2" for="firtst">First Name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="firtst" placeholder="Enter First Name" name="name">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="lname">Last Name:</label>
      <div class="col-sm-10">          
        <input type="text" class="form-control" id="lname" placeholder="Enter Last Name" name="last_name">
      </div>
    </div>

     <div class="form-group">
      <label class="control-label col-sm-2" for="email">Email:</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="contact">Contact:</label>
      <div class="col-sm-10">          
        <input type="number" class="form-control" id="contact" placeholder="Enter Contact" name="contact">
      </div>
    </div>

     <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">Password:</label>
      <div class="col-sm-10">          
        <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password">
      </div>
    </div>
     <div class="form-group">
      <label class="control-label col-sm-2" for="cpwd">Confirm Password:</label>
      <div class="col-sm-10">          
        <input type="password" class="form-control" id="cpwd" placeholder="Enter Confirm password" name="c_password">
      </div>
    </div>


   
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
  </form>
</div>
	<!-- End Services Form Section -->
@endsection