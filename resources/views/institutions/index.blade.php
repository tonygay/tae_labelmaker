@extends('layout')

@section('content')
	<h2>
		Institutions

		<span class="pull-right">
			<a href="{!! route('institutions.upload') !!}" class="btn btn-default">
				<i class="glyphicon glyphicon-upload pull-left"></i>&nbsp;Import List
			</a>&nbsp;
			<a href="{!! route('institutions.create') !!}" class="btn btn-default">
				<i class="glyphicon glyphicon-plus pull-left"></i>&nbsp;Add Institution
			</a>
		</span>
	</h2>

	<hr>
	
	@if(isset($results))
	    <div class="alert alert-info small">
			<h4>Import successful!</h4>
	        <ul>
	            @foreach ($results as $action => $count)
	                <li>{{ $count }} institution{{ $count == 1 ? '' : 's' }} {{ $action }}.</li>
	            @endforeach
	        </ul>
	    </div>
		<hr>
	@endif

	<div>
		{!! Form::open(['route' => 'institutions.filtered-index', 'method' => 'POST', 'class' => 'form-inline']) !!}
			<div class="form-group">
				{!! Form::label('courier_id', 'Filter by Courier', ['class' => 'control-label']) !!}
				{!! Form::select('courier_id', $couriers->prepend('All', 0), $courier_id, ['class' => 'form-control']) !!}
			</div>
			{!! Form::submit('Go', ['class' => 'btn btn-default']) !!}
		{!! Form::close() !!}
	</div>
	
	<hr>

	<table class="table table-striped">
		<thead>
			<tr>
				<th>Courier</th>
				<th>Hub</th>
				<th>Site</th>
				<th>OCLC</th>
				<th>Name</th>
				<th>Location</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			@foreach($institutions as $institution)
				<tr>
					<td>{{ $institution->courier->code }}</td>
					<td>{{ $institution->hub }}</td>
					<td>{{ $institution->site_code }}</td>
					<td>{{ $institution->oclc }}</td>
					<td>{{ $institution->name }}</td>
					<td>{{ $institution->city }}, {{ $institution->state }}</td>
					<td>
						{!! Form::open(['route' => ['institutions.destroy', $institution->id], 'method' => 'DELETE']) !!}
							<a href="{!! route('institutions.edit', $institution->id) !!}" title="Edit this institution."
								class="btn btn-default btn-xs">
								<i class="glyphicon glyphicon-edit"></i>
							</a>
							{!! Form::button(
									'<i class="glyphicon glyphicon-trash"></i>',
									[
										'type' => 'submit',
										'class' => 'btn btn-danger btn-xs',
										'title' => 'Delete this institution.'
									]
							) !!}
						{!! Form::close() !!}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop