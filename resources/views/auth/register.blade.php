@extends('layout')

@section('content')

	<h2>Create a new user</h2>
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

	{!! Form::open(['route' => 'users.store', 'class' => 'form-horizontal']) !!}

		<div class="form-group">
			{!! Form::label('institution_id', 'Institution', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::select('institution_id', $institutions->prepend('None', ''), old('institutions_id'), ['class' => 'form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('username', 'Username', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::text('username', old('username'), ['class' => 'form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('password', 'Password', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::password('password', ['class' => 'form-control']) !!}
			</div>
		</div>
		
		<div class="form-group">
			{!! Form::label('password_confirmation', 'Confirm Password', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				{!! Form::submit('Create User', ['class' => 'btn btn-primary']) !!}
			</div>
		</div>

	{!! Form::close() !!}

@stop