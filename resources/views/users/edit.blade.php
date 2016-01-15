@extends('layout')

@section('content')

	<h2>Edit user</h2>
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

	{!! Form::open(['route' => ['users.update', $user->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
		@if(Auth::user()->admin)
			<div class="form-group">
				{!! Form::label('institution_id', 'Institution', ['class' => 'col-sm-2 control-label']) !!}
				<div class="col-sm-10">
				{!! Form::select('institution_id', $institutions->prepend('None', ''), $user->institution_id, ['class' => 'form-control']) !!}
				</div>
			</div>

			<div class="form-group">
				{!! Form::label('username', 'Username', ['class' => 'col-sm-2 control-label']) !!}
				<div class="col-sm-10">
					{!! Form::text('username', $user->username, ['class' => 'form-control']) !!}
				</div>
			</div>
		
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="checkbox">
						<label>
							{!! Form::checkbox('admin', 1, $user->admin) !!} Administrator
						</label>
					</div>
				</div>
			</div>
			<hr>
		@endif
		
		<h3>Reset Password</h3>
		<div class="form-group">
			{!! Form::label('password', 'New Password', ['class' => 'col-sm-2 control-label']) !!}
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
		<hr>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				{!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
			</div>
		</div>

	{!! Form::close() !!}

@stop