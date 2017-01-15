<div class="row">
  <div class="col-sm-6">
    <div class="form-group @if ($errors->getBag('default')->has('name')) has-error @endif">
      {!! Form::label('name', 'Name :', ['class' => 'sr-only']) !!}
      {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name', 'required']) !!}
      @foreach ($errors->getBag('default')->get('name') as $error)    
      <span class="help-block">{{ $error }}</span>
      @endforeach
    </div>
    <div class="form-group @if ($errors->getBag('default')->has('clientCompanyName')) has-error @endif">
      {!! Form::label('clientCompanyName', 'Client company\'s name :', ['class' => 'sr-only']) !!}
      <div class="input-group">
	<div class="input-group-addon fa fa-building"></div>
	{!! Form::text('clientCompanyName', null, ['class' => 'form-control', 'placeholder' => 'Client company\'s name', 'required']) !!}
      </div>
      @foreach ($errors->getBag('default')->get('clientCompanyName') as $error)    
      <span class="help-block">{{ $error }}</span>      
      @endforeach
    </div>
    <div class="form-group @if ($errors->getBag('default')->has('performerCompanyName')) has-error @endif">
      {!! Form::label('performerCompanyName', 'Performer company\'s name :', ['class' => 'sr-only']) !!}
      <div class="input-group">
	<div class="input-group-addon fa fa-building"></div>
	{!! Form::text('performerCompanyName', null, ['class' => 'form-control', 'placeholder' => 'Performer company\'s name', 'required']) !!}
      </div>
      @foreach ($errors->getBag('default')->get('performerCompanyName') as $error)    
      <span class="help-block">{{ $error }}</span>
      @endforeach
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group @if ($errors->getBag('default')->has('startDate')) has-error @endif">
      {!! Form::label('startDate', 'Start date :', ['class' => 'sr-only']) !!}
      <div class="input-group">
	<div class="input-group-addon fa fa-calendar"></div>
	{!! Form::datetime('startDate', null, ['class' => 'form-control datetimepicker', 'placeholder' => 'Start date', 'required']) !!}
      </div>
      @foreach ($errors->getBag('default')->get('startDate') as $error)    
      <span class="help-block">{{ $error }}</span>
      @endforeach
    </div>
    <div class="form-group @if ($errors->getBag('default')->has('endDate')) has-error @endif">
      {!! Form::label('endDate', 'End date :', ['class' => 'sr-only']) !!}
      <div class="input-group">
	<div class="input-group-addon fa fa-calendar"></div>
	{!! Form::datetime('endDate', null, ['class' => 'form-control datetimepicker', 'placeholder' => 'End date', 'required']) !!}
      </div>
      @foreach ($errors->getBag('default')->get('endDate') as $error)    
      <span class="help-block">{{ $error }}</span>
      @endforeach
    </div>
    <div class="form-group @if ($errors->getBag('default')->has('priority')) has-error @endif">
      {!! Form::label('priority', 'Priority :', ['class' => 'sr-only']) !!}
      <div class="input-group">
	<div class="input-group-addon fa fa-exclamation-circle"></div>
	{!! Form::number('priority', null, ['class' => 'form-control', 'placeholder' => 'Priority', 'required', 'min' => 0, 'step' => 1]) !!}
      </div>
      @foreach ($errors->getBag('default')->get('priority') as $error)    
      <span class="help-block">{{ $error }}</span>
      @endforeach
    </div>
  </div>
  <div class="col-sm-4">
    <div class="form-group @if ($errors->getBag('default')->has('leader_id')) has-error @endif">
      {!! Form::label('leader_id', 'Leader :', ['class' => 'sr-only']) !!}
      <select placeholder="Leader :" name="leader_id" class="leader-selectpicker form-control" required data-url="{!! route('employees.index') !!}">
	@if (isset($project))
	<option value="{{ $project->leader->id }}" selected>{{ $project->leader->firstname }} {{ $project->leader->lastname }}</option>
	@endif
      </select>  
      @foreach ($errors->getBag('default')->get('leader_id') as $error)    
      <span class="help-block">{{ $error }}</span>
      @endforeach
    </div>
  </div>
  <div class="col-sm-8">
    <div class="form-group @if ($errors->getBag('default')->has('performers_id')) has-error @endif">
      {!! Form::label('performers_id', 'Performers :', ['class' => 'sr-only']) !!}
      <select multiple="multiple" name="performers_id[]" class="performers-selectpicker form-control" data-url="{!! route('employees.index') !!}">
	@if (isset($project))
	@foreach ($project->performers as $performer)
	<option value="{{ $performer->id }}" selected>{{ $performer->firstname }} {{ $performer->lastname }}</option>
	@endforeach
	@endif
      </select>  
      @foreach ($errors->getBag('default')->get('performers_id') as $error)    
      <span class="help-block">{{ $error }}</span>
      @endforeach
    </div>
  </div>
  <div class="col-sm-12">
    <div class="form-group @if ($errors->getBag('default')->has('comment')) has-error @endif">
      {!! Form::label('comment', 'Comment :', ['class' => 'sr-only']) !!}
      {!! Form::textarea('comment', null, ['class' => 'form-control', 'placeholder' => 'Comment', 'required']) !!}
      @foreach ($errors->getBag('default')->get('comment') as $error)    
      <span class="help-block">{{ $error }}</span>
      @endforeach
    </div>
  </div>
</div>
