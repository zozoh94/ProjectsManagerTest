@extends('layouts.app')

@section('content')

<div class="container">
  <div class="panel panel-default">
    
    <div class="panel-heading">
      <h1 class="panel-title">Employee #{{ $employee->id }}</h1>
    </div>
    
    <div class="panel-body">
      <p>
	Firstname : {{ $employee->firstname }}<br/>
	Lastname : {{ $employee->lastname }}<br/>
	Email : {{ $employee->email }}
      </p>
      @if (count($employee->leadedProjects) > 0)
      <p>
      Leaded projects :
      @foreach ($employee->leadedProjects as $key => $project)
      <a href="{{ route('projects.show', $project->id) }}">{{ $project->name }}</a>@if ($key+1 != count($employee->leadedProjects)), @endif
      @endforeach
      </p>
      @endif
      @if (count($employee->performedProjects) > 0)
      <p>
      Performed projects :
      @foreach ($employee->performedProjects as $key => $project)
      <a href="{{ route('projects.show', $project->id) }}">{{ $project->name }}</a>@if ($key+1 != count($employee->leadedProjects)), @endif
      @endforeach
      </p>
      @endif
      <p>
      <div class="pull-right">
      {!! Form::open(['route' => ['employees.destroy', 'id' => $employee->id], 'method' => 'delete']) !!}
      <div class="btn-group">
	<a href="{{ route('employees.edit', ['id' => $employee->id ]) }}" class="btn btn-success">Edit</a>
	{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
      </div>
      {!! Form::close() !!}
      </div>
    </div>
    
  </div>
</div>

@endsection
