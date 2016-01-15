@extends('layout')

@section('content')
	<h2>Login</h2>
	
	@unless ($errors->isEmpty())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endunless
	
	<!-- resources/views/auth/login.blade.php -->
	{!! Form::open(['route' => 'auth.login']) !!}
	
		<div class="form-group">
			{!! Form::label('institution_id', 'Select Your Institution', ['class' => 'control-label']) !!}
			{!! Form::select('institution_id', $institutions->prepend('N/A', ''), old('institutions_id'), ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('username', 'Or Enter Your Username:', ['class' => 'control-label']) !!}
			{!! Form::text('username', old('username'), ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('password', 'Password:', ['class' => 'control-label']) !!}
			{!! Form::password('password', ['class' => 'form-control']) !!}
		</div>
	
		<div class="form-group">
			<div class="checkbox">
				<label>
				  <input type="checkbox" name="remember"> Remember me
				</label>
			</div>
		</div>
		
		<hr>

		<div class="form-group">
			{!! Form::submit('Login', ['class' => 'btn btn-primary']) !!}
		</div>

	{!! Form::close() !!}
@stop