@extends('layouts.firstTime')

@section('content')

<form method="post" method="POST" action="{{ url('/interest/') }}/{{ Auth::user()->id }}">
	{!! csrf_field() !!}
	<div class="row interest-sign">
		<div class="col-md-8"><h1>Welcome to Kritish</h1><h3>Select 3 or more interest areas and we'll build your feed.</h3>
			@if ($errors->has('interest')) <span class=""> <strong>Please select atleast 3 interests</strong> </span> @endif
		</div>    
		<div class="col-md-4 int-btn-row">
			<button type="submit" class="btn btn-default btn-md btn-s-interest-1">PROCEED</button>
		</div>    
	</div>
	<section class="interestAreaLists">
		@foreach($interestData as $key => $interest)
				@if($key < 9)
					@if($key == 0 || ($key+1)%3 == 0)
						<div class="row int-sign-row">    
							<div class="form-group">
					@endif
                    <section class="first-line-interests">
                        <div class="col-md-4 custom-row-padding">
							<label>
								<p>{{ $interest->title }}</p>
								<img src="{{ URL::to('/') }}/default/images/interests/{{ $interest->image }}" alt="kritish-{{ $interest->title }}" class="img-responsive img-uncheck img-check">
								<input type="checkbox" name="interest[]" id="interest-sign" value="{{ $interest->id }}" class="hidden">
							</label>
						</div>
                    </section>
                    @if( ($key+1)%3 == 0)
						</div>
		            </div>
		            @endif
                @else
					<section class="remaining-line-interests">
                        <div class="col-md-4 custom-row-padding">
							<label>
								<p>{{ $interest->title }}</p>
								<img src="{{ URL::to('/') }}/default/images/interests/{{ $interest->image }}" alt="kritish-{{ $interest->title }}" class="img-responsive img-uncheck img-check">
								<input type="checkbox" name="interest[]" id="interest-sign" value="{{ $interest->id }}" class="hidden">
							</label>
						</div>
                    </section>
				@endif
        @endforeach
   		<button type="button" class="btn btn-default btn-block btn-s-interest-2" id="show_more">SHOW MORE</button>
	</section>
		
</form>
<div class="clearfix"></div>
@endsection
@section('customJsFiles')
    <script src="{{ URL::asset('default/js/interestLoader.js') }}"></script>
@endsection
