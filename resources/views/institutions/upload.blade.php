@extends('layout')

@section('content')
	<h2>Upload Institution File</h2>
	<hr>
	
	<div class="alert alert-info small">
		<h5>Upload file requirements</h5>
		<ul>
			<li>File must be in Microsoft Excel format</li>
			<li>Data must be in the first sheet inside the Excel workbook</li>
			<li>First line of the worksheet must be the column headers (no empty rows)</li>
			<li>
				Expected column headers, column header matching is case insensitive (those in bold are required):
				<ul>
					<li>Hub: &ldquo;hub&rdquo; or &ldquo;hub code&rdquo;</li>
					<li>Site: &ldquo;site&rdquo; or &ldquo;site code&rdquo;</li>
					<li>OCLC: &ldquo;oclc&rdquo; or &ldquo;oclc symbol&rdquo;</li>
					<li><strong>Institution Name</strong>: &ldquo;name&rdquo;, &ldquo;library name&rdquo;, &ldquo;institution name&rdquo;, or &ldquo;institution&rdquo;</li>
					<li>Address 1: &ldquo;address&rdquo; or &ldquo;address1&rdquo;</li>
					<li>Zip Code: &ldquo;zip code&rdquo; or &ldquo;postal code&rdquo;</li>
					<li>Notes: &ldquo;notes&rdquo; or &ldquo;special notes&rdquo;</li>
					<li>Address 2, <strong>City</strong>, <strong>State</strong>: &ldquo;address2&rdquo;, &ldquo;city&rdquo;, and &ldquo;state&rdquo; (respectively)</li>
				</ul>
			</li>
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