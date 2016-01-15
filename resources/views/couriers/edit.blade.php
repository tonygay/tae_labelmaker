@extends('layout')

@section('content')

	<h2>{{ $courier->id ? 'Edit' : 'Add' }} Courier</h2>
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

	{!! Form::open(['route' => $courier->id ? [ 'couriers.update', $courier->id] : 'couriers.store', 'method' => $courier->id ? 'PUT' : 'POST', 'class' => 'form-horizontal']) !!}
	
		<div class="form-group">
			{!! Form::label('name', 'Courier Name', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::text('name', $courier->name, ['class' => 'form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('code', 'Courier Code', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::text('code', $courier->code, ['class' => 'form-control']) !!}
			</div>
		</div>
		
		<hr>
		
		<h3>Label Display Preferences</h3>
		
		<div class="form-group">
			{!! Form::label('label_preferences_json[code1]', 'Code Display Order', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10 form-inline">
				<div class="col-sm-2 form-group">
					{!! Form::label('label_preferences_json[code1]', '1.') !!}
					{!! Form::select('label_preferences_json[code1]', ['' => 'None', 'courier_code' => 'Courier', 'hub' => 'Hub', 'site_code' => 'Site'], $courier->label_preferences_json->code1, ['class' => 'form-control']) !!}
				</div>
				<div class="col-sm-2 form-group">
					{!! Form::label('label_preferences_json[code2]', '2.') !!}
					{!! Form::select('label_preferences_json[code2]', ['' => 'None', 'courier_code' => 'Courier', 'hub' => 'Hub', 'site_code' => 'Site'], $courier->label_preferences_json->code2, ['class' => 'form-control']) !!}
				</div>
				<div class="col-sm-2 form-group">
					{!! Form::label('label_preferences_json[code3]', '3.') !!}
					{!! Form::select('label_preferences_json[code3]', ['' => 'None', 'courier_code' => 'Courier', 'hub' => 'Hub', 'site_code' => 'Site'], $courier->label_preferences_json->code3, ['class' => 'form-control']) !!}
				</div>
			</div>
		</div>
		
		<div class="form-group">
			{!! Form::label('label_preferences_json[use_address]', 'Address Display', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10 form-inline">
					<label class="radio-inline">
						{!! Form::radio('use_address', 'use_address1', $courier->label_preferences_json->use_address1 && !$courier->label_preferences_json->use_address2) !!} Use Address 1
					</label>
					<label class="radio-inline">
						{!! Form::radio('use_address', 'use_address2', $courier->label_preferences_json->use_address2 && !$courier->label_preferences_json->use_address1) !!} Use Address 2
					</label>
					<label class="radio-inline">
						{!! Form::radio('use_address', 'use_address_both', $courier->label_preferences_json->use_address1 && $courier->label_preferences_json->use_address2) !!} Use Both Addresses
					</label>
			</div>
		</div>
		
		<div class="form-group">
			{!! Form::label('label_preferences_json[additional_label_field]', 'Additional Field String', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::text('label_preferences_json[additional_label_field]', $courier->label_preferences_json->additional_label_field, ['class' => 'form-control']) !!}
				<h4 class="small">
					Add institution properties into additional field by preceeding the
					property name with a colon (:).<br>
					Available properties:
					:name, :address1, :address2, :city, :state, :postal_code,
					:type, :notes, :oclc, :hub, :site_code, :service_length
				</h4>
			</div>
		</div>
		
		<hr>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				{!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
				&nbsp;&nbsp;<a href="{!! route('couriers.index') !!}">
					Cancel
				</a>
			</div>
		</div>

	{!! Form::close() !!}

@stop