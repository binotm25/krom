@extends('layouts.homepage')

@section('content')

<div class="container signup-block">
   <div class="row text-center">
      <div class="col-md-4"></div>
      <div class="col-md-4">
         <img src="default/images/logos/kritish-logo-full.png" class="img-responsive center-block" width="250" alt="kitish-logo-full">   
         <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}" name="register">
			 {!! csrf_field() !!}
            <!-- First Screen of Form -->
            <div class="form-screen-1">
               <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                  <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name') }}" autocomplete="false">
                  @if ($errors->has('name'))
					<span class="help-block">
						<strong>{{ $errors->first('name') }}</strong>
					</span>
				  @endif
               </div>
               <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                  <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{ old('email') }}" autocomplete="false">
                  <span class="checkEmail hidden">
                  </span>
                  @if ($errors->has('email'))
						<span class="help-block">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
					@endif
               </div>
               <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                  <input type="password" class="form-control" id="pwd" placeholder="Password" name="password" autocomplete="false">
                  @if ($errors->has('password'))
						<span class="help-block">
							<strong>{{ $errors->first('password') }}</strong>
						</span>
					@endif
               </div>
               <div class="checkbox checkbox-2">
                  <label><input type="checkbox" value="1" name="terms" id="terms" {{ (old('terms') == "1") ? "checked" : "" }} > I accept <a href="{{ route('privacy_terms') }}" target="_blank">terms & conditions</a></label>
                  @if ($errors->has('terms'))
						<span class="help-block">
							<strong>Please accept terms & conditions</strong>
						</span>
					@endif
               </div>
               <a href="javascript:void(0)" class="btn btn-default btn-next" >NEXT</a>
               <!--<button class="btn btn-default btn-next">NEXT</button-->
            </div>
            <!-- Second Screen of Form -->
            <div class="form-screen-2">
               <div class="form-group">
                  <input type="text" class="form-control" id="city" name="city" placeholder="City" value="{{ old('city') }}" autocomplete="false">
               </div>
               <div class="form-group">
                  {!! Form::select('country_code', $country, null, ['class'=>'form-control', 'id'=>'country', 'placeholder'=>'Country Code', 'autocomplete'=>'false']) !!}
               </div>
               <div class="form-group">
                  <input type="text" class="form-control" id="zipcode" name="zip_code" placeholder="Zip Code" value="{{ old('zip_code') }}" autocomplete="false">
                  @if ($errors->has('zipcode'))
						<span class="help-block">
							<strong>{{ $errors->first('zipcode') }}</strong>
						</span>
					@endif
               </div>
               <button type="submit" class="btn btn-default btn-in">GET ME IN</button>
            </div>
         </form>
      </div>
      <div class="col-md-4"></div>
   </div>
</div>

@endsection

<script type="text/javascript">

function validateForm() {
	var checked = document.forms["register"]["agree"].checked;
	if (!checked) {
		alert("Oops! Please check the checkbox!");
		return false;
	}
}

</script>
