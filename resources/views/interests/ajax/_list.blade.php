@foreach($interestData as $key => $interest)
	@if($key == 0 || ($key+1)%3 == 0)
		<div class="row int-sign-row">    
			<div class="form-group">
	@endif
		<div class="col-md-4 custom-row-padding">
			<label>
				<p>{{ $interest->title }}</p>
				<img src="{{ URL::to('/') }}/default/images/interests/{{ $interest->image }}" alt="kritish-{{ $interest->title }}" class="img-responsive img-uncheck img-check">
				<input type="checkbox" name="interest[]" id="interest-sign" value="{{ $interest->id }}" class="hidden">
			</label>
		</div>
	@if( ($key+1)%3 == 0)
		</div>
    </div>
    @endif
@endforeach