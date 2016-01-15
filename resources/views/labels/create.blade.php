@extends('layout')

@section('content')
	<h2>
		Make Labels<br>
		<small>Create shipping labels in 5 easy steps.</small>
	</h2>
	<hr>
	
	@if (count($errors) > 0)
	    <div class="alert alert-danger">
			There were some errors in your label request:
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
		<hr>
	@endif
	
	{!! Form::open(['route' => 'labels.show', 'method' => 'GET']) !!}

	<div class="col-sm-1"><h1>1</h1></div>
	<div class="form-group col-sm-11">
		<h4>Select the institution that is shipping the package</h4>
		<label for="from" class="control-label">FROM</label>
		<select name="from" class="form-control select2">
			@foreach($institutions->where('courier.code', 'TAE') as $institution)
				<option value="{{ $institution->id }}" {!! Auth::user()->institution_id == $institution->id ? 'selected="selected"' : '' !!}>
					{{ $institution->detailed_identifier }}
				</option>
			@endforeach
		</select>
	</div>
	
	<hr class="col-sm-12">
	
	<div class="col-sm-1"><h1>2</h1></div>
	<div class="form-group col-sm-11">
		<h4>
			Select the institution(s) that the package is being shipped to<br>
			<small>Search for institutions by name, city or OCLC code<br>
			You can create multiple labels by selecting multiple To institutions.<br>
			Remember that different regions might have institutions with similar names, check the city or the courier code to be sure you are selecting the correct one.</small>
		</h4>
		<label for="to" class="control-label">TO</label>
		<select multiple name="to[]" class="form-control select2">
			@foreach($institutions as $institution)
				<option value="{{ $institution->id }}">
					{{ $institution->detailed_identifier }}
				</option>
			@endforeach
		</select>
	</div>
	
	<hr class="col-sm-12">
	
	<div class="col-sm-1"><h1>3</h1></div>
	<div class="form-group col-sm-11">
		<h4>
			Enter the package shipping date<br>
			<small>Or select "Leave empty" to fill in the date yourself.</small>
		</h4>
		<div class="radio">
		  <label>
		    <input type="radio" name="add_date" id="add_date1" value="1" checked>
		    <input type="text" name="shipping_date" value="{{ date('m/d/Y') }}">
		  </label>
		</div>
		<div class="radio">
		  <label>
		    <input type="radio" name="add_date" id="add_date2" value="0">
		    Leave empty
		  </label>
		</div>
	</div>
	
	<hr class="col-sm-12">
	
	<div class="col-sm-1"><h1>4</h1></div>
	<div class="form-group col-sm-11">
		<h4>
			How many of each label should be printed?<br>
			<small>Labels print 4 per page</small>
		</h4>
		<input type="text" name="label_count" value="1" class="col-sm-1">
	</div>
	
	<hr class="col-sm-12">
	
	<div class="col-sm-1"><h1>5</h1></div>
	<div class="form-group col-sm-11">
		<h4>
			Show me the labels
		</h4>
		{!! Form::submit('View Labels', ['class' => 'btn btn-primary']) !!}
	</div>
	
	{!! Form::close() !!}

@stop