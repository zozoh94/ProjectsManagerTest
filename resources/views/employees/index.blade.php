@extends('layouts.app')

@section('content')

<div class="container">
  <div class="panel panel-default">
    
    <div class="panel-heading">
      <h1 class="panel-title">Employees</h1>
    </div>
    
    <div class="panel-body">
      <table class="table table-striped">
	<thead>
	  <tr>
	    <th>#</th>
	    <th>Firstname</th>
	    <th>Lastname</th>
	    <th>Email</th>
	    <th>Actions</th>
	  </tr>
	</thead>
	<tbody>
	  @foreach($employees as $employee)	  
	  <tr>
	    <th scope="row">{{ $employee->id }}</th>
	    <td>{{ $employee->firstname }}</td>
	    <td>{{ $employee->lastname }}</td>
	    <td>{{ $employee->email }}</td>
	    <td>
	      {!! Form::open(['route' => ['employees.destroy', 'id' => $employee->id], 'method' => 'delete']) !!}
	      <div class="btn-group">
		<a href="{{ route('employees.show', ['id' => $employee->id ]) }}" class="btn btn-primary">Show</a>
		<a href="{{ route('employees.edit', ['id' => $employee->id ]) }}" class="btn btn-success">Edit</a>
		{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
	      </div>
	      {!! Form::close() !!}
	    </td>
	  </tr>
	  @endforeach
	</tbody>
      </table>
      {{ $employees->links() }}
      <a class="btn btn-default pull-right" href="{{ route('employees.create') }}">Create an employee</a>
    </div>
    
  </div>
</div>

@endsection
