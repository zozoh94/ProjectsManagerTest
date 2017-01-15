@extends('layouts.app')

@section('content')

<div class="container">
  <div class="panel panel-default">
    
    <div class="panel-heading">
      <h1 class="panel-title">Create an Employee</h1>
    </div>
    
    <div class="panel-body">

      {!! Form::open(['route' => 'employees.store']) !!}

      @include('employees.form')
      {!! Form::submit('Create', ['class' => 'btn btn-primary btn-block']) !!}

      {!! Form::close() !!}

    </div>

  </div>
</div>

@endsection
