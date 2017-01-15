@extends('layouts.app')

@section('content')

<div class="container">
  <div class="panel panel-default">
    
    <div class="panel-heading">
      <h1 class="panel-title">Edit the Employee #{{ $employee->id }}</h1>
    </div>
    
    <div class="panel-body">

      {!! Form::model($employee, ['route' => ['employees.update', 'id' => $employee->id], 'method' => 'put']) !!}

      @include('employees.form')
      {!! Form::submit('Edit', ['class' => 'btn btn-primary btn-block']) !!}

      {!! Form::close() !!}

    </div>

  </div>
</div>

@endsection
