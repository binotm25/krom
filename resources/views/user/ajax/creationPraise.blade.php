<section class="praise-more-get">
	@foreach($creationPraises->praise->sortBy('created_at')->take($count - 2) as $praise)
		<div class="row praise-pop-top">
		    <div class="col-xs-2 praise-pop">
			    <a href="{{ route('profile_page', ['user'=>md5(rand(9999,0000)).strrev($praise->user->id)]) }}" data-toggle="tooltip" data-placement="right" title="{{ $praise->user->name }}">
			    	@if($praise->user->profile_pic == "")
				        <img src="{{URL::asset('default/images/people/user.png')}}" class="center-block" height="40" width="40" alt="user-profile">
				    @else
				        <img src="{{URL::asset('default/images/people/'.$praise->user->profile_pic)}}" class="center-block" height="40" width="40" alt="user-profile">
				    @endif
				</a>
		    </div>
		    <div class="col-xs-10 praise-pop"><a href="#">{{ $praise->user->name }}</a>
		        <p>{{ $praise->user->city }}, {{ $praise->user->country_code }}</p>
		    </div>
		</div>
		<hr>   
	@endforeach
</section>