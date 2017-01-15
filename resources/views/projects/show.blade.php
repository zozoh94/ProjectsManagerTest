@extends('layouts.app')

@section('content')

<div class="container">
  <div class="panel panel-default">
    
    <div class="panel-heading">
      <h1 class="panel-title">Project #{{ $project->id }}</h1>
    </div>
    
    <div class="panel-body">
      <div class="row">
	<div class="col-sm-6">
	  <p>
	    Name : {{ $project->name }}<br/>
	    Client company's name : {{ $project->clientCompanyName }}<br/>
	    Performer company's name : {{ $project->performerCompanyName }}
	  </p>
	</div>
	<div class="col-sm-6">
	  <p>
	    Start date : {{ $project->startDate }}<br/>
	    End date : {{ $project->endDate }}<br/>
	    Priority : {{ $project->priority }}
	  </p>
	</div>
	<div class="col-sm-12">
	  <p>Leader : <a href="{{ route('employees.show', $project->leader->id) }}">{{ $project->leader->firstname }} {{ $project->leader->lastname }}</a></p>
	  @if (count($project->performers) > 0)
	  <p>Performers : 
	  @foreach ($project->performers as $key => $performer)
            <a href="{{ route('employees.show', $performer->id) }}">{{ $performer->firstname }} {{ $performer->lastname }}</a>
	    @if ($key+1 != count($project->performers)), @endif
	  @endforeach
	  </p>
	  @endif
          <p>Comment : {{ $project->comment }}</p>
	</div>
	<div class="col-sm-12">
	  <div class="pull-right">
	    {!! Form::open(['route' => ['projects.destroy', 'id' => $project->id], 'method' => 'delete']) !!}
	    <div class="btn-group">
	      <a href="{{ route('projects.edit', ['id' => $project->id ]) }}" class="btn btn-success">Edit</a>
	      {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
	    </div>
	    {!! Form::close() !!}
	  </div>
	</div>
      </div>
    </div>
    
  </div>
</div>

@endsection
