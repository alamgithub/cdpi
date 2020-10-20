@extends('client2.client_full_app')

@section('content')
    
  <!-- Services Form Section -->
	<section class="services-form-section from-sec">
		<div class="pattern-layer" style="background-image:url(images/background/pattern-13.png)"></div>
		<div class="pattern-layer-two" style="background-image:url(images/background/pattern-12.png)"></div>
		
		<div class="container ">
			
			<!-- Services Form -->
			<div class="services-form">

				<h3>Requesr for Demo</h3>
					{{--@if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif--}}

                    @include('flash::message')
				<!--Contact Form-->
				 {!! Form::open(['url'=>'demo-save/','method'=>'post','id' => 'contactsForm']) !!}
					<div class="row">
					
						<!--Form Group-->
						<div class="form-group col-lg-4 col-md-6 col-sm-12">
							<label><span class="icon flaticon-new-user"></span> Enter your Name</label>
							{!! Form::text('name',null,['class'=>'form-control','placeholder' => 'Type your name','required']) !!}
					        @if($errors->has('name'))
					            <span class="text-danger">
					                <strong>{{ $errors->first('name') }}</strong>
					            </span>
					        @endif
							
						</div>
						
						<!--Form Group-->
						<div class="form-group col-lg-4 col-md-6 col-sm-12">
							<label><span class="icon icon-envelope"></span> Your Mail Address</label>
							{!! Form::email('email',null,['class'=>'form-control','placeholder' => 'Email','required']) !!}
					        @if($errors->has('email'))
					            <span class="text-danger">
					                <strong>{{ $errors->first('email') }}</strong>
					            </span>
					        @endif
						
						</div>

						<!--Form Group-->
						<div class="form-group col-lg-4 col-md-6 col-sm-12">
							<label><span class="icon icon-envelope"></span> Your Contact No.</label>
							{!! Form::tel('contact',null,['class'=>'form-control','placeholder' => 'Contact No.','required']) !!}
					        @if($errors->has('contact'))
					            <span class="text-danger">
					                <strong>{{ $errors->first('contact') }}</strong>
					            </span>
					        @endif
							
						</div>
						
					</div>

					<div class="row">
					
						<!--Form Group-->
						<div class="form-group col-lg-4 col-md-6 col-sm-12">
							<label><span class="icon icon-map"></span> Address</label>
							{!! Form::text('address',null,['class'=>'form-control','placeholder' => 'Address','required']) !!}
					        @if($errors->has('address'))
					            <span class="text-danger">
					                <strong>{{ $errors->first('address') }}</strong>
					            </span>
					        @endif
							
						</div>
						
					
					
						<!--Form Group-->
						<div class="form-group col-lg-4 col-md-6 col-sm-12">
							<label><span class="icon icon-location"></span> State</label>
							
							<select class="custom-select-box" name="state" >
								<option value="">Select State</option>
								@if(isset($states))
								@foreach($states as $k => $state)
								<option value="{!! $state->name ?? '' !!}">{!! $state->name ?? '' !!}</option>
								@endforeach
								@endif
								
							</select></a>
							 @if($errors->has('state'))
					            <span class="text-danger">
					                <strong>{{ $errors->first('state') }}</strong>
					            </span>
					        @endif
						</div>
						
						<!--Form Group-->
						<div class="form-group col-lg-4 col-md-6 col-sm-12">
							<label><span class="icon icon-code"></span> Zip Code</label>
							{!! Form::text('pincode',null,['class'=>'form-control','placeholder' => 'pincode','required']) !!}
					        @if($errors->has('pincode'))
					            <span class="text-danger">
					                <strong>{{ $errors->first('pincode') }}</strong>
					            </span>
					        @endif
						
						</div>
						
					</div>

				<br>
				<div class="button-box">
					<button type="submit" class="theme-btn btn-style-three">Submit <span class="arrow icon-arrow_right"></span></button>
					<button type="reset"  class="theme-btn btn-style-transparent">Cancel <span class="arrow icon icon-arrow_right"></span></button>
				</div>
			 {!! Form::close() !!}
			</div>
			
		</div>
	</section>
	<!-- End Services Form Section -->
	
@endsection


<script type="text/javascript">
	
	 $("#contactsForm").on('submit',(function(e) {
        var url = $('#contactsForm').attr('action');
         $('#contactsForm').attr('action', "/sendOTPRequest").submit();
            e.preventDefault();
            $.ajax({
                url: url,
                type: "POST",
                data:  new FormData(this),
                beforeSend: function(){$("#body-overlay").show();},
                contentType: false,
                processData:false,
                success: function(data)
                {
                    console.log(data);
                $("#targetLayer").html(data);
                $("#targetLayer").css('opacity','1');
                setInterval(function() {$("#body-overlay").hide(); },500);
                },
                error: function() 
                {
                }           
           });
        }));
</script>