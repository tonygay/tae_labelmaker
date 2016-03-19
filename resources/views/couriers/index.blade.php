@extends('layout')

@section('content')
	<h2>
		Couriers
		
		<a href="{!! route('couriers.create') !!}" class="btn btn-default pull-right">
			<i class="glyphicon glyphicon-plus pull-left"></i>&nbsp;Add Courier
		</a>
		
	</h2>
	
	<hr>

	<table class="table table-striped">
		<thead>
			<tr>
				<th>Name</th>
				<th>Institutions</th>
				<th>Code</th>
				<th>Additional Label Field</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			@foreach($couriers as $courier)
				<tr class="{{ $courier->trashed() ? 'danger' : '' }}">
					<td>{{ $courier->name }}</td>
					<td>{{ $courier->institutions->count() }}</td>
					<td>{{ $courier->code }}</td>
					<td>{{ isset($courier->label_preferences_json->additional_label_field) ? $courier->label_preferences_json->additional_label_field : '&nbsp;' }}</td>
					<td>
						@if($courier->trashed())
							{!! Form::open(['route' => ['couriers.restore', $courier->id], 'method' => 'POST']) !!}
								<a href="{!! route('couriers.edit', $courier->id) !!}" title="Edit this courier."
									class="btn btn-default btn-xs">
									<i class="glyphicon glyphicon-edit"></i>
								</a>
								{!! Form::button(
										'<i class="glyphicon glyphicon-eye-open"></i>',
										[
											'type' => 'submit',
											'class' => 'btn btn-success btn-xs',
											'title' => 'Restore this courier.'
										]
								) !!}
							{!! Form::close() !!}
						@else
							{!! Form::open(['route' => ['couriers.destroy', $courier->id], 'method' => 'DELETE']) !!}
								<a href="{!! route('couriers.edit', $courier->id) !!}" title="Edit this courier."
									class="btn btn-default btn-xs">
									<i class="glyphicon glyphicon-edit"></i>
								</a>
								{!! Form::button(
										'<i class="glyphicon glyphicon-eye-close"></i>',
										[
											'type' => 'submit',
											'class' => 'btn btn-danger btn-xs',
											'title' => 'Disable this courier.'
										]
								) !!}
							{!! Form::close() !!}
						@endif
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop