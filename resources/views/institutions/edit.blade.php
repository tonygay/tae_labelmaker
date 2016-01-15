@extends('layout')

@section('content')

	<h2>{{ $institution->id ? 'Edit' : 'Add' }} Institution</h2>
	<hr>

	@if (count($errors) > 0)
	    <div class="alert alert-danger">
			There were some errors in your last request:
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
		<hr>
	@endif

	{!! Form::open(['route' => $institution->id ? [ 'institutions.update', $institution->id] : 'institutions.store', 'method' => $institution->id ? 'PUT' : 'POST', 'class' => 'form-horizontal']) !!}
	
		<div class="form-group">
			{!! Form::label('name', 'Institution Name', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::text('name', $institution->name, ['class' => 'form-control']) !!}
			</div>
		</div>
		
		<div class="form-group">
			{!! Form::label('courier_id', 'Courier', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::select('courier_id', $couriers, $institution->courier_id, ['class' => 'form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('oclc', 'OCLC', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::text('oclc', $institution->oclc, ['class' => 'form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('hub', 'Hub', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::text('hub', $institution->hub, ['class' => 'form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('site_code', 'Site Code', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::text('site_code', $institution->site_code, ['class' => 'form-control']) !!}
			</div>
		</div>
		<hr>

		<div class="form-group">
			{!! Form::label('address1', 'Address1', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::text('address1', $institution->address1, ['class' => 'form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('address2', 'Address2', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::text('address2', $institution->address2, ['class' => 'form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('city', 'City', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::text('city', $institution->city, ['class' => 'form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('state', 'State', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::text('state', $institution->state, ['class' => 'form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('postal_code', 'Zip Code', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::text('postal_code', $institution->postal_code, ['class' => 'form-control']) !!}
			</div>
		</div>
		<hr>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				{!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
				&nbsp;&nbsp;<a href="{!! route('institutions.index') !!}">
					Cancel
				</a>
			</div>
		</div>

	{!! Form::close() !!}

@stop