<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Project Manager</title>

    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
  </head>
  <body>

    <div id="app">
      <div class="navbar navbar-default" role="navigation">
	<div class="container">
	  <div class="navbar-header">
	    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
	    </button>
	    <a class="navbar-brand" href="{{ route('projects.index') }}">Project Manager</a>
	  </div>
	  <div class="collapse navbar-collapse" id="menu">
	    <ul class="nav navbar-nav">
	      <li><a href="{{  route('projects.create') }}">Create Project</a></li>            
	      <li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Employees <span class="caret"></span></a>
		<ul class="dropdown-menu">
		  <li><a href="{{ route('employees.index') }}">All</a></li>
		  <li><a href="{{ route('employees.create') }}">Create</a></li>
		</ul>
              </li>
	    </ul>
	  </div>
	</div>
      </div>
      
      @if(session()->has('ok'))
      <div class="container">
	<div class="alert alert-success alert-dismissible" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  {!! session('ok') !!}
	</div>
      </div>
      @endif

      @yield('content')
      
      <div class="container">
	<hr>
	<footer>
          <p>Enzo Hamelin © Buben Guru team 2016</p>
	</footer>
      </div>
    </div>

    <script src="{{ elixir('js/vendor/modernizr-custom.js') }}"></script>
    <script src="{{ elixir('js/app.js') }}"></script>
  </body>
</html>
