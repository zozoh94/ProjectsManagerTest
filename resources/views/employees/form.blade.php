<div class="form-group @if ($errors->getBag('default')->has('firstname')) has-error @endif">
  {!! Form::label('firstname', 'Firstname :', ['class' => 'sr-only']) !!}
  <div class="input-group">
    <div class="input-group-addon fa fa-user"></div>
    {!! Form::text('firstname', null, ['class' => 'form-control', 'placeholder' => 'Firstname', 'required']) !!}
  </div>
  @foreach ($errors->getBag('default')->get('firstname') as $error)    
  <span class="help-block">{{ $error }}</span>
  @endforeach
</div>
<div class="form-group @if ($errors->getBag('default')->has('lastname')) has-error @endif">
  {!! Form::label('lastname', 'Lastname :', ['class' => 'sr-only']) !!}
  <div class="input-group">
    <div class="input-group-addon fa fa-user"></div>
    {!! Form::text('lastname', null, ['class' => 'form-control', 'placeholder' => 'Lastname', 'required']) !!}
  </div>
  @foreach ($errors->getBag('default')->get('lastname') as $error)    
  <span class="help-block">{{ $error }}</span>
  @endforeach
</div>
<div class="form-group @if ($errors->getBag('default')->has('email')) has-error @endif">
  {!! Form::label('email', 'Email :', ['class' => 'sr-only']) !!}
  <div class="input-group">
    <div class="input-group-addon fa fa-at"></div>
    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email', 'required']) !!}
  </div>
  @foreach ($errors->getBag('default')->get('email') as $error)    
  <span class="help-block">{{ $error }}</span>
  @endforeach
</div>
