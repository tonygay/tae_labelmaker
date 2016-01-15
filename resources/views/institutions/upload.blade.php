@extends('layout')

@section('content')
	<h2>Upload Institution File</h2>
	<hr>
	
	<div class="alert alert-info small">
		Upload file requirements:
		<ul>
			<li>File must be in Microsoft Excel format</li>
			<li>Data must be in the first sheet inside the Excel workbook</li>
			<li>First line of the worksheet must be the column headers (no empty rows)</li>
		<ul>
	</div>
	<hr>

	{!! Form::open(['route' => 'institutions.import', 'class' => 'form-horizontal', 'files' => true]) !!}
	
		<div class="form-group">
			{!! Form::label('courier_id', 'Courier', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::select('courier_id', $couriers, null, ['class' => 'form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('institutionFile', 'Select File', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::file('institutionFile', ['class' => 'form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				{!! Form::submit('Upload', ['class' => 'btn btn-primary']) !!}
			</div>
		</div>

	{!! Form::close() !!}
@stop