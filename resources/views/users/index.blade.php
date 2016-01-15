@extends('layout')

@section('content')
	<h2>
		Users
		
		<a href="{!! route('users.create') !!}" class="btn btn-default pull-right">
			<i class="glyphicon glyphicon-plus pull-left"></i>&nbsp;Add User
		</a>
		
	</h2>
	
	<hr>

	<table class="table table-striped">
		<thead>
			<tr>
				<th>Institution</th>
				<th>Username</th>
				<th class="text-center">Admin?</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			@foreach($users as $user)
				<tr>
					<td>
						@if(isset($user->institution->name))
							{{ $user->institution->name }}
						@else
							<em class="text-muted">Not tied to an institution</em>
						@endif
					</td>
					<td>{{ $user->username }}</td>
					<td class="text-center">
						@if ($user->admin)
							<i class="glyphicon glyphicon-ok"></i>
						@else
							&nbsp;
						@endif
					</td>
					<td>
						{!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'DELETE']) !!}
							<a href="{!! route('users.edit', $user->id) !!}" title="Edit this user."
								class="btn btn-default btn-xs">
								<i class="glyphicon glyphicon-edit"></i>
							</a>
							{!! Form::button(
									'<i class="glyphicon glyphicon-trash"></i>',
									[
										'type' => 'submit',
										'class' => 'btn btn-danger btn-xs',
										'title' => 'Delete this user.'
									]
							) !!}
						{!! Form::close() !!}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop