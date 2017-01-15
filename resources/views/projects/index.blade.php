@extends('layouts.app')

@section('content')

<div class="container">
  <div class="panel panel-default">
    
    <div class="panel-heading">
      <h1 class="panel-title">Welcome on your Project Manager</h1>
    </div>
    
    <div class="panel-body">
      <p>Here you can search for the project you want to see :</p>      
      <form id="form-search-projects" action="{{ route('projects.index') }}">
	<input type="text" class="form-control" placeholder="Typing a name, a company name or a leader name or email" v-model="q" @keyup="search()"/>
	<p></p>
	<div class="form-inline">
	  <div class="form-group">
	    <label for="betweenDate1">Find a project between the </label>
            <div class="input-group" id="betweenDate1">
              <input type="date" class="form-control" v-model="betweenDate1" @change="search()"/>
              <span class="input-group-addon">
                <span class="fa fa-calendar"></span>
              </span>	      
            </div>
          </div>
	  <div class="form-group">
	    <label for="betweenDate1">and the </label>
            <div class="input-group" id="betweenDate2">
              <input type="date" class="form-control" v-model="betweenDate2" @change="search()"/>
              <span class="input-group-addon">
                <span class="fa fa-calendar"></span>
              </span>
            </div>
          </div>
	  <p></p>
	  <div class="form-inline">	    
	    <div class="form-group">
	      <label for="priorityMin">Minimum priority </label>
	      <div class="input-group">
		<input class="form-control" id="priorityMin" type="range" min="0" :max="maxPriority" step="1" v-model="minPriority" @change="search()"/>
		<span class="input-group-addon">
                  @{{minPriority}}
		</span>
	      </div>
            </div>
	  </div>
	</div>
	<div class="form-inline pull-right">
	  <div class="form-group">
	    <label for="sortBy">Sort by : </label>
	    <div class="input-group">
	      <select id="sortBy" class="form-control" v-model="sortBy" @change="search()">
		<option value="name">Name</option>
		<option value="priority">Priority</option>
		<option value="startDate">Start date</option>	      
	      </select>
	      <span class="input-group-addon sort-dir" @click="changeDirSort()" :class="{ 'fa fa-sort-amount-asc': sortDir == 'desc', 'fa fa-sort-amount-desc': sortDir == 'asc'}"></span>
	    </div>
	  </div>
	</div>
	<p><br></p>
      </form>
      <hr>
      <p v-if="loading">Searching...</p>
      <div class="alert alert-danger" role="alert" v-if="error">
	<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	@{{ error }}
      </div>
      <div id="projects" class="row" data-url="{{ route('projects.show', '#') }}">
	<div class="project col-sm-6 col-lg-4" v-for="project in projects">
	  <a v-bind:href="url(project.id)" >
	    <h4 class="title">@{{ project.name }}</h4>
	    <p>
	      Leader :@{{ project.leader.firstname }} @{{ project.leader.lastname }}<br>
	      Priority : @{{ project.priority }}<br>
	      Client Company's name : @{{ truncate(project.clientCompanyName, '15') }}<br>
	      Performer Company's name : @{{truncate(project.performerCompanyName, '15') }}<br>
	      Comment : @{{ truncate(project.comment, '20') }}
	      From the @{{format(project.startDate)}} to the @{{format(project.endDate)}}
	    </p>
	  </a>
	</div>	
      </div>
      <div class="row">
	<div class="col-sm-12">
	  <nav aria-label="Page navigation">
	    <ul class="pagination">
	      <li :class="{ 'disabled': currentPage == 1 }">
		<a @click="previous()" href="#" aria-label="Previous">
		  <span aria-hidden="true">&laquo;</span>
		</a>
	      </li>
	      <li :class="{ 'active': currentPage == page }" v-for="page in lastPage"><a @click="go(page)" href="#">@{{page}}</a></li>
	      <li :class="{ 'disabled': currentPage == lastPage }">
		<a @click="next()" href="#" aria-label="Next">
		  <span aria-hidden="true">&raquo;</span>
		</a>
	      </li>
	    </ul>
	  </nav>
	</div>
      </div>
    </div>
  </div>
</div>

@endsection
