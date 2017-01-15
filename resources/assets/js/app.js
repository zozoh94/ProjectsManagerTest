
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/*
 * Selectpicker
 */
require('select2');

/*
 * MomentJS
 */
window.moment = require('moment');

/*
 * Datetimepicker
 */
require('bootstrap-datetime-picker');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
  el: '#app',
  data: {
    projects: [],
    loading: false,
    error: false,   
    currentPage: 1,
    lastPage: 0,
    perPage: 12,
    q: '',
    betweenDate1: moment().format('YYYY-MM-DD'),
    betweenDate2: moment().add(1, 'years').format('YYYY-MM-DD'),
    minPriority: 0,
    maxPriority: 100,
    sortBy: 'name',
    sortDir: 'asc'
  },
  mounted: function() {
    if($('#projects').length > 0) {
      this.search();
    }
  },
  watch: {    
    projects: function(newProjects) {      
      this.maxPriority = Math.max.apply(Math,newProjects.map(function(o){return o.priority;}));
    }
  },
  methods: {
    search: function() {
      this.error = '';
      this.projects = [];
      this.loading = true;

      this.$http.get(
	$('#form-search-projects').attr('action')
	  + '?q=' + this.q
	  + '&betweenDate1=' + this.betweenDate1
	  + '&betweenDate2=' + this.betweenDate2
	  + '&minPriority=' + this.minPriority
	  + '&page=' + this.currentPage
	  + '&per_page=' + this.perPage
	  + '&sortBy=' + this.sortBy
	  + '&sortDir=' + this.sortDir
      ).then((response) => {	
	this.projects = response.body.data;
	this.loading = false;
	this.lastPage = response.body.last_page;
	this.currentPage = response.body.current_page;
	this.error = "";
	if(response.body.total == 0)
	  this.error = 'No results';
      });
    },
    next: function() {
      if(this.currentPage != this.lastPage) {
	this.currentPage++;
	this.search();
      }
    },
    previous: function() {
      if(this.currentPage != 1) {
	this.currentPage--;
	this.search();
      }
    },
    go: function(page) {
      this.currentPage = page;
      this.search();
    },    
    url: function(project) {      
      return $('#projects').attr('data-url').replace("#", project);
    },
    truncate: function(string, value) {
      if(string.length < value)
	return string;
      return string.substring(0, value) + '...';
    },
    format: function(date) {
      return moment(date).format('YYYY-MM-DD');
    },
    changeDirSort: function() {
      if(this.sortDir == 'asc')
	this.sortDir = 'desc';
      else
	this.sortDir = 'asc';
      this.search();
    }
  }
});

/**
 * JQuery components
 */
$(document).ready(function(){
  if(!Modernizr.inputtypes.datetime){
    $('.datetimepicker').datetimepicker({
      format: 'yyyy-mm-dd hh:ii',
      startDate: moment().format('YYYY-MM-DD HH:mm'),
      autoclose: true,
      todayHighlight: true,
      todayBtn: true,
      fontAwesome: true
    });
    $('#startDate').datetimepicker().on('changeDate', function(ev){
      $('#endDate').datetimepicker('setStartDate', moment(ev.date.valueOf()).format('YYYY-MM-DD HH:mm'));
    });
    $('#endDate').datetimepicker().on('changeDate', function(ev){
      $('#startDate').datetimepicker('setEndDate', moment(ev.date.valueOf()).format('YYYY-MM-DD HH:mm'));
    });
  }

  function formatEmployee(employee) {
    if(employee.loading)
      return $("<p>Searching...</p>");
    return $("<p>"+employee.firstname+" "+employee.lastname+"</p>");
  };

  function formatEmployeeS(employee) {
    if(employee.text)
      return employee.text;
    return employee.firstname+" "+employee.lastname;
  };
  if($('.leader-selectpicker').length > 0) {
    $('.leader-selectpicker').select2({
      ajax: {
	url: function (params) {
	  return $(this).attr('data-url');
	},
	dataType: 'json',
	data: function (params) {
	  return {
            q: params.term,
            page: params.page,
	    per_page: 4
	  };
	},
	processResults: function (data, params) {	 
	  return {
            results: data.data,
            pagination: {
              more: data.current_page !== data.last_page
            }
	  };
	},
      },
      cache: false,
      minimumInputLength: 1,
      templateResult: formatEmployee,
      templateSelection: formatEmployeeS,
      placeholder: "Leader",
      theme: 'bootstrap'
    });
  }
  if($('.performers-selectpicker').length > 0) {
    $('.performers-selectpicker').select2({
      ajax: {
	url: function (params) {
	  return $(this).attr('data-url');
	},
	dataType: 'json',
	data: function (params) {
	  return {
            q: params.term,
            page: params.page,
	    per_page: 4
	  };
	},
	processResults: function (data, params) {	 
	  return {
            results: data.data,
            pagination: {
              more: data.current_page !== data.last_page
            }
	  };
	},
      },
      cache: false,
      minimumInputLength: 1,
      templateResult: formatEmployee,
      templateSelection: formatEmployeeS,
      placeholder: "Performers",
      theme: 'bootstrap'
    });
  }
});
