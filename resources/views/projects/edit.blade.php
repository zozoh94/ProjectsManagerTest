@extends('layouts.app')

@section('content')

<div class="container">
  <div class="panel panel-default">
    
    <div class="panel-heading">
      <h1 class="panel-title">Edit a Project</h1>
    </div>
    
    <div class="panel-body">

      {!! Form::model($project, ['route' => ['projects.update', 'id' => $project->id], 'method' => 'put']) !!}

      @include('projects.form')
      {!! Form::submit('Edit', ['class' => 'btn btn-primary btn-block']) !!}

      {!! Form::close() !!}

    </div>

  </div>
</div>

@endsection
