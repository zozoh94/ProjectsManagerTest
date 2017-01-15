<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $timestamps = false;

    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['firstname', 'lastname', 'email'];

    public function leadedProjects() 
    {
        return $this->hasMany('App\Project', 'leader_id');
    }
   
    public function performedProjects()
    {
        return $this->belongsToMany('App\Project');
    }

    public function scopeSearch($query, $q)
    {
        $keywords = explode(' ', $q);
        foreach($keywords as $keyword) {
            $query->orWhere('firstname', 'LIKE', $keyword.'%');
            $query->orWhere('lastname', 'LIKE', $keyword.'%');
            $query->orWhere('email', 'LIKE', $keyword.'%');
        }
        return $query;
    }
}
